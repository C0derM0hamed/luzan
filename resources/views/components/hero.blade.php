<section id="hero"
    class="relative flex min-h-[560px] lg:h-[85vh] w-full items-center justify-center bg-cover bg-[position:30%_top] lg:bg-top pt-36 pb-20 transition-all -mt-[96px]"
    style="background-image: url('{{ asset('images/heroimg.png') }}');">
    <!-- Premium Light-to-Transparent Gradient Overlay for RTL Text Contrast -->
    <div class="absolute inset-0 bg-gradient-to-r from-white/60 via-white/40 lg:from-transparent lg:via-slate-50/10 to-slate-50/50 lg:to-slate-50/50 z-0"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-white/30 via-transparent to-transparent z-0"></div>

    <div class="relative z-10 mx-auto w-full max-w-7xl px-4 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-16">
            <!-- Right Side: Title & Info (RTL) -->
            <div class="w-full lg:w-[60%] text-right space-y-6 lg:space-y-7">
                <!-- Stethoscope Category Badge -->
                <div class="inline-flex items-center gap-2 rounded-full border border-primary/30 bg-primary/10 lg:bg-primary/5 px-4 py-1.5 text-primary shadow-sm backdrop-blur-sm lg:backdrop-blur-none">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0015 0m-15 0a7.5 7.5 0 1115 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.822m11.488-8.204l1.15-.822M8.294 21.222l.63-.943m10.152-6.557l.63-.943M12 3v1.5m0 15V21m-7.077-7.077l1.06-1.06m12.034-12.034l1.06-1.06"/>
                    </svg>
                    <span class="text-[11px] font-black tracking-wider">رعايتك.. أولويتنا</span>
                </div>

                <div class="space-y-4 lg:space-y-5">
                    <h1 class="text-3xl font-black leading-tight text-[#0f172a] sm:text-5xl lg:text-[62px] tracking-tight drop-shadow-sm lg:drop-shadow-none">
                        مجمع لوزان
                        <br>
                        التخصصي الطبي
                    </h1>

                    <!-- Description with a vertical right border -->
                    <p class="text-slate-700 lg:text-slate-600 text-sm md:text-base leading-relaxed max-w-xl font-bold border-r-4 border-primary pr-4 lg:pr-4.5">
                        مجمع طبي متكامل يضم نخبة من الأطباء والاستشاريين وأحدث الأجهزة الطبية لخدمة صحتك وراحة بالك
                    </p>
                </div>

                <!-- CTA & Avatars Row -->
                <div class="space-y-5 pt-1">
                    <a href="/book"
                        class="inline-flex h-12 lg:h-13 items-center justify-center gap-2.5 rounded-2xl bg-primary px-8 text-sm font-black text-white shadow-lg shadow-primary/25 transition-all hover:bg-primary-dark hover:scale-102 active:scale-98">
                        <svg class="h-4.5 w-4.5 text-primary-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>احجز موعدك الآن</span>
                    </a>

                    <!-- Doctors Avatars Group & Verification Tag -->
                    <div class="flex items-center gap-3 mt-4">
                        <div class="flex -space-x-2 space-x-reverse">
                            <div class="h-7 w-7 rounded-full border-2 border-white bg-slate-200 overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&q=80&w=100" alt="" class="h-full w-full object-cover">
                            </div>
                            <div class="h-7 w-7 rounded-full border-2 border-white bg-slate-200 overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=100" alt="" class="h-full w-full object-cover">
                            </div>
                            <div class="h-7 w-7 rounded-full border-2 border-white bg-slate-200 overflow-hidden shadow-sm">
                                <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&q=80&w=100" alt="" class="h-full w-full object-cover">
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 bg-white/40 lg:bg-transparent px-2 py-0.5 rounded-full lg:px-0 lg:py-0 backdrop-blur-sm lg:backdrop-blur-none">
                            <span class="flex h-4.5 w-4.5 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="text-[10px] font-black text-slate-600 lg:text-slate-500">نعتني بصحتك كما تستحق</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Left Side (Empty to let the doctor photo shine through) -->
            <div class="hidden lg:block w-[40%]"></div>
        </div>
    </div>

    <!-- Overlapping bottom capsule card -->
    <!-- Responsive: Horizontal scroll on mobile to preserve single-row layout, Grid on desktop -->
    <div class="absolute -bottom-8 left-0 right-0 z-20 px-4">
        <div class="mx-auto max-w-5xl bg-white border border-slate-200/80 rounded-3xl lg:rounded-[32px] p-3 lg:p-5 shadow-xl shadow-slate-200/25 flex overflow-x-auto lg:grid lg:grid-cols-4 lg:divide-x lg:divide-x-reverse divide-slate-100 snap-x hide-scrollbar" style="-ms-overflow-style: none; scrollbar-width: none;">
            
            <!-- Column 1 (Rightmost in RTL): دعم مستمر -->
            <div class="flex shrink-0 w-[220px] lg:w-auto items-center gap-4 lg:gap-4.5 justify-start px-3 lg:px-4 py-2 lg:py-2.5 snap-start">
                <div class="flex h-10 w-10 lg:h-11 lg:w-11 shrink-0 items-center justify-center rounded-full bg-sky-50 text-sky-600">
                    <svg class="h-4.5 w-4.5 lg:h-5 lg:w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-[11px] lg:text-xs font-black text-slate-800">دعم مستمر</span>
                    <span class="text-[9px] lg:text-[10px] font-bold text-slate-400 mt-0.5">نحن هنا من أجلك</span>
                </div>
            </div>

            <!-- Column 2: أطباء متخصصون -->
            <div class="flex shrink-0 w-[220px] lg:w-auto items-center gap-4 lg:gap-4.5 justify-start px-3 lg:px-4 py-2 lg:py-2.5 snap-start">
                <div class="flex h-10 w-10 lg:h-11 lg:w-11 shrink-0 items-center justify-center rounded-full bg-teal-50 text-teal-600">
                    <svg class="h-4.5 w-4.5 lg:h-5 lg:w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-[11px] lg:text-xs font-black text-slate-800">أطباء متخصصون</span>
                    <span class="text-[9px] lg:text-[10px] font-bold text-slate-400 mt-0.5">خبرة وكفاءة عالية</span>
                </div>
            </div>

            <!-- Column 3: خدمات متكاملة -->
            <div class="flex shrink-0 w-[220px] lg:w-auto items-center gap-4 lg:gap-4.5 justify-start px-3 lg:px-4 py-2 lg:py-2.5 snap-start">
                <div class="flex h-10 w-10 lg:h-11 lg:w-11 shrink-0 items-center justify-center rounded-full bg-sky-50 text-sky-600">
                    <svg class="h-4.5 w-4.5 lg:h-5 lg:w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-[11px] lg:text-xs font-black text-slate-800">خدمات متكاملة</span>
                    <span class="text-[9px] lg:text-[10px] font-bold text-slate-400 mt-0.5">كل ما تحتاجه تحت سقف واحد</span>
                </div>
            </div>

            <!-- Column 4 (Leftmost in RTL): رعاية آمنة -->
            <div class="flex shrink-0 w-[220px] lg:w-auto items-center gap-4 lg:gap-4.5 justify-start px-3 lg:px-4 py-2 lg:py-2.5 snap-start">
                <div class="flex h-10 w-10 lg:h-11 lg:w-11 shrink-0 items-center justify-center rounded-full bg-teal-50 text-teal-600">
                    <svg class="h-4.5 w-4.5 lg:h-5 lg:w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-[11px] lg:text-xs font-black text-slate-800">رعاية آمنة</span>
                    <span class="text-[9px] lg:text-[10px] font-bold text-slate-400 mt-0.5">معايير جودة عالية</span>
                </div>
            </div>

        </div>
    </div>
</section>