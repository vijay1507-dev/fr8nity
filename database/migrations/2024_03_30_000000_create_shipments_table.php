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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->json('shipment_type')->nullable();
            $table->string('mode_of_transport')->nullable();
            $table->text('goods_description')->nullable();
            $table->string('estimated_volume')->nullable();
            $table->date('cargo_ready_date')->nullable();
            $table->string('documents')->nullable();
            $table->unsignedBigInteger('pickup_country_id')->nullable();
            $table->unsignedBigInteger('pickup_city_id')->nullable();
            $table->unsignedBigInteger('destination_country_id')->nullable();
            $table->unsignedBigInteger('destination_city_id')->nullable();
            $table->text('special_notes')->nullable();
            $table->text('delivery_remark')->nullable();
            $table->boolean('consent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
}; 