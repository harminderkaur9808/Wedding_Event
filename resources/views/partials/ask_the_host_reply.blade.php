@php
    $replies = $replies ?? collect();
    $children = $replies->where('parent_reply_id', $reply->id);
@endphp
<div class="ask-the-host-reply-block {{ $depth > 0 ? 'ask-the-host-reply-block--nested' : '' }}" data-reply-id="{{ $reply->id }}">
    <div class="ask-the-host-reply-block-inner">
        <div class="ask-the-host-reply-meta">
            <div class="ask-the-host-reply-meta-left">
                <div class="ask-the-host-avatar ask-the-host-avatar-sm">
                    @if($reply->user->profile_image)
                        <img src="{{ secure_media_url('profile_images/' . $reply->user->profile_image) }}" alt="">
                    @else
                        <span>{{ strtoupper(substr($reply->user->first_name ?? 'U', 0, 1) . substr($reply->user->last_name ?? '', 0, 1)) }}</span>
                    @endif
                </div>
                <span class="ask-the-host-name">{{ $reply->user->first_name }} {{ $reply->user->last_name }}</span>
                @if($reply->user->isAdmin())
                    <span class="ask-the-host-admin-badge" title="Published by admin">Published by admin</span>
                @endif
                <span class="ask-the-host-date">{{ $reply->created_at->format('j M h:i a') }}</span>
            </div>
            @php $canEditReply = Auth::id() == $reply->user_id; $canDeleteReply = Auth::id() == $reply->user_id || (Auth::check() && Auth::user()->isAdmin()); @endphp
            @if($canEditReply || $canDeleteReply)
                <div class="ask-the-host-question-actions-wrap">
                    @if($canEditReply)
                    <button type="button" class="ask-the-host-action-btn ask-the-host-reply-edit-trigger" data-reply-id="{{ $reply->id }}" aria-label="Edit reply" title="Edit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    @endif
                    @if($canDeleteReply)
                    <form action="{{ route('ask.the.host.replies.destroy', $reply) }}" method="POST" class="ask-the-host-delete-form ask-the-host-reply-delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ask-the-host-action-btn ask-the-host-action-btn-delete" aria-label="Delete reply" title="Delete">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        </button>
                    </form>
                    @endif
                </div>
            @endif
        </div>
        <div class="ask-the-host-reply-text-wrap" id="replyTextWrap-{{ $reply->id }}">
            <p class="ask-the-host-reply-text">{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $reply->reply_text))) !!}</p>
        </div>
        <div class="ask-the-host-reply-edit-wrap" id="replyEditWrap-{{ $reply->id }}" style="display: none;">
            <form action="{{ route('ask.the.host.replies.update', $reply) }}" method="POST" class="ask-the-host-form ask-the-host-reply-edit-form" data-reply-id="{{ $reply->id }}">
                @csrf
                @method('PATCH')
                <input type="hidden" class="ask-the-host-reply-edit-initial" value="{{ e($reply->reply_text) }}" data-reply-id="{{ $reply->id }}">
                <textarea name="reply_text" class="ask-the-host-form-textarea ask-the-host-reply-edit-textarea" rows="3" required minlength="1" maxlength="2000" placeholder="Edit your reply...">{{ $reply->reply_text }}</textarea>
                <div class="ask-the-host-form-actions">
                    <button type="button" class="ask-the-host-btn ask-the-host-btn-secondary ask-the-host-reply-edit-cancel" data-reply-id="{{ $reply->id }}">Cancel</button>
                    <button type="submit" class="ask-the-host-btn ask-the-host-btn-primary">Save</button>
                </div>
            </form>
        </div>
        <div class="ask-the-host-reply-actions">
            <button type="button" class="ask-the-host-reply-under-trigger" data-query-id="{{ $query->id }}" data-reply-id="{{ $reply->id }}" data-parent-reply-id="{{ $reply->id }}">Reply</button>
        </div>
        <div class="ask-the-host-reply-form-wrap" id="replyFormWrap-{{ $query->id }}-{{ $reply->id }}" style="display: none;">
            <form action="{{ route('ask.the.host.replies.store', $query) }}" method="POST" class="ask-the-host-form ask-the-host-reply-form">
                @csrf
                <input type="hidden" name="parent_reply_id" value="{{ $reply->id }}">
                <textarea name="reply_text" class="ask-the-host-form-textarea" rows="3" placeholder="Write your reply..." required minlength="1" maxlength="2000"></textarea>
                @error('reply_text')
                    <span class="ask-the-host-error">{{ $message }}</span>
                @enderror
                <div class="ask-the-host-form-actions">
                    <button type="button" class="ask-the-host-btn ask-the-host-btn-secondary reply-under-cancel" data-query-id="{{ $query->id }}" data-reply-id="{{ $reply->id }}">Cancel</button>
                    <button type="submit" class="ask-the-host-btn ask-the-host-btn-primary">Post reply</button>
                </div>
            </form>
        </div>
        @if($children->isNotEmpty())
        <div class="ask-the-host-replies-nested">
            @foreach($children as $child)
                @include('partials.ask_the_host_reply', ['reply' => $child, 'query' => $query, 'replies' => $replies, 'depth' => ($depth ?? 0) + 1])
            @endforeach
        </div>
        @endif
    </div>
</div>
