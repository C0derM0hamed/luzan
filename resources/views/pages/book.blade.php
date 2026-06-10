@extends('layouts.app')

@section('title', 'حجز موعد')

@section('content')
<section class="bg-surface py-16">
    <div class="mx-auto max-w-3xl px-4 lg:px-6">
        @include('components.booking-form')
    </div>
</section>
@endsection
