@extends('layouts.app')

@section('title', 'شروط الاستخدام')

@section('content')
    <!-- Header Banner -->
    <section class="relative bg-gradient-to-r from-primary to-primary-dark py-20 text-white overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-accent-blue/20 blur-3xl"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 text-center lg:px-6">
            <h1 class="text-4xl font-extrabold sm:text-5xl leading-tight">شروط الاستخدام</h1>
        </div>
    </section>

    <!-- Content Area -->
    <section class="bg-white py-20">
        <div class="mx-auto max-w-4xl px-4 lg:px-6">
            <div class="text-lg text-slate-600 leading-relaxed space-y-6 text-justify">
                <p>
                    {!! nl2br(e($termsContent)) !!}
                </p>
            </div>
        </div>
    </section>
@endsection