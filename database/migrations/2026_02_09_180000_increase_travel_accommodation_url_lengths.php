<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Map and website URLs can be very long (e.g. Google Maps). Increase length to avoid 500 on save.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE travel_accommodation_entries MODIFY map_url VARCHAR(2048) NULL');
            DB::statement('ALTER TABLE travel_accommodation_entries MODIFY website VARCHAR(2048) NULL');
        } else {
            Schema::table('travel_accommodation_entries', function (Blueprint $table) {
                $table->string('map_url', 2048)->nullable()->change();
                $table->string('website', 2048)->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE travel_accommodation_entries MODIFY map_url VARCHAR(255) NULL');
            DB::statement('ALTER TABLE travel_accommodation_entries MODIFY website VARCHAR(255) NULL');
        } else {
            Schema::table('travel_accommodation_entries', function (Blueprint $table) {
                $table->string('map_url')->nullable()->change();
                $table->string('website')->nullable()->change();
            });
        }
    }
};
