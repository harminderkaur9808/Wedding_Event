<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelAccommodationNote extends Model
{
    public const TYPE_TRAVEL = 'travel';
    public const TYPE_ACCOMMODATION = 'accommodation';

    protected $fillable = ['type', 'description', 'sort_order'];
}
