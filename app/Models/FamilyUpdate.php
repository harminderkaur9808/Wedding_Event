<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyUpdate extends Model
{
    protected $fillable = ['user_id', 'message'];

    /**
     * The user (admin) who posted this update.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
