@extends('layouts.app')

@section('title', 'الخدمات')

@section('content')
<!-- Header Banner -->
<section class="relative bg-gradient-to-r from-primary to-primary-dark py-20 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-accent-blue/20 blur-3xl"></div>
    
    <div class="relative z-10 mx-auto max-w-7xl px-4 text-center lg:px-6">
        <h1 class="text-4xl font-extrabold sm:text-5xl leading-tight">خدماتنا الطبية</h1>
        <p class="mt-4 text-lg text-white/90 max-w-2xl mx-auto">نقدم مجموعة متكاملة من الخدمات الطبية والرعاية الصحية التخصصية بأعلى جودة</p>
    </div>
</section>

<!-- Content Area -->
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($services as $service)
                <div class="group relative overflow-hidden rounded-3xl border border-slate-100 bg-white p-8 text-center shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-primary/20 hover:shadow-lg">
                    <!-- Background subtle hover shape -->
                    <div class="absolute -right-16 -top-16 h-32 w-32 rounded-full bg-primary/5 transition-all duration-500 group-hover:scale-150"></div>
                    
                    <!-- Icon wrapper -->
                    <div class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 text-primary transition-all duration-500 group-hover:scale-110 group-hover:from-primary group-hover:to-primary-dark group-hover:text-white group-hover:shadow-lg [&_svg]:h-8 [&_svg]:w-8">
                        {!! $service->icon_svg !!}
                    </div>
                    
                    <!-- Title -->
                    <h3 class="relative mt-6 text-lg font-bold text-slate-800 transition-colors group-hover:text-primary">
                        {{ $service->name }}
                    </h3>
                    
                    <!-- Decorative Line -->
                    <div class="mx-auto mt-4 h-1 w-8 rounded-full bg-slate-100 transition-all duration-300 group-hover:w-16 group-hover:bg-accent-blue"></div>
                    
                    <!-- Accent Top Border -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary to-accent-blue transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100"></div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
