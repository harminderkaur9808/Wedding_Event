<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Note extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'tags'];

    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * Predefined notification tags (slug => label) for filtering on frontend.
     */
    public static function notificationTagOptions(): array
    {
        return [
            'important'       => 'Important',
            'today'           => 'Today',
            'schedule_update' => 'Schedule Update',
            'travel_update'   => 'Travel Update',
            'flight_info'     => 'Flight Info',
            'airport_pickup'  => 'Airport Pickup',
            'hotel_stay'      => 'Hotel & Stay',
            'event_reminder'  => 'Event Reminder',
            'local_transport' => 'Local Transport',
            'salon_makeup'    => 'Salon / Makeup',
        ];
    }

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
