<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Domain class: Item Return
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_returns', function (Blueprint $table) {
            $table->id();                                                                  // returnId
            $table->foreignId('transaction_id')->unique()->constrained('transactions');    // Transaction is followed by Item Return, 0..1
            $table->date('return_date');                                                   // returnDate
            $table->enum('status', ['Awaiting Confirmation', 'Confirmed'])->default('Awaiting Confirmation'); // status
            $table->boolean('is_late')->default(false);                                    // isLate
            $table->timestamp('confirmed_at')->nullable();                                 // confirmedAt
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_returns');
    }
};
