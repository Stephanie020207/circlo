<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Domain class: Student Account (Laravel's default "users" table is reused).
// The default "name" column holds fullName; "email" and "password" already exist.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_id')->nullable()->unique();          // studentId (null for admins)
            $table->string('phone_number')->nullable();                  // phoneNumber
            $table->string('campus_pickup_point')->nullable();           // campusPickupPoint
            $table->text('about')->nullable();                           // about
            $table->enum('account_status', ['Active', 'Suspended', 'Removed'])->default('Active'); // accountStatus
            $table->date('member_since')->default(DB::raw('CURRENT_DATE')); // memberSince
            $table->enum('role', ['student', 'admin'])->default('student'); // lets the Admin actor log in
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'student_id', 'phone_number', 'campus_pickup_point',
                'about', 'account_status', 'member_since', 'role',
            ]);
        });
    }
};
