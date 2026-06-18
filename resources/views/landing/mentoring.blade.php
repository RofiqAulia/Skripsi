@extends('layouts.app')

@section('content')

@include('sections.mentoring.hero')

@include('sections.mentoring.choose-mentor', ['mentors' => $mentors, 'lockedMentorId' => $lockedMentorId ?? null])

@include('sections.mentoring.schedule')

@endsection