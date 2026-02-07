<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LocalAttraction extends Model
{
    protected $fillable = [
        'sort_order',
        'is_active',
        'title',
        'description',
        'address',
        'distance',
        'map_url',
        'image_path',
        'image_position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }
        if (!Storage::disk('public')->exists($this->image_path)) {
            return null;
        }
        return secure_media_url(ltrim($this->image_path, '/'));
    }
}

