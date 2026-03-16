<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Set thirteenth section default display name to "Custom sec1" in admin dropdown.
     */
    public function up(): void
    {
        DB::table('page_sections')
            ->where('slug', 'thirteenth')
            ->update(['title' => 'Custom sec1', 'updated_at' => now()]);
    }

    /**
     * Reverse (restore previous title).
     */
    public function down(): void
    {
        DB::table('page_sections')
            ->where('slug', 'thirteenth')
            ->update(['title' => 'Wedding', 'updated_at' => now()]);
    }
};
