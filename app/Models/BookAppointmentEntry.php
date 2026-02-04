<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookAppointmentEntry extends Model
{
    protected $fillable = [
        'section',
        'sort_order',
        'store_name',
        'instruction',
        'address',
        'distance',
        'services',
    ];

    public const SECTIONS = [
        'hair'   => 'Hair',
        'makeup' => 'Makeup',
        'nails'  => 'Nails',
        'spa'    => 'Spa',
    ];

    /**
     * Get entries grouped by section for the frontend.
     */
    public static function getGroupedBySection(): array
    {
        return static::orderBy('section')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section')
            ->map(fn ($items) => $items->values()->all())
            ->all();
    }
}
