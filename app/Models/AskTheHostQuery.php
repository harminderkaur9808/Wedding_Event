<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AskTheHostQuery extends Model
{
    use HasFactory;

    protected $table = 'ask_the_host_queries';

    protected $fillable = [
        'user_id',
        'question_text',
    ];

    /**
     * User who asked the question.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Replies to this question.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(AskTheHostReply::class, 'ask_the_host_query_id');
    }
}
