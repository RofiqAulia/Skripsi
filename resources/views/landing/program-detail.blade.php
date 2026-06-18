@extends('layouts.app')

@section('content')
    @include('sections.psp.program-detail', ['program' => $program])
@endsection
