<footer class="relative bg-slate-950 pt-24 text-slate-300 overflow-hidden border-t border-slate-900">
    <!-- Subtle Ambient Glow -->
    <div class="absolute -left-40 -top-40 h-80 w-80 rounded-full bg-primary/5 blur-[100px] pointer-events-none"></div>

    <div class="relative z-10 mx-auto grid max-w-7xl gap-10 px-4 pb-20 sm:grid-cols-2 lg:grid-cols-4 lg:px-8">

        <!-- Column 1: Brand & Socials -->
        <div class="flex flex-col items-center sm:items-start text-center sm:text-right space-y-6">
            <a href="{{ route('home') }}" class="inline-block">
                <img src="{{ asset('images/logo.png') }}" alt="{{ $clinicName }}"
                    class="h-14 w-auto brightness-0 invert drop-shadow-md">
            </a>
            <p class="text-xs text-slate-400 leading-relaxed max-w-xs">
                {{ $tagline ?: 'مجمع طبي متكامل يضم نخبة من الأطباء والاستشاريين لخدمة صحتك وراحة بالك.' }}
            </p>

            <div class="space-y-3">
                <span class="text-[10px] font-black text-primary uppercase tracking-wider block">قنوات التواصل</span>
                <div class="flex gap-2">
                    @foreach($socialLinks as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-800 bg-slate-900 text-slate-400 transition-all duration-300 hover:bg-white hover:text-slate-950 hover:border-white hover:-translate-y-0.5"
                            aria-label="{{ $social['name'] }}">
                            {!! $social['icon_svg'] !!}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="space-y-6">
            <h3 class="text-sm font-black text-white uppercase tracking-wider relative pb-3 border-b border-slate-900">
                روابط سريعة</h3>
            <ul class="space-y-3 text-xs">
                @foreach($footerQuickLinks as $link)
                    <li>
                        <a href="{{ $link['url'] }}"
                            class="group flex items-center gap-2 text-slate-400 transition-all hover:text-white">
                            <span
                                class="h-1 w-1 rounded-full bg-primary opacity-50 transition-all group-hover:w-2 group-hover:opacity-100"></span>
                            <span>{{ $link['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Column 3: Services -->
        <div class="space-y-6">
            <h3 class="text-sm font-black text-white uppercase tracking-wider relative pb-3 border-b border-slate-900">
                العيادات والخدمات</h3>
            <ul class="space-y-3 text-xs">
                @foreach($footerServices as $item)
                    <li>
                        <a href="{{ route('services') }}"
                            class="group flex items-center gap-2 text-slate-400 transition-all hover:text-white">
                            <span
                                class="h-1 w-1 rounded-full bg-primary opacity-50 transition-all group-hover:w-2 group-hover:opacity-100"></span>
                            <span>{{ $item->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Column 4: Contact Info -->
        <div class="space-y-6">
            <h3 class="text-sm font-black text-white uppercase tracking-wider relative pb-3 border-b border-slate-900">
                اتصل بنا</h3>
            <ul class="space-y-4 text-xs text-slate-400">
                <li class="flex items-start gap-3">
                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-900 border border-slate-800 text-primary">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <span class="leading-relaxed pt-1">الباحة - محافظة قلوة - طريق الملك فهد بجانب بنك الراجحي</span>
                </li>
                <li class="flex items-center gap-3">
                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-900 border border-slate-800 text-primary">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                    </div>
                    <a href="tel:{{ $phone }}" class="hover:text-white transition font-bold" dir="ltr">{{ $phone }}</a>
                </li>
                @if($siteEmail)
                    <li class="flex items-center gap-3">
                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-900 border border-slate-800 text-primary">
                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <a href="mailto:{{ $siteEmail }}"
                            class="hover:text-white transition break-all font-semibold">{{ $siteEmail }}</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Bottom Copyright -->
    <div class="relative z-10 bg-slate-950/60 py-6 border-t border-slate-900">
        <div
            class="mx-auto max-w-7xl px-4 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-[11px] text-slate-500 font-bold">
            <p class="text-center md:text-right">{{ $copyrightText }}</p>
            <div class="flex gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-white transition">سياسة الخصوصية</a>
                <span class="text-slate-800">|</span>
                <a href="{{ route('terms') }}" class="hover:text-white transition">شروط الاستخدام</a>
            </div>
        </div>
    </div>
</footer>