<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Domain classes: Listing Type and its subtypes Sharing, Lending, Renting.
// The three subtypes are stored in one table; type_name says which subtype a row is,
// and only the subtype's own column is filled.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_types', function (Blueprint $table) {
            $table->id();                                                    // typeId
            $table->enum('type_name', ['Sharing', 'Lending', 'Renting'])->unique(); // typeName
            $table->boolean('is_free')->nullable();                          // Sharing.isFree
            $table->unsignedInteger('max_loan_days')->nullable();            // Lending.maxLoanDays
            $table->unsignedInteger('min_rental_days')->nullable();          // Renting.minRentalDays
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_types');
    }
};
