@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .swiper-pagination-bullet-custom {
            width: 6px;
            height: 6px;
            display: inline-block;
            border-radius: 9999px;
            background-color: #e2e8f0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            margin: 0 4px;
            cursor: pointer;
        }
        .swiper-pagination-bullet-custom-active {
            width: 20px;
            background-color: var(--color-primary, #00a99d);
        }
    </style>
@endpush

<section class="bg-white pt-24 pb-20 border-t border-slate-100 overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 pb-6 border-b border-slate-100">
            <div class="text-right space-y-2.5">
                <span class="text-[10px] font-black text-primary tracking-widest uppercase bg-primary/10 px-3.5 py-1.5 rounded-full inline-block">تخصصات المركز</span>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight sm:text-4xl">
                    {{ $servicesSectionTitle }}
                </h2>
                <p class="text-xs font-bold text-slate-400 max-w-xl">
                    نقدم باقة متكاملة من الخدمات الطبية التخصصية بأعلى معايير الجودة العالمية ورعاية فائقة لجميع المرضى.
                </p>
            </div>
            
            <!-- Custom Circular Navigation Buttons -->
            <div class="mt-6 md:mt-0 flex gap-2 shrink-0">
                <button class="swiper-button-prev-custom flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 transition-all hover:bg-slate-900 hover:text-white hover:border-slate-900 active:scale-95 shadow-sm" aria-label="السابق">
                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button class="swiper-button-next-custom flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 transition-all hover:bg-slate-900 hover:text-white hover:border-slate-900 active:scale-95 shadow-sm" aria-label="التالي">
                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Swiper Container -->
        <div class="swiper services-swiper py-6 px-2 overflow-visible">
            <div class="swiper-wrapper">
                @foreach($services as $service)
                    <div class="swiper-slide">
                        <div class="group relative overflow-hidden rounded-3xl border border-slate-200/60 bg-white p-7 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-primary/30 hover:shadow-xl hover:shadow-primary/5 flex flex-col justify-between h-[300px]">
                            <!-- Gradient background glow on hover -->
                            <div class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-primary/5 blur-lg transition-all duration-500 group-hover:scale-150"></div>
                            
                            <div>
                                <!-- Top Row: Icon container & Promo badge -->
                                <div class="flex items-start justify-between">
                                    <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50 text-primary border border-slate-100 transition-all duration-500 group-hover:scale-105 group-hover:bg-primary group-hover:text-white group-hover:shadow-lg group-hover:shadow-primary/20 [&_svg]:h-6.5 [&_svg]:w-6.5">
                                        {!! $service->icon_svg !!}
                                    </div>
                                    @if(!$service->price)
                                        <span class="text-[9px] font-black text-primary bg-primary/10 px-2.5 py-1 rounded-lg">عرض خاص</span>
                                    @endif
                                </div>
                                
                                <!-- Title -->
                                <h3 class="relative mt-5 text-base font-black text-slate-800 transition-colors duration-300 group-hover:text-primary leading-tight">
                                    {{ $service->name }}
                                </h3>
                                
                                <!-- Description -->
                                <p class="mt-2.5 text-xs text-slate-400 font-semibold leading-relaxed line-clamp-3">
                                    {{ $service->description ?: 'رعاية طبية تخصصية متكاملة لضمان صحتك بأفضل الأجهزة والتقنيات الحديثة.' }}
                                </p>
                            </div>
                            
                            <!-- Bottom Row: Price & Details Link -->
                            <div class="pt-4 border-t border-slate-100/80 flex items-center justify-between">
                                @if($service->price)
                                    <div class="inline-flex items-end gap-0.5">
                                        <span class="text-base font-black text-slate-900 leading-none">{{ number_format($service->price, 0) }}</span>
                                        <span class="text-[9px] font-bold text-slate-400">ر.س</span>
                                    </div>
                                @else
                                    <span class="text-[10px] font-black text-slate-400">أسعار تنافسية</span>
                                @endif
                                
                                <span class="text-[11px] font-black text-slate-500 group-hover:text-primary transition-colors duration-300 inline-flex items-center gap-1.5">
                                    <span>تفاصيل</span>
                                    <svg class="h-3.5 w-3.5 transform rotate-180 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Custom Swiper Pagination -->
            <div class="swiper-pagination-custom flex justify-center mt-10"></div>
        </div>

        @if(!empty($servicesShowAllUrl))
            <div class="mt-8 text-center">
                <a href="{{ $servicesShowAllUrl }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-8 py-3.5 text-xs font-black text-white shadow-xl shadow-slate-950/10 transition hover:bg-primary hover:shadow-primary/20 hover:scale-102 active:scale-98">
                    <span>{{ $servicesShowAllLabel }}</span>
                    <svg class="h-4 w-4 transform rotate-180 text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.services-swiper', {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 24,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
                pagination: {
                    el: '.swiper-pagination-custom',
                    clickable: true,
                    bulletClass: 'swiper-pagination-bullet-custom',
                    bulletActiveClass: 'swiper-pagination-bullet-custom-active',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 24,
                    }
                }
            });
        });
    </script>
@endpush