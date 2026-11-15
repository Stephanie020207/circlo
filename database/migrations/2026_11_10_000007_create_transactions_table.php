<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Domain class: Transaction (Transaction History is not a table, see the note in the guide)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();                                                                   // transactionId
            $table->foreignId('sharing_request_id')->unique()->constrained('sharing_requests'); // becomes (when accepted), 0..1
            $table->date('start_date');                                                     // startDate
            $table->date('end_date');                                                       // endDate
            $table->enum('status', ['Active', 'Completed'])->default('Active');             // status
            $table->decimal('total_price', 12, 2)->default(0);                              // totalPrice
            $table->timestamp('completed_at')->nullable();                                  // completedAt
            $table->timestamps();                                                           // created_at = createdAt
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
