@extends('layouts.app')

@section('title', 'اتصل بنا')

@section('content')
<!-- Header Banner -->
<section class="relative bg-gradient-to-r from-primary to-primary-dark py-20 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-accent-blue/20 blur-3xl"></div>
    
    <div class="relative z-10 mx-auto max-w-7xl px-4 text-center lg:px-6">
        <h1 class="text-4xl font-extrabold sm:text-5xl leading-tight">اتصل بنا</h1>
        <p class="mt-4 text-lg text-white/90 max-w-2xl mx-auto">يسعدنا تواصلكم والإجابة على جميع استفساراتكم وحجوزاتكم على مدار الساعة</p>
    </div>
</section>

<!-- Content Area -->
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            
            <!-- Contact Card: Phone -->
            <div class="rounded-3xl border border-slate-100 bg-white p-8 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                </div>
                <h3 class="mt-6 text-lg font-bold text-slate-800">رقم الهاتف</h3>
                <p class="mt-2 text-sm text-slate-500">اتصل بنا للحصول على الدعم الفوري</p>
                <a href="tel:{{ $phone }}" class="mt-4 inline-block font-bold text-primary text-lg" dir="ltr">{{ $phone }}</a>
            </div>

            <!-- Contact Card: Email -->
            <div class="rounded-3xl border border-slate-100 bg-white p-8 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-accent-blue/10 text-accent-blue">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                </div>
                <h3 class="mt-6 text-lg font-bold text-slate-800">البريد الإلكتروني</h3>
                <p class="mt-2 text-sm text-slate-500">أرسل استفسارك عبر البريد في أي وقت</p>
                <a href="mailto:{{ $siteEmail }}" class="mt-4 inline-block font-bold text-accent-blue text-base break-all">{{ $siteEmail }}</a>
            </div>

            <!-- Contact Card: Hours -->
            <div class="rounded-3xl border border-slate-100 bg-white p-8 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-accent-red/10 text-accent-red">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="mt-6 text-lg font-bold text-slate-800">ساعات العمل</h3>
                <p class="mt-2 text-sm text-slate-500">مستعدون لخدمتكم طوال الأسبوع</p>
                <span class="mt-4 inline-block font-bold text-slate-700 text-sm">يومياً: من ٨:٠٠ ص حتى ١٠:٠٠ م</span>
            </div>

        </div>

        <div class="bg-white rounded-3xl border border-slate-100 p-8 md:p-12 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800 mb-8">فروعنا الجغرافية</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($branches as $branch)
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                        <h3 class="font-bold text-lg text-primary">{{ $branch->name }}</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $branch->address }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-700" dir="ltr">{{ $branch->phone }}</p>
                        
                        @if(!empty($branch->map_url))
                            <a href="{{ $branch->map_url }}" target="_blank" rel="noopener noreferrer" 
                               class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-primary hover:underline">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8m-9-1.5h12"/></svg>
                                <span>عرض على الخريطة</span>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
