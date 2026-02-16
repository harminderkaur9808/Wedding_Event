<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates table for Pictures & Videos gallery categories and seeds default categories
     * including "Pre-Shagun pictures" after Roka.
     */
    public function up(): void
    {
        Schema::create('picture_video_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 64)->unique();
            $table->string('name');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->string('image_path', 255)->nullable();
            $table->timestamps();
        });

        $categories = [
            ['slug' => 'roka', 'name' => 'ROKA', 'sort_order' => 1, 'image_path' => 'Roka_image.png'],
            ['slug' => 'pre_shagun', 'name' => 'Pre-Shagun pictures', 'sort_order' => 2, 'image_path' => 'Pre_shagun_image.png'],
            ['slug' => 'shagun', 'name' => 'SHAGUN', 'sort_order' => 3, 'image_path' => 'Shagun_image.png'],
            ['slug' => 'vatna', 'name' => 'VATNA', 'sort_order' => 4, 'image_path' => 'Vatna_images.png'],
            ['slug' => 'sangeet', 'name' => 'SANGEET IN PHOENIX', 'sort_order' => 5, 'image_path' => 'Sangeet_in_Phoenix.png'],
            ['slug' => 'mehndi', 'name' => 'MEHNDI', 'sort_order' => 6, 'image_path' => 'Mehndi_wedding.png'],
            ['slug' => 'jaggo', 'name' => 'JAGGO AND GIDDHA', 'sort_order' => 7, 'image_path' => 'Jaggo_and_Giddha.png'],
            ['slug' => 'sehra', 'name' => 'SEHRA BANDHI AND SURMA', 'sort_order' => 8, 'image_path' => 'Sehra_bandhi_and_Surma.png'],
            ['slug' => 'barat', 'name' => 'BARAT AND MILNI', 'sort_order' => 9, 'image_path' => 'Barat_and_Milni.png'],
            ['slug' => 'wedding', 'name' => 'WEDDING', 'sort_order' => 10, 'image_path' => 'Wedding_img.png'],
        ];

        foreach ($categories as $cat) {
            DB::table('picture_video_categories')->insert(array_merge($cat, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picture_video_categories');
    }
};
