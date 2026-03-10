@extends('layouts.app')

@section('title', 'Wedding Event - Vickram & Nisha')

@section('content')
    @include('Homepages.partials.hero-section')
    {{-- Our Story section – commented out for now --}}
    {{-- @include('Homepages.partials.our-story-section') --}}
    {{-- Third section (Date We Getting Married countdown block) – commented out for now; countdown is in top header --}}
    {{-- @include('Homepages.partials.third-section') --}}
    @include('Homepages.partials.fourth-section')
    @include('Homepages.partials.fifth-section')
    @include('Homepages.partials.seventh-section')
    @include('Homepages.partials.sixth-section')
    @include('Homepages.partials.ninth-section')
    @include('Homepages.partials.tenth-section')
    @include('Homepages.partials.eleventh-section')
    @include('Homepages.partials.twelfth-section')

    <!-- <div class="wedding-mele-welcome-content">
        <div class="container">
            <div class="wedding-mele-welcome-section">
                <h1 class="wedding-mele-welcome-title">Welcome to Our Wedding</h1>
                <p class="wedding-mele-welcome-text">Join us in celebrating this special day</p>
                </div>
        </div>
    </div> -->
@endsection
