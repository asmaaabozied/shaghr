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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chain_id')->unsigned()->index();
            $table->string('name_en', 191)->nullable();
            $table->string('name_ar', 191)->nullable();
            $table->string('total_rooms')->nullable();
            $table->string('image')->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('address', 191)->nullable();
            $table->longText('descripton_en')->nullable();
            $table->longText('descripton_ar')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->bigInteger('country_id')->unsigned()->index();
            $table->bigInteger('city_id')->unsigned()->index();
            $table->bigInteger('district_id')->unsigned()->index();
            $table->string('street', 255)->nullable();
            $table->string('building_number', 255)->nullable();
            $table->boolean('status')->default(0);
            $table->integer('creator_id')->nullable();
            $table->integer('update_id')->nullable();
            $table->integer('delete_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
