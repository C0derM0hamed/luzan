@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
    @include('components.hero')

    <div id="services">
        @include('components.services-section')
    </div>

    <section class="bg-surface py-20 border-t border-slate-100">
        <div class="mx-auto max-w-7xl px-4 lg:px-6">
            @include('components.doctors-section')
        </div>
    </section>

    <section class="bg-white py-20 border-t border-slate-100">
        <div class="mx-auto max-w-7xl px-4 lg:px-6">
            @include('components.branches-section')
        </div>
    </section>
@endsection
