<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add thirteenth section to page_sections if not exists.
     * Same structure as eleventh (Wedding-style block). Hidden by default until admin turns it on.
     */
    public function up(): void
    {
        $exists = DB::table('page_sections')->where('slug', 'thirteenth')->exists();
        if (!$exists) {
            $row = [
                'slug' => 'thirteenth',
                'title' => 'Custom sec1',
                'subtitle' => 'Sacred Union',
                'short_description' => null,
                'event_date' => null,
                'extra' => json_encode([
                    'date' => '01-01-2027',
                    'time' => '9 am-12 pm',
                    'venue' => 'Ramit and Maninder Residence',
                    'dress_code' => 'Indian Traditional Outfits',
                    'dress_code_men' => 'Red Turbans Head Covers',
                    'dress_code_women' => 'Any Color',
                    'address' => '20865 N 109th Place Scottsdale AZ',
                ]),
                'sort_order' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if (Schema::hasColumn('page_sections', 'is_visible')) {
                $row['is_visible'] = false;
            }
            DB::table('page_sections')->insert($row);
        }
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        DB::table('page_sections')->where('slug', 'thirteenth')->delete();
    }
};
