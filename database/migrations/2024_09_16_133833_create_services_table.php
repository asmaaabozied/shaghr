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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar', 191)->nullable();
            $table->string('name_en', 191)->nullable();
            $table->string('type', 191)->nullable();
            $table->boolean('active')->default(0);
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('image', 191)->nullable();
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
        Schema::dropIfExists('services');
    }
};
