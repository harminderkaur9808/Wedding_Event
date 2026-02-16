<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelAccommodationEntry extends Model
{
    public const TYPE_TRAVEL = 'travel';
    public const TYPE_ACCOMMODATION = 'accommodation';

    protected $table = 'travel_accommodation_entries';

    protected $fillable = [
        'type',
        'sort_order',
        'name',
        'address',
        'phone',
        'website',
        'website_label',
        'map_url',
    ];
}
