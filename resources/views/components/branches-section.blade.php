<section id="branches" class="py-20 bg-white border-t border-slate-100 overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">

        <!-- Section Header -->
        <div class="text-right space-y-2.5 mb-12 pb-6 border-b border-slate-100">
            <span
                class="text-[10px] font-black text-primary tracking-widest uppercase bg-primary/10 px-3.5 py-1.5 rounded-full inline-block">فروعنا
                الجغرافية</span>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight sm:text-4xl">
                {{ $branchesSectionTitle }}
            </h2>
            <p class="text-xs font-bold text-slate-400 max-w-xl">
                تفضلوا بزيارة فروع مجمع لوزان التخصصي الطبي المجهزة بأحدث التقنيات وأفضل الأطقم الطبية لخدمتكم ورعايتكم.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-6">
            @foreach($branches as $branch)
                <div
                    class="group relative overflow-hidden rounded-[28px] border border-slate-200/60 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-primary/20 hover:shadow-xl hover:shadow-primary/5 flex flex-col justify-between">
                    <div
                        class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-primary/5 blur-lg transition-all duration-500 group-hover:scale-150">
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-3.5">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary/10 text-primary border border-primary/10">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-800 leading-tight">{{ $branch->name }}</h3>
                        </div>

                        <div class="mt-8 space-y-4 text-sm text-slate-600">
                            <div class="flex items-start gap-3.5">
                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-100">
                                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </div>
                                <span
                                    class="leading-relaxed font-semibold pt-1 text-slate-700 text-xs">{{ $branch->address }}</span>
                            </div>
                            <div class="flex items-center gap-3.5">
                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-100">
                                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                                <span dir="ltr" class="font-extrabold text-slate-800 text-xs">{{ $branch->phone }}</span>
                            </div>
                            @if($branch->email)
                                <div class="flex items-center gap-3.5">
                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-400 border border-slate-100">
                                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-xs">{{ $branch->email }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($branch->map_url)
                        <div class="mt-8 pt-6 border-t border-slate-100 relative z-10 space-y-4">
                            <div class="flex justify-between items-center">
                                <a href="{{ $branch->map_url }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-6 py-2.5 text-xs font-black text-white transition-all hover:bg-primary hover:shadow-lg hover:shadow-primary/20 active:scale-97">
                                    <svg class="h-4 w-4 text-primary-light" fill="none" stroke="currentColor" stroke-width="2.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $branchesMapLabel }}</span>
                                </a>
                            </div>

                            <!-- Interactive Map Frame with Inner Shadow -->
                            <div
                                class="relative overflow-hidden rounded-[20px] border border-slate-200/85 bg-slate-50 h-56 w-full shadow-inner">
                                <iframe class="w-full h-full border-0"
                                    src="https://maps.google.com/maps?q={{ urlencode('مجمع لوزان التخصصي الطبي ' . $branch->name) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>