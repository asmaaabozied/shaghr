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
        Schema::create('verification_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chain_id'); // Reference to hotel chain
            $table->string('document_name'); // Original name of the document
            $table->string('document_path'); // Path to the document
            $table->string('status')->default('pending'); // Document status (e.g., pending, approved, rejected)
            $table->unsignedInteger('creator_id')->nullable(); // ID of the user who created the record
            $table->unsignedInteger('update_id')->nullable(); // ID of the user who updated the record
            $table->unsignedInteger('delete_id')->nullable(); // ID of the user who marked the record for deletion

            $table->timestamps();

            $table->foreign('chain_id')->references('id')->on('chains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_documents');
    }
};
