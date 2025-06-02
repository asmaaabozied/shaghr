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
        Schema::create('chains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // User ID, indexed
            $table->string('name_en', 191); // Name in English
            $table->string('name_ar', 191); // Name in Arabic
            $table->tinyInteger('hotels_count')->nullable(); // Number of hotels in the chain, nullable
            $table->unsignedInteger('creator_id')->nullable(); // ID of the user who created the record
            $table->unsignedInteger('update_id')->nullable(); // ID of the user who updated the record
            $table->unsignedInteger('delete_id')->nullable(); // ID of the user who marked the record for deletion
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chains');
    }
};
