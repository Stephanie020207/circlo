<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Domain classes: Review and its subtypes Item Review, User Review (one table, review_type tells which).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();                                                          // reviewId
            $table->foreignId('transaction_id')->constrained('transactions');      // Transaction is followed by Review
            $table->foreignId('author_id')->constrained('users');                  // Student Account writes Review
            $table->enum('review_type', ['item', 'user']);                         // Item Review or User Review
            $table->unsignedSmallInteger('rating');                                // rating (1 to 5)
            $table->text('review_text')->nullable();                               // reviewText
            $table->unsignedSmallInteger('item_condition_rating')->nullable();     // ItemReview.itemConditionRating
            $table->unsignedSmallInteger('communication_rating')->nullable();      // UserReview.communicationRating
            $table->unsignedSmallInteger('punctuality_rating')->nullable();        // UserReview.punctualityRating
            $table->foreignId('item_listing_id')->nullable()->constrained('item_listings'); // Item Review rates Item Listing
            $table->foreignId('reviewed_account_id')->nullable()->constrained('users');     // User Review rates Student Account
            $table->timestamps();                                                  // created_at = createdAt

            // A Student can review a given target of a Transaction only once.
            $table->unique(['transaction_id', 'author_id', 'review_type']);
        });

        DB::statement('ALTER TABLE reviews ADD CONSTRAINT reviews_rating_check CHECK (rating BETWEEN 1 AND 5)');
        DB::statement("ALTER TABLE reviews ADD CONSTRAINT reviews_target_check CHECK (
            (review_type = 'item' AND item_listing_id IS NOT NULL AND reviewed_account_id IS NULL)
            OR (review_type = 'user' AND reviewed_account_id IS NOT NULL AND item_listing_id IS NULL)
        )");
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
