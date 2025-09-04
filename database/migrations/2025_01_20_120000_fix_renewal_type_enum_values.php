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
        // First, update any existing data that might have invalid renewal_type values
        DB::table('membership_logs')
            ->whereNotNull('renewal_type')
            ->whereNotIn('renewal_type', ['renewal', 'early_renewal'])
            ->update(['renewal_type' => 'renewal']);

        // Update any 'early' values to 'early_renewal'
        DB::table('membership_logs')
            ->where('renewal_type', 'early')
            ->update(['renewal_type' => 'early_renewal']);

        // Update any 'regular' values to 'renewal'
        DB::table('membership_logs')
            ->where('renewal_type', 'regular')
            ->update(['renewal_type' => 'renewal']);

        // Now modify the enum to ensure it only accepts the correct values
        Schema::table('membership_logs', function (Blueprint $table) {
            $table->enum('renewal_type', ['renewal', 'early_renewal'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the enum to include the old values
        Schema::table('membership_logs', function (Blueprint $table) {
            $table->enum('renewal_type', ['regular', 'early', 'expired', 'cancelled_renewal', 'renewal', 'early_renewal'])->nullable()->change();
        });
    }
};
