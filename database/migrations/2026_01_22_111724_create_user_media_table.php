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
        Schema::create('user_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('email'); // Auto-filled from user
            $table->enum('role', ['simpleuser', 'admin'])->default('simpleuser'); // Auto-filled from user
            $table->json('images')->nullable(); // Array of image file paths
            $table->json('videos')->nullable(); // Array of video file paths
            $table->string('category')->nullable(); // Category like 'roka', 'shagun', etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_media');
    }
};
