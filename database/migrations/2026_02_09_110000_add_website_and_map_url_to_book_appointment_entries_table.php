<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds website and map_url to existing book_appointment_entries.
     * Safe when table already has data.
     */
    public function up(): void
    {
        Schema::table('book_appointment_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('book_appointment_entries', 'website')) {
                $table->string('website', 2048)->nullable()->after('distance');
            }
            if (!Schema::hasColumn('book_appointment_entries', 'map_url')) {
                $table->string('map_url', 2048)->nullable()->after('website');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_appointment_entries', function (Blueprint $table) {
            if (Schema::hasColumn('book_appointment_entries', 'website')) {
                $table->dropColumn('website');
            }
            if (Schema::hasColumn('book_appointment_entries', 'map_url')) {
                $table->dropColumn('map_url');
            }
        });
    }
};
