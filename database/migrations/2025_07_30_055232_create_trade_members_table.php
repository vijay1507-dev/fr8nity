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
        Schema::create('trade_members', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('product_industry_category')->nullable();
            $table->json('shipping_frequency')->nullable(); // multiple values: daily, weekly, etc.
            $table->json('mode_of_shipment')->nullable(); // allow multiple modes: air, sea, land
            $table->unsignedBigInteger('origin_country')->nullable();
            $table->unsignedBigInteger('destination_country')->nullable();
            $table->string('estimated_shipment_volume')->nullable();
            $table->json('looking_for')->nullable(); // multiple values: speed, cost, etc.
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp_phone')->nullable();
            $table->text('additional_details')->nullable();
            $table->boolean('consent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_members');
    }
};
