<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Wedding Event - Vickram & Nisha')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Volkhov:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hero-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/our-story-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/third-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fourth-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fifth-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sixth-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/seventh-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ninth-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tenth-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/eleventh-section.css') }}">
    @stack('styles')
</head>
<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Scripts -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/our-story-animation.js') }}"></script>
    <script src="{{ asset('js/countdown.js') }}"></script>
    <script src="{{ asset('js/section-reveal.js') }}"></script>
    @stack('scripts')
</body>
</html>
