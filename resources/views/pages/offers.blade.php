@extends('layouts.app')

@section('title', 'العروض الخاصة')

@section('content')
<!-- Header Banner -->
<section class="relative bg-gradient-to-r from-primary to-primary-dark py-20 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-accent-blue/20 blur-3xl"></div>
    
    <div class="relative z-10 mx-auto max-w-7xl px-4 text-center lg:px-6">
        <h1 class="text-4xl font-extrabold sm:text-5xl leading-tight">العروض الخاصة</h1>
        <p class="mt-4 text-lg text-white/90 max-w-2xl mx-auto">استفد من أحدث العروض والخصومات على خدماتنا الطبية</p>
    </div>
</section>

<!-- Content Area -->
<section class="bg-slate-50 py-20 min-h-[50vh]">
    <div class="mx-auto max-w-7xl px-4 lg:px-6">
        @if($offers->isEmpty())
            <div class="text-center bg-white rounded-3xl border border-slate-100 p-12 shadow-sm">
                <svg class="mx-auto h-16 w-16 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
                <h3 class="text-xl font-bold text-slate-800">لا توجد عروض حالياً</h3>
                <p class="mt-2 text-slate-500">تابعنا للحصول على أحدث العروض قريباً.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($offers as $offer)
                    <div class="group flex flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        @if($offer->image_url)
                            <div class="aspect-video w-full overflow-hidden">
                                <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                        @else
                            <div class="aspect-video w-full bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center">
                                <svg class="h-16 w-16 text-primary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            </div>
                        @endif
                        
                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="rounded-full bg-red-50 text-red-600 px-3 py-1 text-xs font-bold border border-red-100">عرض خاص</span>
                                <span class="text-xs font-semibold text-slate-500">حتى {{ $offer->end_date->format('Y/m/d') }}</span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $offer->title }}</h3>
                            <p class="text-sm text-slate-600 leading-relaxed mb-6 flex-1">{{ $offer->description }}</p>
                            
                            <a href="{{ route('book') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-50 text-primary px-4 py-3 text-sm font-bold transition-colors hover:bg-primary hover:text-white border border-slate-100 hover:border-primary">
                                احجز الآن للاستفادة من العرض
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
