@extends('layouts.app')

@section('title', 'Ask the Host - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/ask-the-host.css') }}">
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="ask-the-host-hero" id="ask-the-host">
        <div class="ask-the-host-hero-bg" aria-hidden="true">
            <img
                src="{{ asset('Images/Ask_to_Host/Ask_to_host_1.png') }}"
                alt=""
                class="ask-the-host-hero-bg-img"
            >
        </div>
        <div class="ask-the-host-hero-overlay" aria-hidden="true"></div>
        <div class="container ask-the-host-hero-content">
            <div class="ask-the-host-hero-text">
                <div class="ask-the-host-hero-eyebrow">Have A Question?</div>
                <div class="ask-the-host-hero-decorative">
                    <img src="{{ asset('Images/Ask_to_Host/betweentxt_frame_design.png') }}" alt="" class="ask-the-host-hero-decorative-img">
                </div>
                <h1 class="ask-the-host-hero-title">Ask the Host</h1>
            </div>
        </div>
    </section>

    <!-- Q&A Section: only visible when logged in -->
    <section class="ask-the-host-content">
        <div class="container ask-the-host-container">
            @auth
                @if(session('success'))
                    <div class="ask-the-host-alert ask-the-host-alert-success">{{ session('success') }}</div>
                @endif

                <div class="ask-the-host-header">
                    <h2 class="ask-the-host-section-title"></h2>
                    <button type="button" class="ask-the-host-add-btn" id="askTheHostAddBtn">+ Add question</button>
                </div>

                <!-- Add Question Form (shown when logged in) -->
                <div class="ask-the-host-form-wrap" id="askTheHostFormWrap" style="{{ old('question_text') ? 'display: block;' : 'display: none;' }}">
                    <form action="{{ route('ask.the.host.questions.store') }}" method="POST" class="ask-the-host-form">
                        @csrf
                        <label for="question_text" class="ask-the-host-form-label">Your question</label>
                        <textarea name="question_text" id="question_text" class="ask-the-host-form-textarea" rows="4" placeholder="Type your question here..." required minlength="3" maxlength="2000">{{ old('question_text') }}</textarea>
                        @error('question_text')
                            <span class="ask-the-host-error">{{ $message }}</span>
                        @enderror
                        <div class="ask-the-host-form-actions">
                            <button type="button" class="ask-the-host-btn ask-the-host-btn-secondary" id="askTheHostCancelBtn">Cancel</button>
                            <button type="submit" class="ask-the-host-btn ask-the-host-btn-primary">Post question</button>
                        </div>
                    </form>
                </div>

                <!-- List of Questions (logged-in only) -->
                <div class="ask-the-host-list">
                    @forelse($queries ?? [] as $q)
                        <article class="ask-the-host-question" data-query-id="{{ $q->id }}">
                            <div class="ask-the-host-question-meta">
                                <div class="ask-the-host-avatar">
                                    @if($q->user->profile_image)
                                        <img src="{{ asset('storage/profile_images/' . $q->user->profile_image) }}" alt="">
                                    @else
                                        <span>{{ strtoupper(substr($q->user->first_name ?? 'U', 0, 1) . substr($q->user->last_name ?? '', 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="ask-the-host-meta-text">
                                    <span class="ask-the-host-name">{{ $q->user->first_name }} {{ $q->user->last_name }}</span>
                                    @if($q->user->isAdmin())
                                        <span class="ask-the-host-admin-badge" title="Admin">Admin</span>
                                    @endif
                                    <span class="ask-the-host-date">{{ $q->created_at->format('j M h:i a') }}</span>
                                </div>
                            </div>
                            <p class="ask-the-host-question-text">{{ $q->question_text }}</p>
                            <div class="ask-the-host-actions">
                                <button type="button" class="ask-the-host-reply-trigger" data-query-id="{{ $q->id }}">Answer</button>
                                @if($q->replies_count > 0)
                                    <button type="button" class="ask-the-host-see-replies" data-query-id="{{ $q->id }}" data-count="{{ $q->replies_count }}">
                                        See {{ $q->replies_count }} {{ Str::plural('Reply', $q->replies_count) }}
                                    </button>
                                @endif
                            </div>

                            <!-- Reply form (inline, toggled) -->
                            <div class="ask-the-host-reply-form-wrap" id="replyFormWrap-{{ $q->id }}" style="display: none;">
                                <form action="{{ route('ask.the.host.replies.store', $q) }}" method="POST" class="ask-the-host-form ask-the-host-reply-form">
                                    @csrf
                                    <textarea name="reply_text" class="ask-the-host-form-textarea" rows="3" placeholder="Write your reply..." required minlength="1" maxlength="2000"></textarea>
                                    @error('reply_text')
                                        <span class="ask-the-host-error">{{ $message }}</span>
                                    @enderror
                                    <div class="ask-the-host-form-actions">
                                        <button type="button" class="ask-the-host-btn ask-the-host-btn-secondary reply-cancel" data-query-id="{{ $q->id }}">Cancel</button>
                                        <button type="submit" class="ask-the-host-btn ask-the-host-btn-primary">Post reply</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Replies list (toggle) -->
                            <div class="ask-the-host-replies" id="replies-{{ $q->id }}" style="display: none;">
                                @foreach($q->replies as $reply)
                                    <div class="ask-the-host-reply">
                                        <div class="ask-the-host-reply-meta">
                                            <div class="ask-the-host-avatar ask-the-host-avatar-sm">
                                                @if($reply->user->profile_image)
                                                    <img src="{{ asset('storage/profile_images/' . $reply->user->profile_image) }}" alt="">
                                                @else
                                                    <span>{{ strtoupper(substr($reply->user->first_name ?? 'U', 0, 1) . substr($reply->user->last_name ?? '', 0, 1)) }}</span>
                                                @endif
                                            </div>
                                            <span class="ask-the-host-name">{{ $reply->user->first_name }} {{ $reply->user->last_name }}</span>
                                            @if($reply->user->isAdmin())
                                                <span class="ask-the-host-admin-badge" title="Admin">Admin</span>
                                            @endif
                                            <span class="ask-the-host-date">{{ $reply->created_at->format('j M h:i a') }}</span>
                                        </div>
                                        <p class="ask-the-host-reply-text">{{ $reply->reply_text }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @empty
                        <p class="ask-the-host-empty">No questions yet. Be the first to ask!</p>
                    @endforelse
                </div>
            @else
                <!-- Guest: show login prompt -->
                <div class="ask-the-host-login-required">
                    <div class="ask-the-host-login-icon" aria-hidden="true">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7 11V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="ask-the-host-login-title">Login required</h3>
                    <p class="ask-the-host-login-message">Please log in to view and participate in Questions &amp; Answers.</p>
                    <a href="{{ route('login', ['intended' => url()->current()]) }}" class="ask-the-host-login-btn">Go to Login</a>
                </div>
            @endauth
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var addBtn = document.getElementById('askTheHostAddBtn');
    var formWrap = document.getElementById('askTheHostFormWrap');
    var cancelBtn = document.getElementById('askTheHostCancelBtn');

    if (addBtn && formWrap) {
        addBtn.addEventListener('click', function() {
            formWrap.style.display = formWrap.style.display === 'none' ? 'block' : 'none';
        });
    }
    if (cancelBtn && formWrap) {
        cancelBtn.addEventListener('click', function() {
            formWrap.style.display = 'none';
        });
    }

    document.querySelectorAll('.ask-the-host-reply-trigger').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if (btn.tagName === 'A') return;
            e.preventDefault();
            var id = btn.getAttribute('data-query-id');
            var wrap = document.getElementById('replyFormWrap-' + id);
            if (wrap) wrap.style.display = wrap.style.display === 'none' ? 'block' : 'none';
        });
    });

    document.querySelectorAll('.ask-the-host-see-replies').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = btn.getAttribute('data-query-id');
            var repliesEl = document.getElementById('replies-' + id);
            if (!repliesEl) return;
            var isHidden = repliesEl.style.display === 'none';
            repliesEl.style.display = isHidden ? 'block' : 'none';
            btn.textContent = isHidden ? 'Hide replies' : 'See ' + btn.getAttribute('data-count') + ' Reply(ies)';
        });
    });

    document.querySelectorAll('.reply-cancel').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = btn.getAttribute('data-query-id');
            var wrap = document.getElementById('replyFormWrap-' + id);
            if (wrap) wrap.style.display = 'none';
        });
    });
});
</script>
@endpush
