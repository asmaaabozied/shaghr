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
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id');
                $table->foreignId('room_id');
                $table->foreignId('hotel_id');
                $table->dateTime('start_time');
                $table->dateTime('end_time')->nullable();
                $table->integer('time_slot'); // 3,6,9,12 hours
                $table->integer('price');
                $table->integer('number_people')->nullable();
                $table->integer('room_type_id');
                $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
