@extends('layouts.app')

@section('title', 'Local Attractions - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/local-attractions.css') }}">
    <link rel="stylesheet" href="{{ asset('css/book-appointments.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-gate.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
@endpush

@section('content')
    @include('pages.local_attractions.partials.hero-section')
    @auth
        @include('pages.local_attractions.partials.attractions-list', ['attractions' => $attractions ?? collect()])
    @else
        @include('partials.login-required-card', ['message' => 'Please log in to view local attractions.'])
    @endauth
@endsection

@push('scripts')
<script>
(function() {
    function initScrollReveal() {
        var hero = document.querySelector('.wm-la-reveal');
        if (hero) {
            hero.classList.add('wm-la-in-view');
        }
        var items = document.querySelectorAll('.wm-la-animate');
        if (!items.length) return;
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('wm-la-in-view');
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        items.forEach(function(el) { observer.observe(el); });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScrollReveal);
    } else {
        initScrollReveal();
    }
})();
</script>
@endpush
