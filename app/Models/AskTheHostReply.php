<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AskTheHostReply extends Model
{
    use HasFactory;

    protected $table = 'ask_the_host_replies';

    protected $fillable = [
        'ask_the_host_query_id',
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
     * User who posted the reply.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
