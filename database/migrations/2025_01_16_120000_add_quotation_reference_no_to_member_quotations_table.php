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
            $table->string('quotation_reference_no')->nullable()->after('id');
            $table->index('quotation_reference_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_quotations', function (Blueprint $table) {
            $table->dropIndex(['quotation_reference_no']);
            $table->dropColumn('quotation_reference_no');
        });
    }
};
