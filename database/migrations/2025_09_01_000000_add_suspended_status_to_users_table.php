<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing status enum to include 'suspended'
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('pending', 'approved', 'cancelled', 'suspended') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert status enum to original values (without suspended)
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('pending', 'approved', 'cancelled') DEFAULT 'pending'");
    }
};