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
        Schema::create('book_appointment_entries', function (Blueprint $table) {
            $table->id();
            $table->string('section', 32)->comment('hair, makeup, nails, spa');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->string('store_name')->nullable();
            $table->text('instruction')->nullable();
            $table->string('address')->nullable();
            $table->string('distance')->nullable();
            $table->string('services')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_appointment_entries');
    }
};
