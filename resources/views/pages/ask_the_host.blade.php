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
                                <div class="ask-the-host-meta-left">
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
                                @if(Auth::id() == $q->user_id)
                                <div class="ask-the-host-question-menu-wrap">
                                    <button type="button" class="ask-the-host-question-menu-btn" aria-label="Question options" aria-expanded="false" aria-haspopup="true" data-query-id="{{ $q->id }}">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="6" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="18" r="1.5"/></svg>
                                    </button>
                                    <div class="ask-the-host-question-dropdown" id="questionDropdown-{{ $q->id }}" role="menu" aria-hidden="true" data-query-id="{{ $q->id }}">
                                        <button type="button" class="ask-the-host-dropdown-item ask-the-host-edit-trigger" data-query-id="{{ $q->id }}" role="menuitem">Edit</button>
                                        <form action="{{ route('ask.the.host.questions.destroy', $q) }}" method="POST" class="ask-the-host-delete-form" data-query-id="{{ $q->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ask-the-host-dropdown-item ask-the-host-dropdown-item-danger" role="menuitem">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="ask-the-host-question-text-wrap" id="questionTextWrap-{{ $q->id }}">
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
                            @if(Auth::id() == $q->user_id)
                            <div class="ask-the-host-edit-wrap" id="editWrap-{{ $q->id }}" style="display: none;">
                                <form action="{{ route('ask.the.host.questions.update', $q) }}" method="POST" class="ask-the-host-form ask-the-host-edit-form" data-query-id="{{ $q->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" class="ask-the-host-edit-initial" value="{{ e($q->question_text) }}" data-query-id="{{ $q->id }}">
                                    <textarea name="question_text" class="ask-the-host-form-textarea ask-the-host-edit-textarea" rows="4" required minlength="3" maxlength="2000" data-max-words="150" placeholder="Edit your question..."></textarea>
                                    <span class="ask-the-host-word-count ask-the-host-edit-word-count" aria-live="polite"></span>
                                    <div class="ask-the-host-form-actions">
                                        <button type="button" class="ask-the-host-btn ask-the-host-btn-secondary ask-the-host-edit-cancel" data-query-id="{{ $q->id }}">Cancel</button>
                                        <button type="submit" class="ask-the-host-btn ask-the-host-btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                            @endif
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
                                    <div class="ask-the-host-reply" data-reply-id="{{ $reply->id }}">
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
                                                    <span class="ask-the-host-admin-badge" title="Admin">Admin</span>
                                                @endif
                                                <span class="ask-the-host-date">{{ $reply->created_at->format('j M h:i a') }}</span>
                                            </div>
                                            @if(Auth::id() == $reply->user_id)
                                                <div class="ask-the-host-reply-menu-wrap">
                                                    <button type="button" class="ask-the-host-question-menu-btn ask-the-host-reply-menu-btn" aria-label="Reply options" aria-expanded="false" aria-haspopup="true" data-reply-id="{{ $reply->id }}">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="6" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="18" r="1.5"/></svg>
                                                    </button>
                                                    <div class="ask-the-host-question-dropdown ask-the-host-reply-dropdown" id="replyDropdown-{{ $reply->id }}" role="menu" aria-hidden="true">
                                                        <form action="{{ route('ask.the.host.replies.destroy', $reply) }}" method="POST" class="ask-the-host-delete-form ask-the-host-reply-delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="ask-the-host-dropdown-item ask-the-host-dropdown-item-danger" role="menuitem">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
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

    <!-- Custom delete confirmation modal -->
    <div class="ask-the-host-confirm-overlay" id="askTheHostConfirmOverlay" role="dialog" aria-modal="true" aria-labelledby="askTheHostConfirmTitle" aria-hidden="true" style="display: none;">
        <div class="ask-the-host-confirm-dialog">
            <h3 class="ask-the-host-confirm-title" id="askTheHostConfirmTitle">Delete?</h3>
            <p class="ask-the-host-confirm-message" id="askTheHostConfirmMessage"></p>
            <div class="ask-the-host-confirm-actions">
                <button type="button" class="ask-the-host-btn ask-the-host-btn-secondary ask-the-host-confirm-cancel" id="askTheHostConfirmCancel">Cancel</button>
                <button type="button" class="ask-the-host-btn ask-the-host-btn-danger ask-the-host-confirm-delete" id="askTheHostConfirmDelete">Delete</button>
            </div>
        </div>
    </div>
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

    // Three-dots dropdown: toggle and close on outside click
    document.querySelectorAll('.ask-the-host-question-menu-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            var id = btn.getAttribute('data-query-id');
            var dropdown = document.getElementById('questionDropdown-' + id);
            var isOpen = dropdown && dropdown.classList.contains('ask-the-host-dropdown-open');
            document.querySelectorAll('.ask-the-host-question-dropdown').forEach(function(d) {
                d.classList.remove('ask-the-host-dropdown-open');
            });
            document.querySelectorAll('.ask-the-host-question-menu-btn').forEach(function(b) {
                b.setAttribute('aria-expanded', 'false');
            });
            if (!isOpen && dropdown) {
                dropdown.classList.add('ask-the-host-dropdown-open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
    document.addEventListener('click', function() {
        document.querySelectorAll('.ask-the-host-question-dropdown, .ask-the-host-reply-dropdown').forEach(function(d) {
            d.classList.remove('ask-the-host-dropdown-open');
        });
        document.querySelectorAll('.ask-the-host-question-menu-btn, .ask-the-host-reply-menu-btn').forEach(function(b) {
            b.setAttribute('aria-expanded', 'false');
        });
    });

    // Reply three-dots dropdown: toggle and close on outside click
    document.querySelectorAll('.ask-the-host-reply-menu-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            var id = btn.getAttribute('data-reply-id');
            var dropdown = document.getElementById('replyDropdown-' + id);
            var isOpen = dropdown && dropdown.classList.contains('ask-the-host-dropdown-open');
            document.querySelectorAll('.ask-the-host-reply-dropdown').forEach(function(d) {
                d.classList.remove('ask-the-host-dropdown-open');
            });
            document.querySelectorAll('.ask-the-host-reply-menu-btn').forEach(function(b) {
                b.setAttribute('aria-expanded', 'false');
            });
            if (!isOpen && dropdown) {
                dropdown.classList.add('ask-the-host-dropdown-open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });

    // Edit: show edit form, hide question text (get initial text from hidden input in edit form)
    document.querySelectorAll('.ask-the-host-edit-trigger').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var id = btn.getAttribute('data-query-id');
            var editWrap = document.getElementById('editWrap-' + id);
            var textWrap = document.getElementById('questionTextWrap-' + id);
            var dropdown = document.getElementById('questionDropdown-' + id);
            if (!editWrap || !textWrap) return;
            var initialInput = editWrap.querySelector('.ask-the-host-edit-initial');
            var text = (initialInput && initialInput.value) ? initialInput.value : '';
            var textarea = editWrap.querySelector('.ask-the-host-edit-textarea');
            var wordCountEl = editWrap.querySelector('.ask-the-host-edit-word-count');
            if (textarea) {
                textarea.value = text;
                if (wordCountEl) {
                    var n = countWords(text);
                    wordCountEl.textContent = n + ' / ' + maxWords + ' words';
                    wordCountEl.classList.toggle('ask-the-host-word-count-over', n > maxWords);
                }
            }
            if (dropdown) dropdown.classList.remove('ask-the-host-dropdown-open');
            textWrap.style.display = 'none';
            editWrap.style.display = 'block';
        });
    });

    // Edit cancel
    document.querySelectorAll('.ask-the-host-edit-cancel').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = btn.getAttribute('data-query-id');
            var textWrap = document.getElementById('questionTextWrap-' + id);
            var editWrap = document.getElementById('editWrap-' + id);
            if (textWrap) textWrap.style.display = '';
            if (editWrap) editWrap.style.display = 'none';
        });
    });

    // Edit form: word count and validation
    document.querySelectorAll('.ask-the-host-edit-textarea').forEach(function(ta) {
        ta.addEventListener('input', function() {
            var wrap = ta.closest('.ask-the-host-edit-wrap');
            var wc = wrap && wrap.querySelector('.ask-the-host-edit-word-count');
            if (!wc) return;
            var n = countWords(ta.value);
            wc.textContent = n + ' / ' + maxWords + ' words';
            wc.classList.toggle('ask-the-host-word-count-over', n > maxWords);
        });
    });
    document.querySelectorAll('.ask-the-host-edit-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            var ta = form.querySelector('.ask-the-host-edit-textarea');
            if (ta && countWords(ta.value) > maxWords) {
                e.preventDefault();
                alert('The question must not exceed 150 words. Please shorten your question.');
            }
        });
    });

    // Custom delete confirmation modal
    var confirmOverlay = document.getElementById('askTheHostConfirmOverlay');
    var confirmMessage = document.getElementById('askTheHostConfirmMessage');
    var confirmCancelBtn = document.getElementById('askTheHostConfirmCancel');
    var confirmDeleteBtn = document.getElementById('askTheHostConfirmDelete');
    var pendingDeleteForm = null;

    function openConfirmModal(message) {
        if (!confirmOverlay || !confirmMessage) return;
        pendingDeleteForm = null;
        confirmMessage.textContent = message;
        confirmOverlay.style.display = 'flex';
        confirmOverlay.setAttribute('aria-hidden', 'false');
        confirmDeleteBtn.focus();
    }
    function closeConfirmModal() {
        if (!confirmOverlay) return;
        confirmOverlay.style.display = 'none';
        confirmOverlay.setAttribute('aria-hidden', 'true');
        pendingDeleteForm = null;
    }
    confirmCancelBtn.addEventListener('click', closeConfirmModal);
    confirmDeleteBtn.addEventListener('click', function() {
        if (pendingDeleteForm) {
            pendingDeleteForm.submit();
        }
        closeConfirmModal();
    });
    confirmOverlay.addEventListener('click', function(e) {
        if (e.target === confirmOverlay) closeConfirmModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && confirmOverlay && confirmOverlay.getAttribute('aria-hidden') === 'false') {
            closeConfirmModal();
        }
    });

    // Delete question: show custom modal instead of submitting
    document.querySelectorAll('.ask-the-host-delete-form:not(.ask-the-host-reply-delete-form)').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            pendingDeleteForm = form;
            openConfirmModal('Are you sure you want to delete this question? This cannot be undone.');
        });
    });
    // Delete reply: show custom modal instead of submitting
    document.querySelectorAll('.ask-the-host-reply-delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            pendingDeleteForm = form;
            openConfirmModal('Are you sure you want to delete this reply?');
        });
    });
});
</script>
@endpush
