@extends('layouts.app')

@section('title', 'Pictures and Videos - Wedding Event')

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pictures-videos.css') }}">
@endpush

@section('content')
    @include('pages.pictures_videos.partials.hero-section')
    @auth
        @include('pages.pictures_videos.partials.gallery-section')
    @else
        <section class="wm-pv-login-gate">
            <div class="wm-pv-login-required">
                <div class="wm-pv-login-icon" aria-hidden="true">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 11V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h2 class="wm-pv-login-title">Login required</h2>
                <p class="wm-pv-login-message">Please log in to view pictures and videos.</p>
                <a href="{{ route('login', ['intended' => url()->current()]) }}" class="wm-pv-login-btn">Go to Login</a>
            </div>
        </section>
    @endauth
@endsection

