<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Note extends Model
{
    protected $fillable = ['user_id', 'title', 'content'];

    /**
     * Admin who created the note.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Admins with whom this note is shared (can view only).
     */
    public function sharedWith(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'note_user')->withTimestamps();
    }
}
