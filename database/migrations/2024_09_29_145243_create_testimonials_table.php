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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->date('submission_date')->nullable();
            $table->string('rating', 191)->nullable();
            $table->boolean('Published')->default(0);
            $table->boolean('active')->default(0);
            $table->enum('Status',array('Pending','Approved','Not Approved'))->nullable();
            $table->longText('review_text_ar')->nullable();
            $table->longText('review_text_en')->nullable();
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
        Schema::dropIfExists('testimonials');
    }
};
