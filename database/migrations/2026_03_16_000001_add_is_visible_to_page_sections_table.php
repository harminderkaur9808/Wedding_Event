<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add is_visible column so admin can show/hide sections (e.g. thirteenth) on the homepage.
     */
    public function up(): void
    {
        if (Schema::hasColumn('page_sections', 'is_visible')) {
            return;
        }
        Schema::table('page_sections', function (Blueprint $table) {
            $table->boolean('is_visible')->default(true)->after('sort_order');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropColumn('is_visible');
        });
    }
};
