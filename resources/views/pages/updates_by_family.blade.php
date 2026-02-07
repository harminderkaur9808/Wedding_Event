@extends('layouts.app')

@section('title', 'Updates by Family - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/updates-by-family.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-gate.css') }}">
@endpush

@section('content')
    <!-- Hero Section (first section) – overlay #054C82 -->
    <section class="updates-by-family-hero" id="updates-by-family">
        <div class="updates-by-family-hero-bg" aria-hidden="true">
            <img
                src="{{ asset('Images/updates_by_family/Updates_by_family.png') }}"
                alt=""
                class="updates-by-family-hero-bg-img"
            >
        </div>
        <div class="updates-by-family-hero-overlay" aria-hidden="true"></div>
        <div class="container updates-by-family-hero-content ubf-reveal">
            <div class="updates-by-family-hero-text">
                <div class="updates-by-family-hero-eyebrow">Family Updates</div>
                <div class="updates-by-family-hero-decorative">
                    <img src="{{ asset('Images/updates_by_family/hairbetweenmain.svg') }}" alt="" class="updates-by-family-hero-decorative-img">
                </div>
                <h1 class="updates-by-family-hero-title">Updates by family</h1>
            </div>
        </div>
    </section>

    @auth
    <!-- Admin: Add new update bar (only visible to admin) -->
        @if(Auth::user()->isAdmin())
            <div class="updates-by-family-add-bar ubf-animate">
                <div class="container updates-by-family-add-bar-inner">
                    <button type="button" class="updates-by-family-add-btn" data-bs-toggle="modal" data-bs-target="#addUpdateModal" aria-label="Add new update">
                        <svg class="updates-by-family-add-btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Add new update
                    </button>
                </div>
            </div>
        @endif

    @if(session('success'))
        <div class="updates-by-family-toast-wrap" role="alert" id="updates-by-family-toast-success">
            <div class="updates-by-family-toast updates-by-family-toast--success">
                <span class="updates-by-family-toast-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </span>
                <span class="updates-by-family-toast-text">{{ session('success') }}</span>
                <button type="button" class="updates-by-family-toast-close" aria-label="Close" onclick="this.closest('.updates-by-family-toast-wrap').remove()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
                <div class="updates-by-family-toast-progress" data-duration="4"></div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="updates-by-family-toast-wrap" role="alert" id="updates-by-family-toast-error">
            <div class="updates-by-family-toast updates-by-family-toast--error">
                <span class="updates-by-family-toast-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </span>
                <span class="updates-by-family-toast-text">{{ session('error') }}</span>
                <button type="button" class="updates-by-family-toast-close" aria-label="Close" onclick="this.closest('.updates-by-family-toast-wrap').remove()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
                <div class="updates-by-family-toast-progress updates-by-family-toast-progress--error" data-duration="4"></div>
            </div>
        </div>
    @endif

    <!-- Second Section: Timeline (Family Updates) – only when logged in -->
    <section class="updates-by-family-timeline">
        <!-- Left decorative image -->
        <div class="updates-by-family-side-img updates-by-family-side-img--left" aria-hidden="true">
            <img src="{{ asset('Images/updates_by_family/Left_side_image_ico.png') }}" alt="" class="updates-by-family-side-img-file">
        </div>
        <!-- Right decorative image -->
        <div class="updates-by-family-side-img updates-by-family-side-img--right" aria-hidden="true">
            <img src="{{ asset('Images/updates_by_family/right_side_image_ico.png') }}" alt="" class="updates-by-family-side-img-file">
        </div>

        <div class="updates-by-family-timeline-inner ubf-animate">
            <!-- Central timeline axis -->
            <div class="updates-by-family-timeline-axis"></div>

            <!-- Line segment above year (white circle + line down to 2026) -->
            <div class="updates-by-family-timeline-line-above-year">
                <span class="updates-by-family-timeline-top-circle"></span>
                <span class="updates-by-family-timeline-line-segment"></span>
            </div>

            <!-- Year marker at top -->
            <div class="updates-by-family-timeline-year">2026</div>

            <!-- Timeline entries (dynamic, newest first) -->
            @php
                $bubbleColors = ['blue', 'purple', 'lightblue'];
            @endphp
            @forelse($updates as $index => $update)
                @php
                    /* Alternate right / left per entry (like reference: 1st right, 2nd left, 3rd right, 4th left) */
                    $side = $index % 2 === 0 ? 'right' : 'left';
                    /* Alternating left position: 1st/3rd/5th/7th = 16px, 2nd/4th/6th = -10px */
                    $posClass = $index % 2 === 0 ? 'pos-1' : 'pos-2';
                    $color = $bubbleColors[$index % 3];
                    $user = $update->user;
                    $name = $user ? $user->full_name : 'Admin';
                    $hasImage = $user && $user->profile_image;
                    $initials = null;
                    if ($user && !$hasImage) {
                        if (!empty($user->first_name) && !empty($user->last_name)) {
                            $initials = strtoupper(mb_substr($user->first_name, 0, 1) . mb_substr($user->last_name, 0, 1));
                        } else {
                            $fallback = trim($user->full_name ?: $user->email ?? 'A');
                            $initials = $fallback ? strtoupper(mb_substr($fallback, 0, 2)) : 'A';
                        }
                    }
                    $dateTime = $update->created_at->format('d M Y, h:i a');
                @endphp
                <article class="updates-by-family-entry updates-by-family-entry--{{ $side }} updates-by-family-entry--{{ $posClass }} ubf-animate-entry">
                    <div class="updates-by-family-entry-node">
                        <div class="updates-by-family-entry-avatar">
                            @if($hasImage)
                                <img src="{{ secure_media_url('profile_images/' . $user->profile_image) }}" alt="{{ $name }}">
                            @else
                                <span class="updates-by-family-entry-avatar-initials" aria-hidden="true">{{ $initials ?? 'A' }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="updates-by-family-entry-user">
                        <span class="updates-by-family-entry-name">{{ $name }}</span>
                        <span class="updates-by-family-entry-meta">
                            <svg class="updates-by-family-entry-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $dateTime }}
                        </span>
                    </div>
                    <div class="updates-by-family-entry-msg-wrap">
                        <div class="updates-by-family-entry-msg updates-by-family-entry-msg--{{ $color }}">
                            <p>{{ nl2br(e($update->message)) }}</p>
                        </div>
                        @auth
                            @if(Auth::id() === $update->user_id)
                                <div class="updates-by-family-entry-actions">
                                    <button type="button" class="updates-by-family-action-btn updates-by-family-action-btn--edit" aria-label="Edit update" title="Edit" data-update-id="{{ $update->id }}" data-update-message="{{ e($update->message) }}">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button type="button" class="updates-by-family-action-btn updates-by-family-action-btn--delete" aria-label="Delete update" title="Delete" data-delete-url="{{ route('updates.by.family.destroy', $update) }}">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>
                </article>
            @empty
                <div class="updates-by-family-empty">
                    <p>No family updates yet. Check back soon.</p>
                </div>
            @endforelse

            <!-- White circle at end of timeline (empty, blue outline) -->
            <div class="updates-by-family-timeline-end-dot">
                <span class="updates-by-family-timeline-end-circle"></span>
            </div>
        </div>
    </section>

    @else
    @include('partials.login-required-card', ['message' => 'Please log in to view updates by family.'])
    @endauth

    <!-- Content Section -->
    <!-- <section class="updates-by-family-content">
        <div class="container">
            <p class="updates-by-family-intro">Family updates and content can be added here.</p>
        </div>
    </section> -->

    <!-- Modal: Add new update (admin only) -->
    @auth
        @if(Auth::user()->isAdmin())
            <div class="modal fade" id="addUpdateModal" tabindex="-1" aria-labelledby="addUpdateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content updates-by-family-modal-content">
                        <div class="modal-header updates-by-family-modal-header">
                            <h2 class="modal-title updates-by-family-modal-title" id="addUpdateModalLabel">Add new update</h2>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('updates.by.family.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <label for="family_update_message" class="form-label">Your update</label>
                                <textarea name="message" id="family_update_message" class="form-control updates-by-family-modal-textarea" rows="4" placeholder="Share an update with the family…" required maxlength="2000">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">This will appear on the timeline with your name and profile picture.</div>
                            </div>
                            <div class="modal-footer updates-by-family-modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn updates-by-family-modal-submit">Post update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <!-- Modal: Delete confirmation (opened by JS when delete icon is clicked) -->
    @auth
        <div class="modal fade" id="deleteUpdateModal" tabindex="-1" aria-labelledby="deleteUpdateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content updates-by-family-modal-content updates-by-family-modal-content--delete">
                    <div class="modal-header updates-by-family-modal-header updates-by-family-modal-header--danger">
                        <h2 class="modal-title updates-by-family-modal-title" id="deleteUpdateModalLabel">Delete update</h2>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="updates-by-family-delete-confirm-text">Are you sure you want to delete this update? This cannot be undone.</p>
                    </div>
                    <form id="deleteUpdateForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="modal-footer updates-by-family-modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn updates-by-family-modal-btn-delete">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth

    <!-- Modal: Edit update (only for own updates; opened by JS) -->
    @auth
        <div class="modal fade" id="editUpdateModal" tabindex="-1" aria-labelledby="editUpdateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content updates-by-family-modal-content">
                    <div class="modal-header updates-by-family-modal-header">
                        <h2 class="modal-title updates-by-family-modal-title" id="editUpdateModalLabel">Edit update</h2>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editUpdateForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <label for="edit_family_update_message" class="form-label">Your update</label>
                            <textarea name="message" id="edit_family_update_message" class="form-control updates-by-family-modal-textarea" rows="4" placeholder="Share an update with the family…" required maxlength="2000"></textarea>
                            <div id="edit_update_message_error" class="invalid-feedback d-block" style="display: none !important;"></div>
                        </div>
                        <div class="modal-footer updates-by-family-modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn updates-by-family-modal-submit">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth
@endsection

@push('scripts')
    <script>
    (function() {
        function initUpdatesByFamilyReveal() {
            var hero = document.querySelector('.ubf-reveal');
            if (hero) hero.classList.add('ubf-in-view');
            var sections = document.querySelectorAll('.ubf-animate');
            if (!sections.length) return;
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) entry.target.classList.add('ubf-in-view');
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
            sections.forEach(function(el) { observer.observe(el); });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initUpdatesByFamilyReveal);
        } else {
            initUpdatesByFamilyReveal();
        }
    })();
    </script>
    @if(session('success') || session('error'))
        <script>
            (function() {
                var wraps = document.querySelectorAll('.updates-by-family-toast-wrap');
                var duration = 4000;
                wraps.forEach(function(wrap) {
                    var progress = wrap.querySelector('.updates-by-family-toast-progress');
                    if (progress) progress.style.animationDuration = (duration / 1000) + 's';
                    var hide = function() {
                        wrap.classList.add('updates-by-family-toast-wrap--hiding');
                        setTimeout(function() { wrap.remove(); }, 320);
                    };
                    var t = setTimeout(hide, duration);
                    var closeBtn = wrap.querySelector('.updates-by-family-toast-close');
                    if (closeBtn) closeBtn.addEventListener('click', function() { clearTimeout(t); hide(); });
                });
            })();
        </script>
    @endif
    @auth
        @if(Auth::user()->isAdmin())
            <script>
                (function() {
                    var modalEl = document.getElementById('addUpdateModal');
                    if (!modalEl || typeof bootstrap === 'undefined') return;
                    var modal = new bootstrap.Modal(modalEl);
                    modalEl.addEventListener('show.bs.modal', function() {
                        var ta = document.getElementById('family_update_message');
                        if (ta) ta.value = ta.value || '';
                    });
                    @if($errors->has('message'))
                        modal.show();
                    @endif
                })();
            </script>
        @endif
        <script>
            (function() {
                function openEditUpdateModal(id, message) {
                    var form = document.getElementById('editUpdateForm');
                    var ta = document.getElementById('edit_family_update_message');
                    if (!form || !ta) return;
                    form.action = '{{ url('updates-by-family') }}/' + id;
                    ta.value = message || '';
                    var modalEl = document.getElementById('editUpdateModal');
                    if (modalEl && typeof bootstrap !== 'undefined') {
                        var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.show();
                    }
                }
                window.openEditUpdateModal = openEditUpdateModal;
                document.querySelectorAll('.updates-by-family-action-btn--edit').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var id = this.getAttribute('data-update-id');
                        var msg = this.getAttribute('data-update-message') || '';
                        openEditUpdateModal(id, msg);
                    });
                });

                // Delete confirmation modal
                var deleteForm = document.getElementById('deleteUpdateForm');
                var deleteModalEl = document.getElementById('deleteUpdateModal');
                if (deleteForm && deleteModalEl) {
                    document.querySelectorAll('.updates-by-family-action-btn--delete').forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            var url = this.getAttribute('data-delete-url');
                            if (url) {
                                deleteForm.action = url;
                                if (typeof bootstrap !== 'undefined') {
                                    var modal = bootstrap.Modal.getOrCreateInstance(deleteModalEl);
                                    modal.show();
                                }
                            }
                        });
                    });
                }
            })();
        </script>
    @endauth
@endpush
