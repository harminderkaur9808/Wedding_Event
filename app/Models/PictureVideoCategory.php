<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PictureVideoCategory extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'sort_order',
        'image_path',
    ];
}
