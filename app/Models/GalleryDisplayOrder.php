<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryDisplayOrder extends Model
{
    protected $table = 'gallery_display_orders';

    protected $fillable = [
        'category',
        'type',
        'order',
    ];

    protected $casts = [
        'order' => 'array',
    ];
}
