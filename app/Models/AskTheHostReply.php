<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AskTheHostReply extends Model
{
    use HasFactory;

    protected $table = 'ask_the_host_replies';

    protected $fillable = [
        'ask_the_host_query_id',
        'parent_reply_id',
        'user_id',
        'reply_text',
    ];

    /**
     * The question this reply belongs to.
     */
    public function askTheHostQuery(): BelongsTo
    {
        return $this->belongsTo(AskTheHostQuery::class, 'ask_the_host_query_id');
    }

    /**
     * Parent reply (when this is a reply-to-reply).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(AskTheHostReply::class, 'parent_reply_id');
    }

    /**
     * Nested replies under this reply.
     */
    public function children(): HasMany
    {
        return $this->hasMany(AskTheHostReply::class, 'parent_reply_id')->orderBy('created_at')->with('children');
    }

    /**
     * User who posted the reply.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
