<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharingRequest extends Model
{
    // Never mass-assigned from request input; controllers set every column explicitly.
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function itemListing()
    {
        return $this->belongsTo(ItemListing::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    // Inclusive number of days of the requested period
    public function days(): int
    {
        return (int) abs($this->end_date->diffInDays($this->start_date)) + 1;
    }

    public function totalPrice(): float
    {
        return $this->days() * (float) $this->itemListing->price_per_day;
    }
}
