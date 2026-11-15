<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemListing extends Model
{
    protected $fillable = [
        'category_id', 'listing_type_id', 'item_name', 'description',
        'condition', 'price_per_day', 'pickup_location',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function listingType()
    {
        return $this->belongsTo(ListingType::class);
    }

    public function photos()
    {
        return $this->hasMany(ListingPhoto::class);
    }

    // Spec alternate flow: a listing in an active transaction cannot be edited or deleted
    public function hasActiveTransaction(): bool
    {
        return DB::table('transactions')
            ->join('sharing_requests', 'sharing_requests.id', '=', 'transactions.sharing_request_id')
            ->where('sharing_requests.item_listing_id', $this->id)
            ->where('transactions.status', 'Active')
            ->exists();
    }
}