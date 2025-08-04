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
        Schema::create('membership_tier_rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membership_tier_id'); // Removed foreign key constraint
            $table->string('activity_type'); // e.g., referral_join
            $table->integer('points');
            $table->decimal('multiplier', 4, 2)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_tier_rewards');
    }
};