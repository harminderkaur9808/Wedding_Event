@extends('layouts.app')

@section('title', 'Travel & Accommodation - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/important-notification.css') }}">
@endpush

@section('content')
    <!-- First Section - Hero Banner -->
    <section class="important-notification-hero" aria-label="Travel & Accommodation">
        <div class="important-notification-hero-bg" aria-hidden="true">
            <img
                src="{{ asset('Images/notifications_imgs/Important_Notification_0.png') }}"
                alt="Travel & Accommodation"
                class="important-notification-hero-bg-img"
            >
        </div>
        <div class="important-notification-hero-overlay" aria-hidden="true"></div>
        <div class="container important-notification-hero-content">
            <div class="important-notification-hero-text">
                <div class="important-notification-hero-eyebrow">Travel & Accommodation</div>
                <div class="important-notification-hero-decorative">
                    <img src="{{ asset('Images/updates_by_family/hairbetweenmain.svg') }}" alt="" class="important-notification-hero-decorative-img">
                </div>
                <h1 class="important-notification-hero-title">Travel & Accommodation</h1>
            </div>
        </div>
    </section>

    <!-- Second Section - Notification List -->
    <section class="notif-section" aria-label="Notification list">
        <div class="notif-section-side-decor notif-section-side-decor--left" aria-hidden="true">
            <img src="{{ asset('Images/notifications_imgs/Left_decor_v1.png') }}" alt="" class="notif-section-side-decor-img">
        </div>
        <div class="notif-section-side-decor notif-section-side-decor--right" aria-hidden="true">
            <img src="{{ asset('Images/notifications_imgs/right_decor_v1.png') }}" alt="" class="notif-section-side-decor-img">
        </div>

        <div class="container notif-section-inner">
            <h2 class="notif-section-title">Notification</h2>

            <div class="notif-filters">
                <button type="button" class="notif-filter-btn notif-filter-btn--active" data-filter="all">All</button>
                @foreach($tagOptions ?? [] as $slug => $label)
                    <button type="button" class="notif-filter-btn" data-filter="{{ $slug }}">{{ $label }}</button>
                @endforeach
            </div>

            <div class="notif-list-wrap">
            <ul class="notif-list" id="notifList">
                @forelse($notes ?? [] as $note)
                    <li class="notif-item" data-tags="{{ is_array($note->tags) ? implode(',', $note->tags) : '' }}">
                        <div class="notif-item-avatar">
                            @if($note->user && $note->user->profile_image)
                                <img src="{{ secure_media_url('profile_images/' . $note->user->profile_image) }}" alt="" class="notif-item-avatar-img">
                            @else
                                <div class="notif-item-avatar-initials">{{ $note->user ? strtoupper(substr($note->user->first_name ?? '', 0, 1) . substr($note->user->last_name ?? '', 0, 1)) : '?' }}</div>
                            @endif
                        </div>
                        <div class="notif-item-body">
                            <div class="notif-item-name">{{ $note->user ? $note->user->first_name . ' ' . $note->user->last_name : 'Admin' }}</div>
                            <div class="notif-item-meta">
                                <span class="notif-item-date">
                                    <svg class="notif-item-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ $note->updated_at->format('d M Y') }}
                                </span>
                                <span class="notif-item-time">
                                    <svg class="notif-item-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ $note->updated_at->format('h:i A') }}
                                </span>
                            </div>
                            @php
                                $noteContent = $note->content ?: (string) $note->title;
                                $notePreview = Str::limit($noteContent, 200);
                                $noteIsLong = strlen($noteContent) > 200;
                            @endphp
                            <div class="notif-item-message-wrap">
                                @if($noteIsLong)
                                    <p class="notif-item-message notif-item-message-preview">{{ $notePreview }}</p>
                                    <p class="notif-item-message notif-item-message-full" aria-hidden="true" style="display: none;">{{ $noteContent }}</p>
                                    <button type="button" class="notif-see-more" aria-expanded="false">See more</button>
                                @else
                                    <p class="notif-item-message">{{ $noteContent }}</p>
                                @endif
                            </div>
                            @if(!empty($note->tags) && is_array($note->tags))
                                @foreach($note->tags as $tagSlug)
                                    @if(isset($tagOptions[$tagSlug]))
                                        <span class="notif-item-tag notif-item-tag--{{ $tagSlug }}">{{ $tagOptions[$tagSlug] }}</span>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="notif-item notif-item-empty">
                        <p class="notif-item-message">No notifications yet. Admins can create notes with tags and they will appear here.</p>
                    </li>
                @endforelse
            </ul>
            </div>

            @if(($notesTotalCount ?? 0) > 10)
            <div class="notif-see-all-wrap">
                <a href="{{ route('admin.dashboard', ['tab' => 'notes']) }}" class="notif-see-all">See All</a>
            </div>
            @endif
        </div>
    </section>

    @push('scripts')
    <script>
    (function() {
        var list = document.getElementById('notifList');
        var buttons = document.querySelectorAll('.notif-filter-btn');
        var duration = 350;

        function filterNotifs(filter) {
            buttons.forEach(function(b) { b.classList.remove('notif-filter-btn--active'); });
            var activeBtn = document.querySelector('.notif-filter-btn[data-filter="' + filter + '"]');
            if (activeBtn) activeBtn.classList.add('notif-filter-btn--active');

            var items = list ? list.querySelectorAll('.notif-item') : [];
            items.forEach(function(item) {
                if (item.classList.contains('notif-item-empty')) return;
                var tags = (item.getAttribute('data-tags') || '').split(',');
                var show = filter === 'all' || tags.indexOf(filter) !== -1;
                item.classList.remove('notif-item--show', 'notif-item--hidden');
                if (show) {
                    item.style.display = '';
                    item.style.visibility = 'visible';
                    item.offsetHeight;
                    item.classList.add('notif-item--show');
                } else {
                    item.classList.add('notif-item--hidden');
                    window.setTimeout(function() {
                        item.style.display = 'none';
                        item.classList.remove('notif-item--hidden');
                    }, duration);
                }
            });
        }

        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var filter = this.getAttribute('data-filter');
                filterNotifs(filter);
            });
        });

        // See more / See less for long notification messages
        document.querySelectorAll('.notif-see-more').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var wrap = this.closest('.notif-item-message-wrap');
                if (!wrap) return;
                var preview = wrap.querySelector('.notif-item-message-preview');
                var full = wrap.querySelector('.notif-item-message-full');
                var expanded = this.getAttribute('aria-expanded') === 'true';
                if (expanded) {
                    if (preview) preview.style.display = '';
                    if (full) full.style.display = 'none';
                    this.setAttribute('aria-expanded', 'false');
                    this.textContent = 'See more';
                } else {
                    if (preview) preview.style.display = 'none';
                    if (full) full.style.display = '';
                    this.setAttribute('aria-expanded', 'true');
                    this.textContent = 'See less';
                }
            });
        });
    })();
    </script>
    @endpush
@endsection
