@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
    @include('components.hero')

    <div id="services">
        @include('components.services-section')
    </div>

    @include('components.doctors-section')

    @include('components.branches-section')
@endsection
