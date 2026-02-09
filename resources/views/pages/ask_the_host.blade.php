@extends('layouts.app')

@section('title', 'Ask the Host - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/ask-the-host.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-gate.css') }}">
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
                        <label for="question_text" class="ask-the-host-form-label">Your question <span class="ask-the-host-word-hint">(limit 150 words)</span></label>
                        <textarea name="question_text" id="question_text" class="ask-the-host-form-textarea" rows="4" placeholder="Type your question here..." required minlength="3" maxlength="2000" data-max-words="150">{{ old('question_text') }}</textarea>
                        <span class="ask-the-host-word-count" id="questionWordCount" aria-live="polite"></span>
                        @error('question_text')
                            <span class="ask-the-host-error">{{ $message }}</span>
                        @enderror
                        <div class="ask-the-host-form-actions">
                            <button type="button" class="ask-the-host-btn ask-the-host-btn-secondary" id="askTheHostCancelBtn">Cancel</button>
                            <button type="submit" class="ask-the-host-btn ask-the-host-btn-primary">Post question</button>
                        </div>
                    </form>
                </div>

                <!-- List of Questions (logged-in only): 10 shown by default, View More loads next 10 -->
                @php
                    $queriesList = $queries ?? collect();
                    $perPage = 10;
                    $totalQuestions = $queriesList->count();
                    $hasMoreQuestions = $totalQuestions > $perPage;
                @endphp
                <div class="ask-the-host-list" id="askTheHostList" data-shown="{{ $perPage }}" data-total="{{ $totalQuestions }}" data-per-page="{{ $perPage }}">
                    @forelse($queriesList as $idx => $q)
                        @php
                            $shortText = Str::words($q->question_text, 50);
                            $fullText = $q->question_text;
                            $isLong = Str::words($q->question_text, 50) !== $q->question_text;
                            $isHidden = $idx >= $perPage;
                        @endphp
                        <article class="ask-the-host-question {{ $isHidden ? 'ask-the-host-question-hidden' : '' }}" data-query-id="{{ $q->id }}" data-index="{{ $idx }}" style="{{ $isHidden ? 'display: none;' : '' }}">
                            <div class="ask-the-host-question-meta">
                                <div class="ask-the-host-avatar">
                                    @if($q->user->profile_image)
                                        <img src="{{ secure_media_url('profile_images/' . $q->user->profile_image) }}" alt="">
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
                            <div class="ask-the-host-question-text-wrap">
                                <p class="ask-the-host-question-text">
                                    @if($isLong)
                                        <span class="ask-the-host-question-short">{{ $shortText }}</span>
                                        <span class="ask-the-host-question-full" style="display: none;">{{ $fullText }}</span>
                                        <button type="button" class="ask-the-host-see-more-btn" aria-expanded="false">See more</button>
                                    @else
                                        {{ $fullText }}
                                    @endif
                                </p>
                            </div>
                            <div class="ask-the-host-actions">
                                <button type="button" class="ask-the-host-reply-trigger" data-query-id="{{ $q->id }}">Answer</button>
                                @if($q->replies_count > 0)
                                    <button type="button" class="ask-the-host-see-replies {{ $q->replies_count > 0 ? 'replies-open' : '' }}" data-query-id="{{ $q->id }}" data-count="{{ $q->replies_count }}">
                                        Hide {{ $q->replies_count }} {{ Str::plural('Reply', $q->replies_count) }}
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

                            <!-- Replies list: visible by default when there are replies -->
                            <div class="ask-the-host-replies" id="replies-{{ $q->id }}" style="{{ $q->replies_count > 0 ? 'display: block;' : 'display: none;' }}">
                                @foreach($q->replies as $reply)
                                    <div class="ask-the-host-reply">
                                        <div class="ask-the-host-reply-meta">
                                            <div class="ask-the-host-avatar ask-the-host-avatar-sm">
                                                @if($reply->user->profile_image)
                                                    <img src="{{ secure_media_url('profile_images/' . $reply->user->profile_image) }}" alt="">
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
                @if($hasMoreQuestions)
                <div class="ask-the-host-view-more-wrap" id="askTheHostViewMoreWrap">
                    <button type="button" class="ask-the-host-view-more-btn" id="askTheHostViewMoreBtn">View More</button>
                </div>
                @endif
            @else
                @include('partials.login-required-card', ['message' => 'Please log in to view and participate in Questions & Answers.'])
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

    // Word count for question textarea (limit 150 words)
    var questionText = document.getElementById('question_text');
    var wordCountEl = document.getElementById('questionWordCount');
    var maxWords = 150;
    function countWords(str) {
        return str.trim() ? str.trim().split(/\s+/).length : 0;
    }
    function updateWordCount() {
        if (!wordCountEl || !questionText) return;
        var n = countWords(questionText.value);
        wordCountEl.textContent = n + ' / ' + maxWords + ' words';
        wordCountEl.classList.toggle('ask-the-host-word-count-over', n > maxWords);
    }
    if (questionText && wordCountEl) {
        questionText.addEventListener('input', updateWordCount);
        questionText.addEventListener('paste', function() { setTimeout(updateWordCount, 0); });
        updateWordCount();
    }
    var questionForm = document.querySelector('.ask-the-host-form');
    if (questionForm && questionText) {
        questionForm.addEventListener('submit', function(e) {
            if (countWords(questionText.value) > maxWords) {
                e.preventDefault();
                alert('The question must not exceed 150 words. Please shorten your question.');
            }
        });
    }

    // See more / See less for long question text
    document.querySelectorAll('.ask-the-host-see-more-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var p = btn.closest('.ask-the-host-question-text');
            if (!p) return;
            var short = p.querySelector('.ask-the-host-question-short');
            var full = p.querySelector('.ask-the-host-question-full');
            if (!short || !full) return;
            var isExpanded = btn.getAttribute('aria-expanded') === 'true';
            if (isExpanded) {
                short.style.display = 'inline';
                full.style.display = 'none';
                btn.textContent = 'See more';
                btn.setAttribute('aria-expanded', 'false');
            } else {
                short.style.display = 'none';
                full.style.display = 'inline';
                btn.textContent = 'See less';
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });

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
            var count = btn.getAttribute('data-count');
            var repliesEl = document.getElementById('replies-' + id);
            if (!repliesEl) return;
            var isHidden = repliesEl.style.display === 'none';
            repliesEl.style.display = isHidden ? 'block' : 'none';
            btn.classList.toggle('replies-open', isHidden);
            btn.textContent = isHidden ? 'Hide ' + count + ' ' + (count === '1' ? 'Reply' : 'Replies') : 'See ' + count + ' ' + (count === '1' ? 'Reply' : 'Replies');
        });
    });

    document.querySelectorAll('.reply-cancel').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = btn.getAttribute('data-query-id');
            var wrap = document.getElementById('replyFormWrap-' + id);
            if (wrap) wrap.style.display = 'none';
        });
    });

    // View More: show next 10 questions
    var viewMoreBtn = document.getElementById('askTheHostViewMoreBtn');
    var listEl = document.getElementById('askTheHostList');
    if (viewMoreBtn && listEl) {
        var perPage = parseInt(listEl.getAttribute('data-per-page') || '10', 10);
        viewMoreBtn.addEventListener('click', function() {
            var hidden = listEl.querySelectorAll('.ask-the-host-question-hidden');
            var toShow = Math.min(perPage, hidden.length);
            for (var i = 0; i < toShow; i++) {
                hidden[i].style.display = '';
                hidden[i].classList.remove('ask-the-host-question-hidden');
            }
            var stillHidden = listEl.querySelectorAll('.ask-the-host-question-hidden');
            if (stillHidden.length === 0) {
                document.getElementById('askTheHostViewMoreWrap').style.display = 'none';
            }
        });
    }
});
</script>
@endpush
