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
        Schema::table('member_quotations', function (Blueprint $table) {
            $table->unsignedBigInteger('given_by_id')->after('receiver_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_quotations', function (Blueprint $table) {
            $table->dropColumn('given_by_id');
        });
    }
};
