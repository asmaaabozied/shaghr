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
        Schema::create('image_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('image_name')->nullable();
            $table->string('extension')->nullable();
            $table->string('image')->nullable();
            $table->string('size')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('published')->default(0);
            $table->boolean('status')->default(0);
            $table->longText('alternative_text_ar')->nullable();
            $table->longText('alternative_text_en')->nullable();
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
        Schema::dropIfExists('image_galleries');
    }
};
