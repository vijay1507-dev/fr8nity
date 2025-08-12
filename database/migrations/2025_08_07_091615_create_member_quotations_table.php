<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('member_quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver_id'); // Receiver of the quotation
            
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('alternate_email')->nullable();

            $table->string('uploaded_document')->nullable();

            $table->unsignedBigInteger('port_of_loading_id')->nullable();
            $table->unsignedBigInteger('port_of_discharge_id')->nullable();

            $table->json('specifications')->nullable();

            $table->text('message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_quotations');
    }
};