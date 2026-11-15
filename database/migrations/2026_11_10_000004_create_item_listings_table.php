<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Domain class: Item Listing
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_listings', function (Blueprint $table) {
            $table->id();                                                                  // listingId
            $table->foreignId('owner_id')->constrained('users');                           // Student owns (as owner) Item Listing
            $table->foreignId('category_id')->constrained('categories');                   // belongs to Category
            $table->foreignId('listing_type_id')->constrained('listing_types');            // is offered as Listing Type
            $table->string('item_name');                                                   // itemName
            $table->text('description');                                                   // description
            $table->enum('condition', ['New', 'Like new', 'Good', 'Fair']);                // condition
            $table->decimal('price_per_day', 10, 2)->default(0);                           // pricePerDay (0 for free sharing)
            $table->string('pickup_location');                                             // pickupLocation
            $table->enum('availability', ['Available', 'Booked'])->default('Available');   // availability
            $table->enum('listing_status', ['Published', 'Removed'])->default('Published');// listingStatus
            $table->date('listed_date')->default(DB::raw('CURRENT_DATE'));                 // listedDate
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_listings');
    }
};
