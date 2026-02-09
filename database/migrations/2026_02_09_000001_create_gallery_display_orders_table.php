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
        Schema::create('gallery_display_orders', function (Blueprint $table) {
            $table->id();
            $table->string('category', 64);
            $table->string('type', 16); // 'images' or 'videos'
            $table->json('order'); // array of item ids e.g. ["media_1_img_0", "media_2_img_0"]
            $table->timestamps();
            $table->unique(['category', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_display_orders');
    }
};
