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
            $table->decimal('transaction_value', 15, 2)->nullable()->after('message');
            $table->tinyInteger('status')->nullable()->comment('0: Enquiry closed unsuccessfully, 1: Enquiry closed successfully')->after('transaction_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_quotations', function (Blueprint $table) {
            $table->dropColumn(['transaction_value', 'status']);
        });
    }
};
