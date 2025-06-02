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
        Schema::create('room_comments', function (Blueprint $table) {
            $table->id();
            $table->string('rating')->nullable();
            $table->bigInteger('room_id')->unsigned()->index();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->integer('view')->nullable();
            $table->boolean('status')->default(0);
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
            $table->softUserstamps();      
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_comments');
    }
};
