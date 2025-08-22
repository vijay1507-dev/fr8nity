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
        Schema::table('membership_tiers', function (Blueprint $table) {
            $table->string('annual_fee_currency')->nullable()->after('annual_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_tiers', function (Blueprint $table) {
            $table->dropColumn('annual_fee_currency');
        });
    }
};
