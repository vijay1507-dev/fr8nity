<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('membership_logs', function (Blueprint $table) {
            // Update action enum to include new actions
            $table->enum('action', ['approve', 'update', 'change_tier', 'renewal', 'cancelled', 'renewed'])->change();
            
            // Update status enum to include new statuses
            $table->enum('status', ['upgrade', 'downgrade', 'renewal', 'initial', 'cancelled', 'renewed'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_logs', function (Blueprint $table) {
            // Revert action enum to original values
            $table->enum('action', ['approve', 'update', 'change_tier', 'renewal'])->change();
            
            // Revert status enum to original values
            $table->enum('status', ['upgrade', 'downgrade', 'renewal', 'initial'])->change();
        });
    }
};
