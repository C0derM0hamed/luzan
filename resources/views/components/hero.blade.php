<section id="hero"
    class="relative flex min-h-[600px] w-full items-center justify-center overflow-hidden bg-cover bg-center py-20 md:min-h-[700px]"
    style="background-image: url('{{ asset('images/hero.png') }}');">
    <!-- Premium Gradient Overlay -->
    <div
        class="absolute inset-0 bg-gradient-to-l from-[#075a5e]/98 via-[#0a7075]/85 to-[#00b4d8]/25 mix-blend-multiply">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#053e41]/80 via-transparent to-transparent"></div>

    <!-- Floating Decorative Elements -->
    <div class="absolute -left-20 top-20 h-80 w-80 animate-pulse rounded-full bg-accent-blue/25 blur-[100px]"></div>
    <div class="absolute -right-20 bottom-20 h-80 w-80 animate-pulse rounded-full bg-[#00b4d8]/20 blur-[100px]"
        style="animation-delay: 2s;"></div>

    <div class="relative z-10 mx-auto w-full max-w-7xl px-4 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
            <!-- Left Side: Headline and Info -->
            <div class="w-full lg:w-[55%] text-right">
                <!-- Clinic Branding Badge -->
                <div
                    class="mb-8 inline-flex items-center gap-3.5 rounded-2xl border border-white/20 bg-white/10 p-2.5 pl-6 backdrop-blur-md shadow-lg">
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white p-1.5 shadow-md">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ $clinicName }}"
                            class="h-full w-auto object-contain">
                    </div>
                    <div class="flex flex-col text-right">
                        <span
                            class="text-[11px] font-extrabold uppercase tracking-wider text-[#00b4d8]">{{ $tagline }}</span>
                        <span class="text-xs font-bold text-white/80">مجمع لوزان التخصصي الطبي</span>
                    </div>
                </div>

                <h1 class="text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-[56px] drop-shadow-xl font-sans"
                    style="text-shadow: 0 4px 12px rgba(0,0,0,0.35);">
                    {!! nl2br(e($heroHeadline)) !!}
                </h1>

                <p class="mt-6 text-base text-white/90 leading-relaxed drop-shadow-sm max-w-xl sm:text-lg">
                    {{ $heroSubtext }}
                </p>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="/book"
                        class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-primary px-8 text-sm font-bold text-white shadow-lg shadow-primary/20 transition-all hover:bg-primary-dark hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>احجز موعدك الآن</span>
                    </a>
                    <a href="https://wa.me/966177221892" target="_blank" rel="noopener noreferrer"
                        class="inline-flex h-12 items-center justify-center gap-2.5 rounded-xl bg-emerald-500 px-8 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition-all hover:bg-emerald-650 hover:shadow-emerald-500/30 hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.458 5.704 1.459h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span>تواصل معنا</span>
                    </a>
                </div>

                <!-- Features Badges Grid -->
                <div class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-white/10 pt-8">
                    @foreach($heroBadges as $badge)
                        <div class="flex items-center gap-3.5 text-right">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 text-white border border-white/10 backdrop-blur-md [&_svg]:h-5 [&_svg]:w-5">
                                {!! $badge['icon_svg'] !!}
                            </div>
                            <span class="text-sm font-bold text-white/95 drop-shadow-sm">{{ $badge['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Side: Premium Schedule & Highlights Widgets -->
            <div class="hidden lg:flex flex-col gap-5 w-full lg:w-[40%]">
                <!-- Highlight Card 1: Immediate Booking -->
                <div
                    class="group rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg shadow-2xl transition duration-300 hover:bg-white/10 hover:border-white/20">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#00b4d8]/20 text-[#00b4d8] transition-transform duration-300 group-hover:scale-110">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-right">
                            <h4 class="text-[15px] font-bold text-white">حجز المواعيد الإلكتروني</h4>
                            <p class="text-xs text-white/70 mt-1.5 leading-relaxed">احجز موعدك فوراً مع طبيبك المفضل وفي
                                العيادة المناسبة لك بكل سهولة ويسر.</p>
                        </div>
                    </div>
                </div>

                <!-- Highlight Card 2: Branches -->
                <div
                    class="group rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg shadow-2xl transition duration-300 hover:bg-white/10 hover:border-white/20">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-500/20 text-emerald-400 transition-transform duration-300 group-hover:scale-110">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="text-right">
                            <h4 class="text-[15px] font-bold text-white">الفروع والتغطية الجغرافية</h4>
                            <p class="text-xs text-white/70 mt-1.5 leading-relaxed">نخدمكم في فرع قلوة وفرع نمرة، مع
                                عيادات مجهزة بأحدث التقنيات وأفضل الكوادر الطبية.</p>
                        </div>
                    </div>
                </div>

                <!-- Highlight Card 3: Quality care -->
                <div
                    class="group rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg shadow-2xl transition duration-300 hover:bg-white/10 hover:border-white/20">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-500/20 text-amber-400 transition-transform duration-300 group-hover:scale-110">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="text-right">
                            <h4 class="text-[15px] font-bold text-white">رعاية صحية آمنة ومتكاملة</h4>
                            <p class="text-xs text-white/70 mt-1.5 leading-relaxed">نطبق أعلى المعايير الصحية العالمية
                                لضمان سلامتك وسلامة عائلتك طوال فترة العلاج.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>