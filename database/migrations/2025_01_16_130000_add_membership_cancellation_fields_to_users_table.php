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
        Schema::table('users', function (Blueprint $table) {
            // Add cancelled_at timestamp for when membership was cancelled
            $table->timestamp('cancelled_at')->nullable()->after('status');
            
            // Add cancellation_reason for tracking why membership was cancelled
            $table->text('cancellation_reason')->nullable()->after('cancelled_at');
            
            // Add cancelled_by to track who cancelled the membership (no foreign key constraint)
            $table->unsignedBigInteger('cancelled_by')->nullable()->after('cancellation_reason');
        });
        
        // Update existing status enum to include 'cancelled'
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('pending', 'approved', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'cancelled_at',
                'cancellation_reason',
                'cancelled_by'
            ]);
        });
        
        // Revert status enum to original values
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('pending', 'approved') DEFAULT 'pending'");
    }
};
