<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ItemListing;
use App\Models\ListingType;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    // UI-05 Explore: search and filter
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));

        $listings = ItemListing::query()
            ->where('listing_status', 'Published')
            ->when($q !== '', function ($query) use ($q) {
                $like = '%' . addcslashes($q, '%_\\') . '%';
                $query->where(fn ($w) => $w->where('item_name', 'ilike', $like)
                    ->orWhere('description', 'ilike', $like));
            })
            ->when($request->filled('category_id'),
                fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->when($request->filled('listing_type_id'),
                fn ($query) => $query->where('listing_type_id', $request->integer('listing_type_id')))
            ->when(in_array($request->query('availability'), ['Available', 'Booked'], true),
                fn ($query) => $query->where('availability', $request->query('availability')))
            ->with([
                'category',
                'listingType',
                'owner:id,name',
                'photos' => fn ($p) => $p->select('id', 'item_listing_id')->orderBy('id'),
            ])
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('explore.index', [
            'listings' => $listings,
            'categories' => Category::orderBy('category_name')->pluck('category_name', 'id'),
            'types' => ListingType::orderBy('id')->pluck('type_name', 'id'),
            'hasFilters' => $request->hasAny(['q', 'category_id', 'listing_type_id', 'availability'])
                && ($q !== '' || $request->filled('category_id') || $request->filled('listing_type_id') || $request->filled('availability')),
        ]);
    }

    // UI-06 Item Detail
    public function show(ItemListing $listing)
    {
        // Spec alternate flow: a removed item shows a message and returns to Explore
        if ($listing->listing_status === 'Removed') {
            return redirect()->route('explore.index')->with('error', 'This item is no longer available.');
        }

        $listing->load([
            'category',
            'listingType',
            'owner:id,name,member_since',
            'photos' => fn ($p) => $p->select('id', 'item_listing_id')->orderBy('id'),
        ]);

        return view('explore.show', compact('listing'));
    }
}