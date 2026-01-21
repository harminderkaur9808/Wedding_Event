@extends('layouts.app')

@section('title', 'Pictures and Videos - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pictures-videos.css') }}">
@endpush

@section('content')
    @include('pages.pictures_videos.partials.hero-section')

    {{-- Add your next sections here (gallery grid, videos, etc.) --}}
@endsection

