<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('membership_benefits', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('membership_tier_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_tier_id')->constrained()->onDelete('cascade');
            $table->foreignId('membership_benefit_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('membership_tier_benefits');
        Schema::dropIfExists('membership_benefits');
    }
}; 