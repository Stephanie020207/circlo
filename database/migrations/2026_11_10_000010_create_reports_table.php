<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Domain classes: Report and its subtypes User Report, Listing Report (one table, report_type tells which).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();                                                          // reportId
            $table->foreignId('reporter_id')->constrained('users');                // Student files Report
            $table->enum('report_type', ['user', 'listing']);                      // User Report or Listing Report
            $table->string('reason');                                              // reason (Enum values still to be decided)
            $table->text('description');                                           // description
            $table->binary('evidence_file')->nullable();                           // evidenceFile (optional), bytea
            $table->enum('severity', ['Low', 'Medium', 'High'])->default('Low');   // severity
            $table->enum('status', ['Pending', 'Resolved'])->default('Pending');   // status
            $table->foreignId('target_account_id')->nullable()->constrained('users');          // User Report targets Student Account
            $table->foreignId('target_listing_id')->nullable()->constrained('item_listings');  // Listing Report targets Item Listing
            $table->timestamps();                                                  // created_at = createdAt
        });

        DB::statement("ALTER TABLE reports ADD CONSTRAINT reports_target_check CHECK (
            (report_type = 'user' AND target_account_id IS NOT NULL AND target_listing_id IS NULL)
            OR (report_type = 'listing' AND target_listing_id IS NOT NULL AND target_account_id IS NULL)
        )");
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
