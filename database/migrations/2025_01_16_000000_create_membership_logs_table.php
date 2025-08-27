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
        Schema::create('membership_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('membership_tier_id')->nullable();
            $table->enum('action', ['approve', 'update', 'change_tier', 'renewal', 'cancelled', 'renewed']);
            
            // Previous values
            $table->string('previous_tier_name')->nullable();
            $table->string('previous_membership_number')->nullable();
            $table->string('previous_annual_fee')->nullable();
            $table->string('previous_annual_fee_currency')->nullable();
            $table->timestamp('previous_expiry_date')->nullable();
            $table->enum('previous_membership_status', ['active', 'cancelled', 'renewed'])->nullable();
            
            // New values
            $table->string('new_tier_name')->nullable();
            $table->string('new_membership_number')->nullable();
            $table->string('new_annual_fee')->nullable();
            $table->string('new_annual_fee_currency')->nullable();
            $table->timestamp('new_expiry_date')->nullable();
            $table->enum('new_membership_status', ['active', 'cancelled', 'renewed'])->nullable();
            
            // Status tracking
            $table->enum('status', ['upgrade', 'downgrade', 'renewal', 'initial', 'cancelled', 'renewed'])->nullable();
            $table->text('reason')->nullable();
            $table->json('metadata')->nullable();
            $table->unsignedBigInteger('changed_by');
            
            $table->timestamps();
            
            // Add indexes for better query performance
            $table->index(['user_id', 'created_at']);
            $table->index('action');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_logs');
    }
};
