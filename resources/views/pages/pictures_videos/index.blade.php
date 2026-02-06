@extends('layouts.app')

@section('title', 'Pictures and Videos - Wedding Event')

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pictures-videos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-gate.css') }}">
@endpush

@section('content')
    @include('pages.pictures_videos.partials.hero-section')
    @auth
        @include('pages.pictures_videos.partials.gallery-section')
    @else
        @include('partials.login-required-card', ['message' => 'Please log in to view pictures and videos.'])
    @endauth
@endsection

@push('scripts')
<script>
(function() {
    function initPicturesVideosReveal() {
        var hero = document.querySelector('.wm-pv-reveal');
        if (hero) hero.classList.add('wm-pv-in-view');
        var section = document.querySelector('.wm-pv-animate');
        if (!section) return;
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) entry.target.classList.add('wm-pv-in-view');
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
        observer.observe(section);
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPicturesVideosReveal);
    } else {
        initPicturesVideosReveal();
    }
})();
</script>
@endpush

