<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Optional display text for the website link (e.g. "Phoenix Sky Harbor - Official Site").
     */
    public function up(): void
    {
        Schema::table('travel_accommodation_entries', function (Blueprint $table) {
            $table->string('website_label', 255)->nullable()->after('website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_accommodation_entries', function (Blueprint $table) {
            $table->dropColumn('website_label');
        });
    }
};
