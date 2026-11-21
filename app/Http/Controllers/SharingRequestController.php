<?php

namespace App\Http\Controllers;

use App\Models\ItemListing;
use App\Models\SharingRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SharingRequestController extends Controller
{
    // Incoming requests for the logged-in user's own items (lender side); each row opens UI-12
    public function index()
    {
        $requests = SharingRequest::whereHas('itemListing', fn ($l) => $l->where('owner_id', auth()->id()))
            ->with([
                'requester:id,name',
                'itemListing.photos' => fn ($p) => $p->select('id', 'item_listing_id')->orderBy('id'),
            ])
            ->orderByRaw("CASE status WHEN 'Pending' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        return view('requests.index', compact('requests'));
    }

    // UI-11 Request Item (form)
    public function create(ItemListing $listing)
    {
        if ($blocked = $this->blockReason($listing)) {
            return redirect()->route('explore.show', $listing)->with('error', $blocked);
        }

        $listing->load([
            'category',
            'listingType',
            'owner:id,name',
            'photos' => fn ($p) => $p->select('id', 'item_listing_id')->orderBy('id'),
        ]);

        return view('requests.create', compact('listing'));
    }

    // UI-11 submit: creates a Pending Sharing Request, then goes to UI-13
    public function store(Request $request, ItemListing $listing)
    {
        if ($blocked = $this->blockReason($listing)) {
            return redirect()->route('explore.show', $listing)->with('error', $blocked);
        }

        $data = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'note' => 'nullable|string|max:500',
        ], [
            'start_date.required' => 'Please choose a start date.',
            'start_date.after_or_equal' => 'The start date cannot be in the past.',
            'end_date.required' => 'Please choose an end date.',
            'end_date.after_or_equal' => 'The end date must not be earlier than the start date.',
            'note.max' => 'The note can be at most 500 characters.',
        ]);

        if ($this->overlapsAccepted($listing->id, $data['start_date'], $data['end_date'])) {
            return back()->withInput()->withErrors([
                'start_date' => 'This item is not available for the chosen period. Please choose another period.',
            ]);
        }

        $req = new SharingRequest();
        $req->requester_id = auth()->id();
        $req->item_listing_id = $listing->id;
        $req->start_date = $data['start_date'];
        $req->end_date = $data['end_date'];
        $req->note = $data['note'] ?? null;
        $req->status = 'Pending';
        $req->save();

        return redirect()->route('transactions.index', ['tab' => 'pending'])
            ->with('success', 'Your request has been sent. The owner will review it.');
    }

    // UI-12 Request Detail (owner only)
    public function show(SharingRequest $sharingRequest)
    {
        $this->ownerOnly($sharingRequest);

        $sharingRequest->load([
            'requester:id,name,email,member_since',
            'itemListing.category',
            'itemListing.listingType',
            'itemListing.photos' => fn ($p) => $p->select('id', 'item_listing_id')->orderBy('id'),
        ]);

        return view('requests.show', ['req' => $sharingRequest]);
    }

    public function accept(SharingRequest $sharingRequest)
    {
        $this->ownerOnly($sharingRequest);

        $error = DB::transaction(function () use ($sharingRequest) {
            $req = SharingRequest::whereKey($sharingRequest->id)->lockForUpdate()->first();
            $listing = ItemListing::whereKey($req->item_listing_id)->lockForUpdate()->first();

            if ($req->status !== 'Pending') {
                return 'This request can no longer be accepted (status: ' . $req->status . ').';
            }
            if ($listing->listing_status !== 'Published' || $listing->availability !== 'Available') {
                return 'This item is no longer available, so the request cannot be accepted.';
            }
            if ($this->overlapsAccepted($listing->id, $req->start_date->toDateString(), $req->end_date->toDateString(), $req->id)) {
                return 'Another accepted request already covers this period, so this request cannot be accepted.';
            }

            $req->status = 'Accepted';
            $req->save();

            $transaction = new Transaction();
            $transaction->sharing_request_id = $req->id;
            $transaction->start_date = $req->start_date;
            $transaction->end_date = $req->end_date;
            $transaction->status = 'Active';
            $transaction->total_price = $req->days() * (float) $listing->price_per_day;
            $transaction->save();

            $listing->availability = 'Booked';
            $listing->save();

            return null;
        });

        if ($error) {
            return redirect()->route('requests.show', $sharingRequest)->with('error', $error);
        }

        return redirect()->route('requests.show', $sharingRequest)
            ->with('success', 'Request accepted. A transaction has been created.');
    }

    public function reject(Request $request, SharingRequest $sharingRequest)
    {
        $this->ownerOnly($sharingRequest);

        $data = $request->validate(['rejection_reason' => 'nullable|string|max:255']);

        if ($sharingRequest->status !== 'Pending') {
            return redirect()->route('requests.show', $sharingRequest)
                ->with('error', 'This request can no longer be rejected (status: ' . $sharingRequest->status . ').');
        }

        $sharingRequest->status = 'Rejected';
        $sharingRequest->rejection_reason = $data['rejection_reason'] ?? null;
        $sharingRequest->save();

        return redirect()->route('requests.show', $sharingRequest)->with('success', 'Request rejected.');
    }

    // Borrower cancels their own pending request (from UI-13)
    public function cancel(SharingRequest $sharingRequest)
    {
        abort_unless((int) $sharingRequest->requester_id === (int) auth()->id(), 403);

        if ($sharingRequest->status !== 'Pending') {
            return redirect()->route('transactions.index', ['tab' => 'pending'])
                ->with('error', 'This request can no longer be cancelled because the owner has already decided.');
        }

        $sharingRequest->status = 'Cancelled';
        $sharingRequest->save();

        return redirect()->route('transactions.index', ['tab' => 'pending'])->with('success', 'Request cancelled.');
    }

    // ---------- helpers ----------

    private function ownerOnly(SharingRequest $sharingRequest): void
    {
        $sharingRequest->loadMissing('itemListing');
        abort_unless((int) $sharingRequest->itemListing->owner_id === (int) auth()->id(), 403);
    }

    // Returns a message when the current user cannot request this listing, otherwise null
    private function blockReason(ItemListing $listing): ?string
    {
        if ($listing->listing_status === 'Removed') {
            return 'This item is no longer available.';
        }
        if ((int) $listing->owner_id === (int) auth()->id()) {
            return 'You cannot request your own item.';
        }
        if ($listing->availability === 'Booked') {
            return 'This item is currently borrowed.';
        }
        $hasPending = SharingRequest::where('item_listing_id', $listing->id)
            ->where('requester_id', auth()->id())
            ->where('status', 'Pending')
            ->exists();
        if ($hasPending) {
            return 'You already have a pending request for this item. You can see it in My Transactions.';
        }

        return null;
    }

    private function overlapsAccepted(int $listingId, string $start, string $end, ?int $exceptId = null): bool
    {
        return SharingRequest::where('item_listing_id', $listingId)
            ->where('status', 'Accepted')
            ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
            ->whereDate('start_date', '<=', $end)
            ->whereDate('end_date', '>=', $start)
            ->exists();
    }
}
