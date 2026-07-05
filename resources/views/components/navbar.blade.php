<div class="sticky top-0 z-50 w-full px-4 pt-4 pb-2 transition-all duration-300" 
     x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 10)">
     
    <div class="mx-auto flex h-18 max-w-7xl items-center justify-between gap-4 px-6 rounded-2xl border transition-all duration-500"
         :class="scrolled || open ? 'border-slate-200/80 bg-white/90 backdrop-blur-xl shadow-xl shadow-slate-100/40' : 'border-slate-200/50 bg-white/70 backdrop-blur-lg shadow-sm shadow-slate-100/10'">
        
        <!-- Logo & Clinic Identity -->
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <!-- Large Logo Wrapper -->
                <div class="flex h-11 w-11 shrink-0 items-center justify-center p-0.5 transition-all duration-300 group-hover:scale-105">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ $clinicName }}" class="h-full w-auto object-contain">
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-sm font-black text-slate-900 tracking-tight leading-tight transition-colors duration-300 group-hover:text-primary">{{ $clinicName }}</span>
                    <span class="text-[10px] font-bold text-slate-400 mt-1">{{ $tagline }}</span>
                </div>
            </a>
        </div>

        <!-- Desktop Navigation: Premium Curved Link Pills -->
        <nav class="hidden flex-1 items-center justify-center gap-1 xl:gap-2 md:flex">
            @php
                $links = [
                    ['route' => 'home', 'label' => 'الرئيسية'],
                    ['route' => 'services', 'label' => 'الخدمات'],
                    ['route' => 'doctors', 'label' => 'الأطباء'],
                    ['route' => 'offers', 'label' => 'العروض'],
                    ['route' => 'reports.login', 'label' => 'التقارير'],
                    ['route' => 'book', 'label' => 'حجز موعد'],
                    ['route' => 'branches', 'label' => 'الفروع'],
                    ['route' => 'about', 'label' => 'من نحن'],
                    ['route' => 'contact', 'label' => 'اتصل بنا'],
                ];
            @endphp
            @foreach($links as $link)
                @php
                    $isActive = request()->routeIs($link['route']) || ($link['route'] === 'reports.login' && request()->routeIs('reports.*'));
                @endphp
                <a href="{{ route($link['route']) }}" 
                   class="rounded-xl px-4 py-2 text-xs font-black transition-all duration-300 {{ $isActive ? 'bg-primary/10 text-primary shadow-sm' : 'text-slate-650 hover:bg-slate-50 hover:text-slate-900' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <!-- CTA & Mobile Trigger -->
        <div class="flex items-center gap-4">
            @if(!empty($phone))
                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" 
                   class="hidden items-center gap-2 rounded-2xl bg-slate-900 px-5.5 py-3 text-xs font-black text-white shadow-lg shadow-slate-900/10 transition-all duration-300 hover:bg-primary hover:shadow-primary/20 hover:scale-102 active:scale-98 sm:inline-flex"
                   dir="ltr">
                    <svg class="h-3.5 w-3.5 text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>{{ $phone }}</span>
                </a>
            @endif
            <button type="button" 
                    class="rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-slate-650 transition-all hover:bg-slate-100 hover:text-primary active:scale-95 md:hidden" 
                    @click="open = !open" 
                    aria-label="القائمة">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer slide down -->
    <div x-show="open" 
         x-cloak 
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0 -translate-y-4" 
         x-transition:enter-end="opacity-100 translate-y-0" 
         x-transition:leave="transition ease-in duration-250" 
         x-transition:leave-start="opacity-100 translate-y-0" 
         x-transition:leave-end="opacity-0 -translate-y-4" 
         class="absolute left-4 right-4 top-24 border border-slate-200/80 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl md:hidden z-40">
        <nav class="flex flex-col gap-1 p-4 text-xs font-black text-slate-700">
            @foreach($links as $link)
                @php
                    $isActive = request()->routeIs($link['route']) || ($link['route'] === 'reports.login' && request()->routeIs('reports.*'));
                @endphp
                <a href="{{ route($link['route']) }}" 
                   class="rounded-xl px-4 py-3 hover:bg-slate-50 hover:text-slate-950 transition-all {{ $isActive ? 'bg-primary/10 text-primary' : '' }}" 
                   @click="open = false">
                    {{ $link['label'] }}
                </a>
            @endforeach
            @if(!empty($phone))
                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" 
                   class="mt-2 inline-flex items-center justify-center gap-2 rounded-xl bg-slate-950 py-3 text-center text-xs font-black text-white shadow-lg shadow-slate-900/10 hover:bg-primary transition-all" 
                   dir="ltr">
                    <svg class="h-3.5 w-3.5 text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>{{ $phone }}</span>
                </a>
            @endif
        </nav>
    </div>
</div>
