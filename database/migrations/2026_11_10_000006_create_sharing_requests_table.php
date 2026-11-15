<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Domain class: Sharing Request
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sharing_requests', function (Blueprint $table) {
            $table->id();                                                           // requestId
            $table->foreignId('requester_id')->constrained('users');                // Student submits (as borrower)
            $table->foreignId('item_listing_id')->constrained('item_listings');     // requests Item Listing
            $table->date('start_date');                                             // startDate
            $table->date('end_date');                                               // endDate
            $table->text('note')->nullable();                                       // note
            $table->enum('status', ['Pending', 'Accepted', 'Rejected', 'Cancelled'])->default('Pending'); // status
            $table->text('rejection_reason')->nullable();                           // rejectionReason
            $table->timestamps();                                                   // created_at = createdAt
        });

        DB::statement('ALTER TABLE sharing_requests ADD CONSTRAINT sharing_requests_period_check CHECK (end_date >= start_date)');
    }

    public function down(): void
    {
        Schema::dropIfExists('sharing_requests');
    }
};
