@extends('layouts.app')

@section('content')
    @include('sections.psp.detail', ['scholarship' => $scholarship])
@endsection
