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
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen overflow-x-hidden" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        
        <!-- Premium Dark Sidebar Navigation -->
        <aside
            class="fixed inset-y-0 right-0 z-40 w-66 bg-slate-950 text-slate-400 transform transition-transform duration-300 lg:translate-x-0 lg:static lg:flex-shrink-0 flex flex-col shadow-2xl lg:shadow-none"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'"
        >
            <!-- Logo Header -->
            <div class="flex h-20 items-center gap-3 border-b border-slate-800/60 px-6 shrink-0 bg-slate-900/50">
                <!-- White backing for the logo to ensure visibility -->
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white p-1.5 shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ $clinicName ?? '' }}" class="h-full w-auto object-contain">
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-sm font-black text-white tracking-tight leading-none">{{ $clinicName ?? '' }}</span>
                    <span class="text-[9px] font-bold text-slate-500 mt-1 uppercase tracking-widest">لوحة الإدارة</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 space-y-1 p-4 text-xs overflow-y-auto scrollbar-hide">
                @php
                    $menuItems = [
                        ['route' => 'admin.dashboard', 'label' => 'لوحة التحكم', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>'],
                        ['route' => 'admin.doctors.index', 'label' => 'الأطباء', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'],
                        ['route' => 'admin.services.index', 'label' => 'الخدمات', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z"/></svg>'],
                        ['route' => 'admin.appointments.index', 'label' => 'المواعيد', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'],
                        ['route' => 'admin.offers.index', 'label' => 'العروض', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>'],
                        ['route' => 'admin.reports.index', 'label' => 'تقارير المرضى', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'],
                        ['route' => 'admin.branches.index', 'label' => 'الفروع', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'],
                        ['route' => 'admin.ai-assistant.edit', 'label' => 'المساعد الذكي', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/></svg>'],
                        ['route' => 'admin.ai-assistant.analytics', 'label' => 'إحصائيات AI', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'],
                        ['route' => 'admin.profile.edit', 'label' => 'إعدادات الحساب', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'],
                        ['route' => 'admin.settings.edit', 'label' => 'إعدادات الموقع', 'icon' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'],
                    ];
                @endphp
                @foreach($menuItems as $item)
                    @php
                        $isActive = request()->routeIs($item['route']) || (str_ends_with($item['route'], '.index') && request()->routeIs(explode('.index', $item['route'])[0] . '.*'));
                    @endphp
                    <a href="{{ route($item['route']) }}" class="group flex items-center gap-3.5 rounded-xl px-4 py-3 transition-all duration-300 {{ $isActive ? 'bg-white/10 text-white font-black shadow-inner border-r-2 border-primary' : 'hover:bg-white/5 hover:text-slate-200' }}">
                        <span class="shrink-0 {{ $isActive ? 'text-primary' : 'text-slate-500 group-hover:text-slate-400' }} transition-colors duration-300">
                            {!! $item['icon'] !!}
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- Logout Section -->
            <form method="POST" action="{{ route('admin.logout') }}" class="p-4 border-t border-slate-800/60 bg-slate-900/50 shrink-0">
                @csrf
                <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl border border-slate-800 bg-slate-800/50 px-4 py-2.5 text-xs font-black text-slate-400 hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all active:scale-97">
                    <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </aside>

        <!-- Main Body Wrapper -->
        <div class="flex flex-1 flex-col lg:mr-0 min-h-screen">
            <!-- Header Top bar -->
            <header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-slate-200/80 bg-white/90 backdrop-blur-xl px-6 lg:px-10 shrink-0 shadow-sm">
                <div class="flex items-center gap-4">
                    <button type="button" class="lg:hidden rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-slate-650 hover:bg-slate-100 active:scale-95" @click="sidebarOpen = !sidebarOpen" aria-label="القائمة">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight">@yield('page-title', 'لوحة التحكم')</h1>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-5 py-2.5 text-xs font-black text-slate-700 shadow-sm transition-all hover:bg-white hover:border-slate-300 hover:shadow-md active:scale-97" target="_blank" rel="noopener">
                    <svg class="h-3.5 w-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    <span>عرض الموقع</span>
                </a>
            </header>

            <!-- Page Main Content -->
            <div class="flex-1 p-6 lg:p-10 max-w-7xl w-full mx-auto space-y-6">
                <!-- Notifications & Feedback -->
                @if (session('success'))
                    <div class="flex items-center gap-3 rounded-2xl bg-emerald-50/80 p-4 border border-emerald-100 text-xs font-semibold text-emerald-800 shadow-sm">
                        <svg class="h-5 w-5 shrink-0 text-emerald-600 animate-bounce" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="flex items-center gap-3 rounded-2xl bg-rose-50/80 p-4 border border-rose-100 text-xs font-semibold text-rose-800 shadow-sm">
                        <svg class="h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="rounded-2xl bg-rose-50/80 p-5 border border-rose-100 text-xs text-rose-800 shadow-sm">
                        <div class="flex items-center gap-3 mb-3 font-black text-rose-900">
                            <svg class="h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                            <span>يرجى مراجعة الأخطاء التالية:</span>
                        </div>
                        <ul class="list-disc pr-8 space-y-1.5 font-semibold">
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
    <!-- Sidebar mobile overlay -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/60 backdrop-blur-sm lg:hidden" x-transition.opacity></div>
    @stack('scripts')
</body>
</html>
