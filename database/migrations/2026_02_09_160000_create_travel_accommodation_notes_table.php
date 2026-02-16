<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Simple note per section: one row for 'travel', one for 'accommodation'; only description field.
     */
    public function up(): void
    {
        Schema::create('travel_accommodation_notes', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->unique(); // 'travel' | 'accommodation'
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_accommodation_notes');
    }
};
