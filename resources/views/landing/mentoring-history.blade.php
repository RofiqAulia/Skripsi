@extends('layouts.app')

@section('content')

@include('sections.mentoring.hero', ['menu' => 'Mentoring', 'submenu' => 'Session History'])

@include('sections.mentoring.history')

@endsection
