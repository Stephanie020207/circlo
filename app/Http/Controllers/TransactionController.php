<?php

namespace App\Http\Controllers;

use App\Models\SharingRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // UI-13 My Transactions (Pending / Active / Completed tabs)
    public function index(Request $request)
    {
        $uid = auth()->id();
        $tab = in_array($request->query('tab'), ['pending', 'active', 'completed'], true)
            ? $request->query('tab') : 'pending';

        $photos = fn ($p) => $p->select('id', 'item_listing_id')->orderBy('id');

        // Transactions where the user is the borrower or the owner
        $transactionsOf = fn (string $status) => Transaction::where('status', $status)
            ->whereHas('sharingRequest', function ($q) use ($uid) {
                $q->where(function ($w) use ($uid) {
                    $w->where('requester_id', $uid)
                      ->orWhereHas('itemListing', fn ($l) => $l->where('owner_id', $uid));
                });
            });

        $counts = [
            'pending' => SharingRequest::where('requester_id', $uid)->where('status', 'Pending')->count(),
            'active' => $transactionsOf('Active')->count(),
            'completed' => $transactionsOf('Completed')->count(),
        ];

        $requests = collect();
        $transactions = collect();

        if ($tab === 'pending') {
            // Pending requests, plus rejected ones so the borrower sees the decision
            $requests = SharingRequest::where('requester_id', $uid)
                ->whereIn('status', ['Pending', 'Rejected'])
                ->with(['itemListing.owner:id,name', 'itemListing.photos' => $photos])
                ->latest()
                ->get();
        } else {
            $transactions = $transactionsOf($tab === 'active' ? 'Active' : 'Completed')
                ->with([
                    'sharingRequest.requester:id,name',
                    'sharingRequest.itemListing.owner:id,name',
                    'sharingRequest.itemListing.photos' => $photos,
                ])
                ->latest()
                ->get();
        }

        // Shortcut to UI-12 for owners until the "Active Requests" tab of My Items exists
        $incoming = SharingRequest::where('status', 'Pending')
            ->whereHas('itemListing', fn ($l) => $l->where('owner_id', $uid))
            ->with(['requester:id,name', 'itemListing:id,item_name'])
            ->latest()
            ->get();

        return view('transactions.index', compact('tab', 'counts', 'requests', 'transactions', 'incoming'));
    }
}
