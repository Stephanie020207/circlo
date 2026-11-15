<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Domain attribute: Item Listing.photos : Bytea[1..5]
// Stored as one row per photo (bytea column). The limit of 5 per listing is enforced in the app.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_listing_id')->constrained('item_listings')->cascadeOnDelete();
            $table->binary('photo');   // becomes bytea on PostgreSQL
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_photos');
    }
};
