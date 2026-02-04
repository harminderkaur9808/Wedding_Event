<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add twelfth (Reception) section to page_sections if not exists.
     */
    public function up(): void
    {
        $exists = DB::table('page_sections')->where('slug', 'twelfth')->exists();
        if (!$exists) {
            DB::table('page_sections')->insert([
                'slug' => 'twelfth',
                'title' => 'Reception',
                'subtitle' => 'Celebration',
                'short_description' => null,
                'event_date' => null,
                'extra' => json_encode([
                    'date' => '1/2/2027',
                    'venue' => 'Park Hyatt Aviara Resort-760-448-1234',
                    'address' => '7100 Aviara Resort Drive, Carlsbad CA 92011',
                    'time' => '6 pm onwards',
                    'dress_code' => 'Indian traditional outfits',
                    'dress_code_subtext' => 'Men: Formals. Women: any color',
                ]),
                'sort_order' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        DB::table('page_sections')->where('slug', 'twelfth')->delete();
    }
};
