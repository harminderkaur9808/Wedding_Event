<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'slug' => 'hero',
                'title' => null,
                'subtitle' => null,
                'short_description' => null,
                'event_date' => null,
                'extra' => null,
                'sort_order' => 1,
            ],
            [
                'slug' => 'our_story',
                'title' => 'Our Story',
                'subtitle' => 'Bride & Groom',
                'short_description' => null,
                'event_date' => null,
                'extra' => [
                    'groom_name' => 'Vickram',
                    'groom_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.',
                    'bride_name' => 'Nisha',
                    'bride_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.',
                ],
                'sort_order' => 2,
            ],
            [
                'slug' => 'wedding_day',
                'title' => 'Date We Getting Married',
                'subtitle' => 'Wedding Day',
                'short_description' => null,
                'event_date' => Carbon::parse('2026-12-31 12:00:00'),
                'extra' => null,
                'sort_order' => 3,
            ],
            [
                'slug' => 'fourth',
                'title' => 'Shagun',
                'subtitle' => 'With Blessings',
                'short_description' => 'We inviting you and your family on',
                'event_date' => null,
                'extra' => [
                    'dress_code' => 'Traditional Outfits',
                    'date' => '2/21/2026',
                    'time' => '9 am - 12 pm',
                    'venue' => 'Phoenix AZ',
                ],
                'sort_order' => 4,
            ],
            [
                'slug' => 'fifth',
                'title' => 'Vatna',
                'subtitle' => 'Sacred Ritual',
                'short_description' => null,
                'event_date' => null,
                'extra' => [
                    'date' => '2/25/2026',
                    'date_display' => '25 Feb 2026',
                    'time' => '9 am - 12 pm',
                    'venue' => 'Phoenix AZ',
                    'dress_code' => 'Casual Indian Orange Yellow, Green Colors',
                ],
                'sort_order' => 5,
            ],
            [
                'slug' => 'sixth',
                'title' => 'Mehndi',
                'subtitle' => 'Colorful Vibes',
                'short_description' => null,
                'event_date' => null,
                'extra' => [
                    'date' => '2-25-2026',
                    'time' => '4 - 7 pm',
                    'venue' => 'Ramit and Maninder Residence',
                    'dress_code' => 'Casual Indian Orange Yellow, Green Colors',
                    'address' => '20865 N. 109th Place, Scottsdale AZ',
                ],
                'sort_order' => 6,
            ],
            [
                'slug' => 'seventh',
                'title' => 'Sangeet Night',
                'subtitle' => 'Musical Vibes',
                'short_description' => null,
                'event_date' => null,
                'extra' => [
                    'date' => '2-26-2026',
                    'time' => '6pm - midnight',
                    'venue' => 'Jasmine and Mannttej Residence',
                    'dress_code' => 'Indian. Outside venue. Be warm and comfortable',
                    'address' => '4608 W El Cortez Pl, Phoenix AZ 85083',
                    'entertainment_mc' => 'MC: Jastej Sra',
                ],
                'sort_order' => 7,
            ],
            [
                'slug' => 'ninth',
                'title' => "Jaggo, Gidha and\nBhangra Night",
                'subtitle' => 'Full Magic',
                'short_description' => null,
                'event_date' => null,
                'extra' => [
                    'date' => '2-31-2026',
                    'time' => '6 pm to midnight',
                    'venue' => 'Park Hyatt Aviara Resort-760-448-1234',
                    'dress_code' => 'Indian Traditional Outfits',
                    'address' => '7100 Aviara Resort Drive, Carlsbad CA 92011',
                    'entertainment_mc' => 'MC: Herman Kahlon',
                    'performance_text' => 'Giddha by family members',
                ],
                'sort_order' => 8,
            ],
            [
                'slug' => 'tenth',
                'title' => 'Sehra & Surma Ceremony',
                'subtitle' => 'Cultural Elegance',
                'short_description' => null,
                'event_date' => null,
                'extra' => [
                    'date' => '12-31-2026',
                    'turban_tying' => 'At 7 am',
                    'venue' => 'Hopitality Room',
                    'barat_leaves' => 'Indian Traditional Outfits',
                ],
                'sort_order' => 9,
            ],
            [
                'slug' => 'eleventh',
                'title' => 'Wedding',
                'subtitle' => 'Sacred Union',
                'short_description' => null,
                'event_date' => null,
                'extra' => [
                    'date' => '12-31-2026',
                    'time' => '9 am-12 pm',
                    'venue' => 'Ramit and Maninder Residence',
                    'dress_code' => 'Indian Traditional Outfits',
                    'dress_code_subtext' => 'Men: Red Turbans Head Covers  Women: Any Color',
                    'address' => '20865 N 109th Place Scottsdale AZ',
                ],
                'sort_order' => 10,
            ],
        ];

        foreach ($sections as $data) {
            PageSection::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
