<footer class="relative bg-gradient-to-b from-[#0a4e51] to-[#052b2d] pt-20 text-white overflow-hidden border-t border-accent-blue/10">
    <!-- Decorative Ambient Glow -->
    <div class="absolute -left-32 -top-32 h-64 w-64 rounded-full bg-accent-blue/10 blur-[80px] pointer-events-none"></div>

    <div class="relative z-10 mx-auto grid max-w-7xl gap-10 px-4 pb-16 sm:grid-cols-2 lg:grid-cols-4 lg:px-6">
        
        <!-- Column 1: Brand & Socials -->
        <div class="flex flex-col items-center sm:items-start text-center sm:text-right">
            <a href="{{ route('home') }}" class="inline-block">
                <img src="{{ asset('images/logo.png') }}" alt="{{ $clinicName }}" class="h-16 w-auto brightness-0 invert drop-shadow-md">
            </a>
            <p class="mt-4 text-[15px] text-white/80 leading-relaxed max-w-xs">
                {{ $tagline ?: 'مجمع طبي متكامل يضم نخبة من الأطباء والاستشاريين لخدمة صحتك وراحة بالك.' }}
            </p>
            
            <div class="mt-6">
                <h4 class="text-sm font-bold text-accent-blue uppercase tracking-wider mb-3">تابعنا على</h4>
                <div class="flex gap-3">
                    @foreach($socialLinks as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" 
                           class="flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white transition-all duration-300 hover:bg-white hover:text-[#0a7075] hover:border-white hover:-translate-y-1 hover:shadow-lg" 
                           aria-label="{{ $social['name'] }}">
                            {!! $social['icon_svg'] !!}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div>
            <h3 class="relative mb-6 text-[17px] font-bold text-white pb-3 after:absolute after:bottom-0 after:right-0 after:h-[2px] after:w-8 after:bg-accent-blue">روابط سريعة</h3>
            <ul class="space-y-3.5 text-[15px]">
                @foreach($footerQuickLinks as $link)
                    <li>
                        <a href="{{ $link['url'] }}" class="group flex items-center gap-2 text-white/85 transition-all hover:text-accent-blue">
                            <span class="h-1.5 w-1.5 rounded-full bg-accent-blue opacity-50 transition-all group-hover:w-3 group-hover:opacity-100"></span>
                            <span>{{ $link['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Column 3: Services -->
        <div>
            <h3 class="relative mb-6 text-[17px] font-bold text-white pb-3 after:absolute after:bottom-0 after:right-0 after:h-[2px] after:w-8 after:bg-accent-blue">أهم الخدمات</h3>
            <ul class="space-y-3.5 text-[15px]">
                @foreach($footerServices as $item)
                    <li>
                        <a href="{{ route('services') }}" class="group flex items-center gap-2 text-white/85 transition-all hover:text-accent-blue">
                            <span class="h-1.5 w-1.5 rounded-full bg-accent-blue opacity-50 transition-all group-hover:w-3 group-hover:opacity-100"></span>
                            <span>{{ $item->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Column 4: Contact Info -->
        <div>
            <h3 class="relative mb-6 text-[17px] font-bold text-white pb-3 after:absolute after:bottom-0 after:right-0 after:h-[2px] after:w-8 after:bg-accent-blue">معلومات الاتصال</h3>
            <ul class="space-y-4 text-[15px] text-white/85">
                <li class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-accent-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    <span class="leading-relaxed">الباحة - محافظة قلوة - طريق الملك فهد</span>
                </li>
                <li class="flex items-center gap-3">
                    <svg class="h-5 w-5 shrink-0 text-accent-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    <a href="tel:{{ $phone }}" class="hover:text-accent-blue transition" dir="ltr">{{ $phone }}</a>
                </li>
                @if($siteEmail)
                    <li class="flex items-center gap-3">
                        <svg class="h-5 w-5 shrink-0 text-accent-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        <a href="mailto:{{ $siteEmail }}" class="hover:text-accent-blue transition break-all">{{ $siteEmail }}</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Bottom Copyright -->
    <div class="relative z-10 bg-[#052527] py-6 border-t border-white/5">
        <div class="mx-auto max-w-7xl px-4 lg:px-6 flex flex-col md:flex-row items-center justify-between gap-4 text-[14px] text-white/60">
            <p class="text-center md:text-right">{{ $copyrightText }}</p>
            <div class="flex gap-4">
                <a href="{{ route('about') }}" class="hover:text-white transition">سياسة الخصوصية</a>
                <span class="text-white/20">|</span>
                <a href="{{ route('contact') }}" class="hover:text-white transition">شروط الاستخدام</a>
            </div>
        </div>
    </div>
</footer>
