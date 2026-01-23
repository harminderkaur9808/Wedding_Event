<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMedia extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'role',
        'images',
        'videos',
        'category',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
    ];

    /**
     * Get the user that owns the media
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
