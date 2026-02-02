@extends('layouts.app')

@section('title', 'Updates by Family - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/updates-by-family.css') }}">
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
        <div class="container updates-by-family-hero-content">
            <div class="updates-by-family-hero-text">
                <div class="updates-by-family-hero-eyebrow">Family Updates</div>
                <div class="updates-by-family-hero-decorative">
                    <img src="{{ asset('Images/updates_by_family/hairbetweenmain.svg') }}" alt="" class="updates-by-family-hero-decorative-img">
                </div>
                <h1 class="updates-by-family-hero-title">Updates by family</h1>
            </div>
        </div>
    </section>

    <!-- Second Section: Timeline (Family Updates) – same to same UI -->
    <section class="updates-by-family-timeline">
        <!-- Left decorative image -->
        <div class="updates-by-family-side-img updates-by-family-side-img--left" aria-hidden="true">
            <img src="{{ asset('Images/updates_by_family/Left_side_image_ico.png') }}" alt="" class="updates-by-family-side-img-file">
        </div>
        <!-- Right decorative image -->
        <div class="updates-by-family-side-img updates-by-family-side-img--right" aria-hidden="true">
            <img src="{{ asset('Images/updates_by_family/right_side_image_ico.png') }}" alt="" class="updates-by-family-side-img-file">
        </div>

        <div class="updates-by-family-timeline-inner">
            <!-- Central timeline axis -->
            <div class="updates-by-family-timeline-axis"></div>

            <!-- Year marker at top -->
            <div class="updates-by-family-timeline-year">2026</div>

            <!-- Timeline entries (alternating left/right) -->
            <article class="updates-by-family-entry updates-by-family-entry--right">
                <div class="updates-by-family-entry-node">
                    <div class="updates-by-family-entry-avatar">
                        <img src="{{ asset('Images/updates_by_family/Updates_by_family.png') }}" alt="Jasmine Sra">
                    </div>
                </div>
                <div class="updates-by-family-entry-user">
                    <span class="updates-by-family-entry-name">Jasmine Sra</span>
                    <span class="updates-by-family-entry-meta">
                        <svg class="updates-by-family-entry-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        05 feb 2026, <svg class="updates-by-family-entry-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 03:00 pm
                    </span>
                </div>
                <div class="updates-by-family-entry-msg updates-by-family-entry-msg--blue">
                    <p>We will be travelling by bus from Phoenix to CA on Dec 30th.</p>
                </div>
            </article>

            <article class="updates-by-family-entry updates-by-family-entry--left">
                <div class="updates-by-family-entry-node">
                    <div class="updates-by-family-entry-avatar">
                        <img src="{{ asset('Images/updates_by_family/Updates_by_family.png') }}" alt="Jasmine Sra">
                    </div>
                </div>
                <div class="updates-by-family-entry-user">
                    <span class="updates-by-family-entry-name">Jasmine Sra</span>
                    <span class="updates-by-family-entry-meta">
                        <svg class="updates-by-family-entry-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        05 feb 2026, <svg class="updates-by-family-entry-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 03:00 pm
                    </span>
                </div>
                <div class="updates-by-family-entry-msg updates-by-family-entry-msg--purple">
                    <p>We will be travelling by bus from Phoenix to CA on Dec 30th.</p>
                </div>
            </article>

            <article class="updates-by-family-entry updates-by-family-entry--right">
                <div class="updates-by-family-entry-node">
                    <div class="updates-by-family-entry-avatar">
                        <img src="{{ asset('Images/updates_by_family/Updates_by_family.png') }}" alt="Jasmine Sra">
                    </div>
                </div>
                <div class="updates-by-family-entry-user">
                    <span class="updates-by-family-entry-name">Jasmine Sra</span>
                    <span class="updates-by-family-entry-meta">
                        <svg class="updates-by-family-entry-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        05 feb 2026, <svg class="updates-by-family-entry-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 03:00 pm
                    </span>
                </div>
                <div class="updates-by-family-entry-msg updates-by-family-entry-msg--lightblue">
                    <p>We will be travelling by bus from Phoenix to CA on Dec 30th.</p>
                </div>
            </article>

            <article class="updates-by-family-entry updates-by-family-entry--left">
                <div class="updates-by-family-entry-node">
                    <div class="updates-by-family-entry-avatar">
                        <img src="{{ asset('Images/updates_by_family/Updates_by_family.png') }}" alt="Jasmine Sra">
                    </div>
                </div>
                <div class="updates-by-family-entry-user">
                    <span class="updates-by-family-entry-name">Jasmine Sra</span>
                    <span class="updates-by-family-entry-meta">
                        <svg class="updates-by-family-entry-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        05 feb 2026, <svg class="updates-by-family-entry-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 03:00 pm
                    </span>
                </div>
                <div class="updates-by-family-entry-msg updates-by-family-entry-msg--blue">
                    <p>We will be travelling by bus from Phoenix to CA on Dec 30th.</p>
                </div>
            </article>
        </div>
    </section>

    <!-- Content Section -->
    <section class="updates-by-family-content">
        <div class="container">
            <p class="updates-by-family-intro">Family updates and content can be added here.</p>
        </div>
    </section>
@endsection
