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
        Schema::table('users', function (Blueprint $table) {
            $table->string('designation')->after('name');
            $table->string('whatsapp_phone')->after('email');
            $table->string('company_name')->after('whatsapp_phone');
            $table->string('company_telephone')->after('company_name');
            $table->text('company_address')->after('company_telephone');
            $table->unsignedBigInteger('country_id')->nullable()->after('company_address');
            $table->unsignedBigInteger('city_id')->nullable()->after('country_id');
            $table->unsignedBigInteger('region_id')->nullable()->after('city_id');
            $table->string('referred_by')->nullable()->after('region_id');
            $table->json('specializations')->nullable()->after('referred_by'); // Air, Sea, Land, Multimodal, Project Cargo
            $table->date('incorporation_date')->nullable()->after('specializations');
            $table->string('tax_id')->nullable()->after('incorporation_date');
            $table->string('website_linkedin')->nullable()->after('tax_id');
            $table->json('looking_for')->nullable()->after('website_linkedin');
            $table->enum('is_network_member', ['yes', 'no'])->default('no')->after('website_linkedin');
            $table->string('network_name')->nullable()->after('is_network_member');
            $table->unsignedBigInteger('membership_tier')->nullable()->after('network_name');
            $table->enum('status', ['pending', 'approved'])->default('pending')->after('membership_tier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'membership_tier',
                'network_name',
                'is_network_member',
                'looking_for',
                'website_linkedin',
                'tax_id',
                'incorporation_date',
                'specializations',
                'referred_by',
                'region_id',
                'city_id',
                'country_id',
                'company_address',
                'company_telephone',
                'company_name',
                'whatsapp_phone',
                'designation',
            ]);
        });
    }
}; 