<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seeder_history', function (Blueprint $table) {
            $table->id();
            $table->string('seeder');
            $table->integer('batch');
            $table->timestamp('seeded_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seeder_history');
    }
}; 