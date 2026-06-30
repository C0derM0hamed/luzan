@extends('layouts.app')

@section('title', 'تقاريري الطبية')

@section('content')
<section class="bg-slate-50 py-12 min-h-[70vh]">
    <div class="mx-auto max-w-5xl px-4 lg:px-6">
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">تقاريري الطبية</h1>
                <p class="text-slate-500 mt-1 text-sm">مرحباً بك، <span dir="ltr" class="font-semibold">{{ $email }}</span></p>
            </div>
            <a href="{{ route('reports.login') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-red-600 hover:border-red-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>تسجيل الخروج</span>
            </a>
        </div>

        @if($reports->isEmpty())
            <div class="text-center bg-white rounded-3xl border border-slate-100 p-16 shadow-sm">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-slate-400 mb-6">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">لا توجد تقارير</h3>
                <p class="mt-2 text-slate-500 max-w-md mx-auto">لم يتم رفع أي تقارير طبية لحسابك بعد. عند توفر تقارير جديدة ستظهر هنا مباشرة.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($reports as $report)
                    <div class="group relative overflow-hidden rounded-3xl border border-slate-100 bg-white p-6 shadow-sm transition-all hover:shadow-lg hover:border-primary/30 flex flex-col">
                        <div class="absolute -right-12 -top-12 h-24 w-24 rounded-full bg-primary/5 transition-transform duration-500 group-hover:scale-150"></div>
                        
                        <div class="relative z-10 flex items-start justify-between mb-4">
                            <div class="rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 p-3 text-primary group-hover:from-primary group-hover:to-primary-dark group-hover:text-white transition-colors">
                                @if($report->file_type === 'pdf')
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                @else
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @endif
                            </div>
                            <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider border border-slate-100">{{ $report->file_type }}</span>
                        </div>
                        
                        <h3 class="relative z-10 text-lg font-bold text-slate-800 mb-1 group-hover:text-primary transition-colors">{{ $report->title }}</h3>
                        <p class="relative z-10 text-xs font-semibold text-slate-500 mb-4 flex items-center gap-1.5">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $report->created_at->format('Y-m-d') }}
                        </p>
                        
                        @if($report->notes)
                            <p class="relative z-10 text-sm text-slate-600 line-clamp-2 mb-6 flex-1">{{ $report->notes }}</p>
                        @else
                            <div class="flex-1 mb-6"></div>
                        @endif
                        
                        <a href="{{ route('reports.download', $report) }}" target="_blank" class="mt-auto relative z-10 flex w-full items-center justify-center gap-2 rounded-xl bg-slate-50 py-2.5 text-sm font-bold text-primary transition-all hover:bg-primary hover:text-white border border-slate-100 hover:border-primary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>تحميل وعرض</span>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
