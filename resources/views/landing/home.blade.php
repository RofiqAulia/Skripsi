@extends('layouts.app')

@section('content')

    {{-- 🔥 HERO SECTION --}}
    @include('sections.home.hero')

    {{-- 🔥 SUPPORT (LOGO COMPANY) --}}
    @include('sections.home.support')

    {{-- 🔥 PROBLEM - SOLUTIONS --}}
    @include('sections.home.problem-solutions')

    {{-- 🔥 FEATURES --}}
    @include('sections.home.features')

    {{-- 🔥 SCHOLARSHIP --}}
    @include('sections.home.scholarship')

    {{-- 🔥 CTA --}}
    @include('sections.home.cta')

@endsection