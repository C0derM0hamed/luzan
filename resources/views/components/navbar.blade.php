<header class="sticky top-0 z-50 border-b border-slate-100 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300" x-data="{ open: false }">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-4 px-4 lg:px-8">
        <!-- Logo Area -->
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('home') }}" class="group flex items-center gap-3.5">
                <div class="rounded-2xl bg-white p-1.5 shadow-sm border border-slate-100 transition-transform group-hover:scale-105 duration-300">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ $clinicName }}" class="h-11 w-auto object-contain">
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-base font-extrabold text-slate-800 leading-tight group-hover:text-primary transition-colors duration-300">{{ $clinicName }}</span>
                    <span class="text-[10px] font-bold text-slate-450 tracking-wider mt-0.5">{{ $tagline }}</span>
                </div>
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden flex-1 items-center justify-center gap-7 md:flex">
            <a href="{{ route('home') }}" class="relative text-[15px] font-bold transition-all hover:text-primary duration-300 py-1.5 {{ request()->routeIs('home') ? 'text-primary after:absolute after:-bottom-[24px] after:left-0 after:right-0 after:h-[3px] after:rounded-full after:bg-primary' : 'text-slate-600' }}">الرئيسية</a>
            <a href="{{ route('services') }}" class="relative text-[15px] font-bold transition-all hover:text-primary duration-300 py-1.5 {{ request()->routeIs('services') ? 'text-primary after:absolute after:-bottom-[24px] after:left-0 after:right-0 after:h-[3px] after:rounded-full after:bg-primary' : 'text-slate-600' }}">الخدمات</a>
            <a href="{{ route('doctors') }}" class="relative text-[15px] font-bold transition-all hover:text-primary duration-300 py-1.5 {{ request()->routeIs('doctors') ? 'text-primary after:absolute after:-bottom-[24px] after:left-0 after:right-0 after:h-[3px] after:rounded-full after:bg-primary' : 'text-slate-600' }}">الأطباء</a>
            <a href="{{ route('book') }}" class="relative text-[15px] font-bold transition-all hover:text-primary duration-300 py-1.5 {{ request()->routeIs('book') ? 'text-primary after:absolute after:-bottom-[24px] after:left-0 after:right-0 after:h-[3px] after:rounded-full after:bg-primary' : 'text-slate-600' }}">حجز موعد</a>
            <a href="{{ route('branches') }}" class="relative text-[15px] font-bold transition-all hover:text-primary duration-300 py-1.5 {{ request()->routeIs('branches') ? 'text-primary after:absolute after:-bottom-[24px] after:left-0 after:right-0 after:h-[3px] after:rounded-full after:bg-primary' : 'text-slate-600' }}">الفروع</a>
            <a href="{{ route('about') }}" class="relative text-[15px] font-bold transition-all hover:text-primary duration-300 py-1.5 {{ request()->routeIs('about') ? 'text-primary after:absolute after:-bottom-[24px] after:left-0 after:right-0 after:h-[3px] after:rounded-full after:bg-primary' : 'text-slate-600' }}">من نحن</a>
            <a href="{{ route('contact') }}" class="relative text-[15px] font-bold transition-all hover:text-primary duration-300 py-1.5 {{ request()->routeIs('contact') ? 'text-primary after:absolute after:-bottom-[24px] after:left-0 after:right-0 after:h-[3px] after:rounded-full after:bg-primary' : 'text-slate-600' }}">اتصل بنا</a>
        </nav>

        <!-- CTA & Action Buttons -->
        <div class="flex items-center gap-3">
            @if(!empty($phone))
                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="hidden items-center gap-2.5 rounded-2xl bg-gradient-to-r from-primary to-primary-dark px-6 py-3 text-sm font-bold text-white shadow-md shadow-primary/20 transition-all hover:scale-103 hover:shadow-lg active:scale-95 sm:inline-flex">
                    <svg class="h-4.5 w-4.5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span dir="ltr">{{ $phone }}</span>
                </a>
            @endif
            <button type="button" class="rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-slate-600 transition-colors hover:bg-slate-100 hover:text-primary md:hidden" @click="open = !open" aria-label="القائمة">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="absolute left-0 right-0 border-b border-slate-100 bg-white/95 backdrop-blur-md shadow-lg md:hidden">
        <nav class="flex flex-col gap-1.5 px-6 py-4 text-[15px] font-bold text-slate-700">
            <a href="{{ route('home') }}" class="rounded-xl px-4 py-2.5 hover:bg-slate-50 hover:text-primary {{ request()->routeIs('home') ? 'bg-primary/5 text-primary' : '' }}" @click="open = false">الرئيسية</a>
            <a href="{{ route('services') }}" class="rounded-xl px-4 py-2.5 hover:bg-slate-50 hover:text-primary {{ request()->routeIs('services') ? 'bg-primary/5 text-primary' : '' }}" @click="open = false">الخدمات</a>
            <a href="{{ route('doctors') }}" class="rounded-xl px-4 py-2.5 hover:bg-slate-50 hover:text-primary {{ request()->routeIs('doctors') ? 'bg-primary/5 text-primary' : '' }}" @click="open = false">الأطباء</a>
            <a href="{{ route('book') }}" class="rounded-xl px-4 py-2.5 hover:bg-slate-50 hover:text-primary {{ request()->routeIs('book') ? 'bg-primary/5 text-primary' : '' }}" @click="open = false">حجز موعد</a>
            <a href="{{ route('branches') }}" class="rounded-xl px-4 py-2.5 hover:bg-slate-50 hover:text-primary {{ request()->routeIs('branches') ? 'bg-primary/5 text-primary' : '' }}" @click="open = false">الفروع</a>
            <a href="{{ route('about') }}" class="rounded-xl px-4 py-2.5 hover:bg-slate-50 hover:text-primary {{ request()->routeIs('about') ? 'bg-primary/5 text-primary' : '' }}" @click="open = false">من نحن</a>
            <a href="{{ route('contact') }}" class="rounded-xl px-4 py-2.5 hover:bg-slate-50 hover:text-primary {{ request()->routeIs('contact') ? 'bg-primary/5 text-primary' : '' }}" @click="open = false">اتصل بنا</a>
            @if(!empty($phone))
                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="mt-3 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary to-primary-dark py-3 text-center text-sm font-bold text-white shadow-md shadow-primary/15" dir="ltr">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>{{ $phone }}</span>
                </a>
            @endif
        </nav>
    </div>
</header>
