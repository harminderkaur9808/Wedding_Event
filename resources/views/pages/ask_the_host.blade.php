@extends('layouts.app')

@section('title', 'Ask the Host - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/ask-the-host.css') }}">
@endpush

@section('content')
    <!-- Hero Section (1/4 height of reference hero, overlay #054C82) -->
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

    <!-- Content Section -->
    <section class="ask-the-host-content">
        <div class="container">
            <p class="ask-the-host-intro">Use this page to ask the hosts any questions about the wedding. Content and form can be added here.</p>
        </div>
    </section>
@endsection
