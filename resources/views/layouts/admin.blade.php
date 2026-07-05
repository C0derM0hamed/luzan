<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') — {{ $clinicName ?? config('app.name') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-50 text-[#334155] font-sans antialiased min-h-screen overflow-x-hidden" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        <aside
            class="fixed inset-y-0 right-0 z-40 w-64 bg-slate-900 text-slate-300 transform transition-transform duration-200 lg:translate-x-0 lg:static lg:flex-shrink-0 flex flex-col border-l border-slate-800 shadow-xl"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'"
        >
            <div class="flex h-16 items-center gap-3 border-b border-slate-850 px-6 bg-slate-950">
                <img src="{{ asset('images/logo.png') }}" alt="{{ $clinicName ?? '' }}" class="h-8 brightness-0 invert">
                <span class="text-sm font-bold text-white tracking-wide">{{ $clinicName ?? '' }}</span>
            </div>
            <nav class="flex-1 space-y-1.5 p-4 text-sm overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span>لوحة التحكم</span>
                </a>
                <a href="{{ route('admin.doctors.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.doctors.*') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>الأطباء</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.services.*') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z"/></svg>
                    <span>الخدمات</span>
                </a>
                <a href="{{ route('admin.appointments.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.appointments.*') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>المواعيد</span>
                </a>
                <a href="{{ route('admin.offers.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.offers.*') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                    <span>العروض</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.reports.*') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>تقارير المرضى</span>
                </a>
                <a href="{{ route('admin.branches.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.branches.*') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>الفروع</span>
                </a>
                <a href="{{ route('admin.ai-assistant.edit') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.ai-assistant.edit') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/></svg>
                    <span>المساعد الذكي</span>
                </a>
                <a href="{{ route('admin.ai-assistant.analytics') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.ai-assistant.analytics') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>إحصائيات AI</span>
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.profile.*') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>إعدادات الحساب</span>
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 transition-all hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.settings.*') ? 'bg-primary text-white font-semibold shadow-md shadow-primary/20' : '' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>إعدادات الموقع</span>
                </a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}" class="p-4 border-t border-slate-800 bg-slate-950/50">
                @csrf
                <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-300 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                    <svg class="h-4 w-4 shrink-0 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </aside>

        <div class="flex flex-1 flex-col lg:mr-0">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-border bg-white px-4 lg:px-8">
                <button type="button" class="lg:hidden rounded border border-border p-2" @click="sidebarOpen = !sidebarOpen" aria-label="القائمة">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-bold text-[#222]">@yield('page-title', 'لوحة التحكم')</h1>
                <a href="{{ route('home') }}" class="text-sm text-primary hover:text-primary-dark transition" target="_blank" rel="noopener">عرض الموقع</a>
            </header>

            <div class="flex-1 p-4 lg:p-8">
                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-primary/30 bg-primary/10 px-4 py-3 text-sm text-primary-dark">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc pr-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>
    @stack('scripts')
</body>
</html>
