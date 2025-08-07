<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('string');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default reminder days setting
        DB::table('settings')->insert([
            'key' => 'membership_reminder_days',
            'value' => '15',
            'type' => 'integer',
            'description' => 'Number of days before membership expiry to start sending reminder emails',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};