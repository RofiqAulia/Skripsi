@extends('layouts.app')

@section('content')

    {{-- 🔥 HERO SECTION --}}
    @include('sections.about.hero')

    {{-- 🔥 WHO ABOUT --}}
    <!-- @include('sections.about.about-who') -->

    {{-- STORYTELLING --}}
    @include('sections.about.storytelling')

    {{-- 🔥 VISION & MISSION --}}
    @include('sections.about.vision-missions')

    {{-- 🔥 IMPACT --}}
    {{-- @include('sections.about.impact') --}}

@endsection