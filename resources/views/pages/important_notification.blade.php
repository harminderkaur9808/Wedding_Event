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

    <!-- Second Section - Travel Information & Accommodation (two columns) -->
    <section class="ta-section" aria-label="Travel and Accommodation details">
        <div class="container ta-container">
            <div class="ta-two-col">
                <!-- Left: Travel Information -->
                <div class="ta-col ta-col-travel">
                    <div class="ta-block-header ta-block-header--travel" style="background-image: url('{{ asset('Images/Travel-Accommodation-imgs/Travel-Information-img-1-bg.png') }}');">
                        <div class="ta-block-header-inner">
                            <img src="{{ asset('Images/Travel-Accommodation-imgs/TravelInformation_ico.svg') }}" alt="" class="ta-block-header-icon" width="28" height="28" aria-hidden="true">
                            <span class="ta-block-header-line" aria-hidden="true"></span>
                            <h2 class="ta-block-header-title">Travel Information</h2>
                        </div>
                        <img src="{{ asset('Images/Travel_accommodation/Left_decor_v1.png') }}" alt="" class="ta-block-header-decor ta-block-header-decor--left" aria-hidden="true">
                        <img src="{{ asset('Images/Travel_accommodation/right_decor_v1.png') }}" alt="" class="ta-block-header-decor ta-block-header-decor--right" aria-hidden="true">
                    </div>
                    <div class="ta-block-list">
                        @if($travelNote && !empty(trim($travelNote->description ?? '')))
                            @php
                                $travelParas = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $travelNote->description ?? '')));
                            @endphp
                            <div class="ta-section-note">
                                <ul class="ta-section-note-list">
                                    @foreach($travelParas as $para)
                                        <li class="ta-section-note-text">{{ $para }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @forelse($travelEntries ?? [] as $entry)
                            <div class="ta-item">
                                <div class="ta-item-name">{{ $entry->name ?: '—' }}</div>
                                @if(!empty(trim($entry->address ?? '')))
                                    <div class="ta-item-row"><strong>Address:</strong> {{ $entry->address }}</div>
                                @endif
                                @if(!empty(trim($entry->phone ?? '')))
                                    <div class="ta-item-row"><strong>Phone:</strong> {{ $entry->phone }}</div>
                                @endif
                                @if(!empty(trim($entry->website ?? '')))
                                    <div class="ta-item-row"><strong>Website:</strong> <a class="ta-link" href="{{ $entry->website }}" target="_blank" rel="noopener noreferrer">{{ !empty(trim($entry->website_label ?? '')) ? $entry->website_label : Str::limit($entry->website, 50) }}</a></div>
                                @endif
                                @if(!empty(trim($entry->map_url ?? '')))
                                    <div class="ta-item-row"><strong>Map Link:</strong> <a class="ta-link" href="{{ $entry->map_url }}" target="_blank" rel="noopener noreferrer">Click Here</a></div>
                                @endif
                            </div>
                        @empty
                            @if(!$travelNote || empty(trim($travelNote->description ?? '')))
                                <p class="ta-empty">No travel information or note yet.</p>
                            @endif
                        @endforelse
                    </div>
                </div>

                <!-- Right: Accommodation -->
                <div class="ta-col ta-col-accommodation">
                    <div class="ta-block-header ta-block-header--accommodation" style="background-image: url('{{ asset('Images/Travel-Accommodation-imgs/Accommodation-1-img-bg.png') }}');">
                        <div class="ta-block-header-inner">
                            <img src="{{ asset('Images/Travel-Accommodation-imgs/Accommodation_ico.svg') }}" alt="" class="ta-block-header-icon" width="28" height="28" aria-hidden="true">
                            <span class="ta-block-header-line" aria-hidden="true"></span>
                            <h2 class="ta-block-header-title">Accommodation</h2>
                        </div>
                        <img src="{{ asset('Images/Travel_accommodation/Left_decor_v1.png') }}" alt="" class="ta-block-header-decor ta-block-header-decor--left" aria-hidden="true">
                        <img src="{{ asset('Images/Travel_accommodation/right_decor_v1.png') }}" alt="" class="ta-block-header-decor ta-block-header-decor--right" aria-hidden="true">
                    </div>
                    <div class="ta-block-list">
                        @if($accommodationNote && !empty(trim($accommodationNote->description ?? '')))
                            @php
                                $accommodationParas = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $accommodationNote->description ?? '')));
                            @endphp
                            <div class="ta-section-note">
                                <ul class="ta-section-note-list">
                                    @foreach($accommodationParas as $para)
                                        <li class="ta-section-note-text">{{ $para }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @forelse($accommodationEntries ?? [] as $entry)
                            <div class="ta-item">
                                <div class="ta-item-name">{{ $entry->name ?: '—' }}</div>
                                @if(!empty(trim($entry->address ?? '')))
                                    <div class="ta-item-row"><strong>Address:</strong> {{ $entry->address }}</div>
                                @endif
                                @if(!empty(trim($entry->phone ?? '')))
                                    <div class="ta-item-row"><strong>Phone:</strong> {{ $entry->phone }}</div>
                                @endif
                                @if(!empty(trim($entry->website ?? '')))
                                    <div class="ta-item-row"><strong>Website:</strong> <a class="ta-link" href="{{ $entry->website }}" target="_blank" rel="noopener noreferrer">{{ !empty(trim($entry->website_label ?? '')) ? $entry->website_label : Str::limit($entry->website, 50) }}</a></div>
                                @endif
                                @if(!empty(trim($entry->map_url ?? '')))
                                    <div class="ta-item-row"><strong>Map Link:</strong> <a class="ta-link" href="{{ $entry->map_url }}" target="_blank" rel="noopener noreferrer">Click Here</a></div>
                                @endif
                            </div>
                        @empty
                            @if(!$accommodationNote || empty(trim($accommodationNote->description ?? '')))
                                <p class="ta-empty">No accommodation or note yet.</p>
                            @endif
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
