@extends('layouts.app')

@section('title', 'الأطباء')

@section('content')
<section class="bg-surface py-16">
    <div class="mx-auto max-w-7xl px-4 lg:px-6">
        <div class="text-right">
            <h1 class="text-3xl font-bold text-[#222]">الأطباء</h1>
            <div class="mt-2 h-[3px] w-12 bg-accent-red"></div>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach($doctors as $doctor)
                @include('components.doctor-card', ['doctor' => $doctor, 'bookButtonLabel' => 'احجز موعد'])
            @endforeach
        </div>
    </div>
</section>
@endsection
