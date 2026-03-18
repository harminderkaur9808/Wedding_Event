@extends('layouts.app')

@section('title', 'Wedding Event - Vickram & Nisha')

@section('content')
    @if(($sections['hero'] ?? null)?->is_visible !== false)
        @include('Homepages.partials.hero-section')
    @endif
    {{-- Our Story section – commented out for now --}}
    {{-- @include('Homepages.partials.our-story-section') --}}
    {{-- Third section (Date We Getting Married countdown block) – commented out for now; countdown is in top header --}}
    {{-- @include('Homepages.partials.third-section') --}}
    @if(($sections['fourth'] ?? null)?->is_visible !== false)
        @include('Homepages.partials.fourth-section')
    @endif
    @if(($sections['fifth'] ?? null)?->is_visible !== false)
        @include('Homepages.partials.fifth-section')
    @endif
    @if(($sections['seventh'] ?? null)?->is_visible !== false)
        @include('Homepages.partials.seventh-section')
    @endif
    @if(($sections['sixth'] ?? null)?->is_visible !== false)
        @include('Homepages.partials.sixth-section')
    @endif
    @if(($sections['ninth'] ?? null)?->is_visible !== false)
        @include('Homepages.partials.ninth-section')
    @endif
    @if(($sections['tenth'] ?? null)?->is_visible !== false)
        @include('Homepages.partials.tenth-section')
    @endif
    @if(($sections['eleventh'] ?? null)?->is_visible !== false)
        @include('Homepages.partials.eleventh-section')
    @endif
    @if(($sections['twelfth'] ?? null)?->is_visible !== false)
        @include('Homepages.partials.twelfth-section')
    @endif
    @if(($sections['thirteenth'] ?? null)?->is_visible)
        @include('Homepages.partials.thirteenth-section')
    @endif

    <!-- <div class="wedding-mele-welcome-content">
        <div class="container">
            <div class="wedding-mele-welcome-section">
                <h1 class="wedding-mele-welcome-title">Welcome to Our Wedding</h1>
                <p class="wedding-mele-welcome-text">Join us in celebrating this special day</p>
                </div>
        </div>
    </div> -->
@endsection
