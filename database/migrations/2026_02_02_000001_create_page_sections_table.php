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
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 64)->unique()->comment('hero, our_story, wedding_day, fourth, fifth, sixth, seventh, ninth, tenth, eleventh');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->dateTime('event_date')->nullable()->comment('Used for countdown in wedding_day section');
            $table->json('extra')->nullable()->comment('Section-specific: groom_name, bride_name, event details, entertainment_mc (seventh/ninth), performance_text (ninth), etc.');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
