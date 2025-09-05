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
            $table->enum('action', ['approve', 'update', 'change_tier', 'renewal', 'cancelled', 'renewed', 'pending'])->change();
            $table->enum('status', ['approve', 'upgrade', 'downgrade', 'renewal', 'initial', 'cancelled', 'renewed', 'pending'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_logs', function (Blueprint $table) {
            $table->enum('action', ['approve', 'update', 'change_tier', 'renewal', 'cancelled', 'renewed'])->change();
            $table->enum('status', ['approve','upgrade', 'downgrade', 'renewal', 'initial', 'cancelled', 'renewed'])->change();
        });
    }
};
