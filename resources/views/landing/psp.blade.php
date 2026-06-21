@extends('layouts.app')

@section('content')

    {{-- 🔥 HERO SECTION --}}
    @include('sections.psp.hero')

    {{-- 🔥FEATURE --}}
    @include('sections.psp.feature')

    {{-- 🔥 TABLE SCHOLARSHIP --}}
    @include('sections.psp.table-list-scholar')

    {{-- 🔥 SUBMIT STUDY PLAN --}}
    @include('sections.psp.submit-study-plan')

    {{-- 🔥 PROGRESS TRACKER --}}
    @include('sections.psp.progress')

    {{-- 🔥 MODAL SUGGEST PROGRAM --}}
    @include('partials.modal-suggest-program')

    {{-- 🔥 MODAL MY SUGGESTIONS --}}
    @include('partials.modal-my-suggestions')

@endsection