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
        Schema::create('membership_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('membership_tier_id')->constrained()->onDelete('cascade');
            
            // Renewal details
            $table->enum('renewal_type', ['renewal', 'early_renewal']);
            $table->enum('status', ['pending', 'active', 'cancelled', 'expired']);
            
            // Dates
            $table->timestamp('renewal_date')->useCurrent(); // When renewal was processed
            $table->timestamp('starts_at')->nullable(); // When this renewal becomes active
            $table->timestamp('expires_at')->nullable(); // When this renewal expires
            $table->timestamp('activated_at')->nullable(); // When renewal was actually activated
            
            // Previous membership info (for reference)
            $table->timestamp('previous_expires_at')->nullable();
            $table->string('previous_tier_name')->nullable();
            
            // Renewal metadata
            $table->text('reason')->nullable();
            $table->json('metadata')->nullable();
            
            // Admin tracking
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('activated_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index(['starts_at', 'status']);
            $table->index('renewal_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_renewals');
    }
};
