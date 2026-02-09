<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds `website` column to existing local_attractions table.
     * Safe to run when table already has data; only adds column if missing.
     */
    public function up(): void
    {
        Schema::table('local_attractions', function (Blueprint $table) {
            if (!Schema::hasColumn('local_attractions', 'website')) {
                $table->string('website', 2048)->nullable()->after('map_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('local_attractions', function (Blueprint $table) {
            if (Schema::hasColumn('local_attractions', 'website')) {
                $table->dropColumn('website');
            }
        });
    }
};
