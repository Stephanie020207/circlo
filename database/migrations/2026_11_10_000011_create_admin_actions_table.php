<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Domain class: Admin Action
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_actions', function (Blueprint $table) {
            $table->id();                                                                  // actionId
            $table->foreignId('admin_id')->constrained('users');                           // Admin performs Admin Action (performedBy)
            $table->foreignId('report_id')->unique()->constrained('reports');              // Admin Action resolves Report
            $table->enum('action_type', ['Dismiss', 'Remove listing', 'Suspend user']);    // actionType
            $table->text('action_note')->nullable();                                       // actionNote
            $table->timestamp('action_date')->useCurrent();                                // actionDate
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_actions');
    }
};
