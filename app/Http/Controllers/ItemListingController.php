<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ItemListing;
use App\Models\ListingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemListingController extends Controller
{
    // UI-07 My Items
    public function index()
    {
        $listings = ItemListing::where('owner_id', auth()->id())
            ->where('listing_status', 'Published')
            ->with([
                'category',
                'listingType',
                // load only photo ids, never the image bytes
                'photos' => fn ($q) => $q->select('id', 'item_listing_id'),
            ])
            ->latest()
            ->get();

        return view('listings.index', compact('listings'));
    }

    // UI-08 Add New Item (form)
    public function create()
    {
        return view('listings.create', $this->formData());
    }

    // UI-08 save, then UI-09 Item Preview
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(photosRequired: true), $this->messages());

        $listing = DB::transaction(function () use ($validated, $request) {
            $listing = new ItemListing(collect($validated)->except('photos')->all());
            $listing->owner_id = auth()->id();
            $listing->save();

            $this->storePhotos($listing, $request->file('photos'));

            return $listing;
        });

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Your item is now live. Students can find and request it.');
    }

    // UI-09 Item Preview
    public function show(ItemListing $listing)
    {
        $this->ownedListing($listing);

        $listing->load([
            'category',
            'listingType',
            'photos' => fn ($q) => $q->select('id', 'item_listing_id'),
        ]);

        return view('listings.show', compact('listing'));
    }

    // UI-10 Edit Item (form)
    public function edit(ItemListing $listing)
    {
        $this->ownedListing($listing);

        if ($listing->hasActiveTransaction()) {
            return $this->blockedByTransaction();
        }

        return view('listings.edit', ['listing' => $listing] + $this->formData());
    }

    public function update(Request $request, ItemListing $listing)
    {
        $this->ownedListing($listing);

        if ($listing->hasActiveTransaction()) {
            return $this->blockedByTransaction();
        }

        $validated = $request->validate($this->rules(photosRequired: false), $this->messages());

        DB::transaction(function () use ($validated, $request, $listing) {
            $listing->update(collect($validated)->except('photos')->all());

            // New photos replace the old ones
            if ($request->hasFile('photos')) {
                $listing->photos()->delete();
                $this->storePhotos($listing, $request->file('photos'));
            }
        });

        return redirect()->route('listings.show', $listing)->with('success', 'Listing updated.');
    }

    public function destroy(ItemListing $listing)
    {
        $this->ownedListing($listing);

        if ($listing->hasActiveTransaction()) {
            return $this->blockedByTransaction();
        }

        $listing->listing_status = 'Removed';
        $listing->save();

        return redirect()->route('listings.index')->with('success', 'Listing removed.');
    }

    // ---------- helpers ----------

    private function ownedListing(ItemListing $listing): void
    {
        abort_unless((int) $listing->owner_id === (int) auth()->id(), 403);
        abort_if($listing->listing_status === 'Removed', 404);
    }

    private function blockedByTransaction()
    {
        return redirect()->route('listings.index')->with(
            'error',
            'This listing is in an active transaction. You can edit or delete it after the transaction is completed.'
        );
    }

    private function formData(): array
    {
        return [
            'categories' => Category::orderBy('category_name')->pluck('category_name', 'id'),
            'types' => ListingType::orderBy('id')->pluck('type_name', 'id'),
        ];
    }

    private function rules(bool $photosRequired): array
    {
        return [
            'item_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'listing_type_id' => 'required|exists:listing_types,id',
            'condition' => 'required|in:New,Like new,Good,Fair',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'pickup_location' => 'required|string|max:255',
            'photos' => ($photosRequired ? 'required' : 'nullable') . '|array|max:5',
            'photos.*' => 'file|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    private function messages(): array
    {
        return [
            'item_name.required' => 'Please enter the item name.',
            'category_id.required' => 'Please choose a category.',
            'listing_type_id.required' => 'Please choose a transaction type.',
            'photos.required' => 'Please upload at least one photo.',
            'photos.max' => 'You can upload up to 5 photos.',
            'photos.*.mimes' => 'Each photo must be a JPG or PNG image.',
            'photos.*.max' => 'Each photo must be 5 MB or smaller.',
            'photos.*.uploaded' => 'A photo could not be uploaded. It may be too large.',
        ];
    }

    // photos.photo is a bytea column, so we pass the file as a stream
    private function storePhotos(ItemListing $listing, array $files): void
    {
        foreach ($files as $file) {
            $stream = fopen($file->getRealPath(), 'rb');
            $listing->photos()->create(['photo' => $stream]);
            fclose($stream);
        }
    }
}