<?php

namespace App\Http\Controllers;

use App\Models\ItemListing;

class HomeController extends Controller
{
    public function index()
    {
        $listings = ItemListing::where('listing_status', 'Published')
            ->where('availability', 'Available')
            ->with([
                'category',
                'listingType',
                'owner:id,name',
                'photos' => fn ($p) => $p->select('id', 'item_listing_id')->orderBy('id'),
            ])
            ->latest()
            ->limit(6)
            ->get();

        return view('home', compact('listings'));
    }
}