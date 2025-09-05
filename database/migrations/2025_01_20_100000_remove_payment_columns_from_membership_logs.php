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
            // Remove payment-related columns
            // Check if columns exist before dropping them
            if (Schema::hasColumn('membership_logs', 'days_before_expiry')) {
                $table->dropColumn('days_before_expiry');
            }
            if (Schema::hasColumn('membership_logs', 'renewal_fee_paid')) {
                $table->dropColumn('renewal_fee_paid');
            }
            if (Schema::hasColumn('membership_logs', 'renewal_fee_currency')) {
                $table->dropColumn('renewal_fee_currency');
            }
            if (Schema::hasColumn('membership_logs', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('membership_logs', 'payment_reference')) {
                $table->dropColumn('payment_reference');
            }
            if (Schema::hasColumn('membership_logs', 'admin_notes')) {
                $table->dropColumn('admin_notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_logs', function (Blueprint $table) {
            // Re-add the columns in case of rollback
            $table->integer('days_before_expiry')->nullable()->after('renewal_type');
            $table->decimal('renewal_fee_paid', 10, 2)->nullable()->after('renewal_processed_at');
            $table->string('renewal_fee_currency', 3)->default('USD')->after('renewal_fee_paid');
            $table->string('payment_method')->nullable()->after('renewal_fee_currency');
            $table->string('payment_reference')->nullable()->after('payment_method');
            $table->text('admin_notes')->nullable()->after('payment_reference');
        });
    }
};
