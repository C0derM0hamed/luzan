@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .swiper-pagination-bullet-custom {
            width: 8px;
            height: 8px;
            display: inline-block;
            border-radius: 9999px;
            background-color: #e2e8f0;
            transition: all 0.3s ease;
            margin: 0 4px;
            cursor: pointer;
        }
        .swiper-pagination-bullet-custom-active {
            width: 32px;
            background-color: var(--color-primary, #0a7075);
        }
    </style>
@endpush

<section class="bg-slate-50 py-20 overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 lg:px-6">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div class="text-right">
                <span class="text-sm font-bold text-accent-blue tracking-wider uppercase">تخصصاتنا الطبية</span>
                <h2 class="text-3xl font-extrabold text-slate-800 mt-1 leading-tight sm:text-4xl">
                    {{ $servicesSectionTitle }}
                </h2>
                <div class="mt-3 h-1.5 w-16 rounded-full bg-gradient-to-r from-accent-red to-red-500"></div>
            </div>
            
            <!-- Custom Navigation Buttons -->
            <div class="mt-6 md:mt-0 flex gap-3">
                <button class="swiper-button-prev-custom flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-all hover:bg-primary hover:text-white hover:border-primary hover:shadow-md active:scale-95" aria-label="السابق">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button class="swiper-button-next-custom flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-all hover:bg-primary hover:text-white hover:border-primary hover:shadow-md active:scale-95" aria-label="التالي">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Swiper Container -->
        <div class="swiper services-swiper py-4 px-2">
            <div class="swiper-wrapper">
                @foreach($services as $service)
                    <div class="swiper-slide transition-all duration-300">
                        <div class="group relative overflow-hidden rounded-3xl border border-slate-100 bg-white p-8 text-center shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-primary/20 hover:shadow-xl">
                            <!-- Background subtle hover shape -->
                            <div class="absolute -right-16 -top-16 h-32 w-32 rounded-full bg-primary/5 transition-all duration-500 group-hover:scale-150"></div>
                            
                            <!-- Icon wrapper -->
                            <div class="relative mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 text-primary transition-all duration-500 group-hover:scale-110 group-hover:from-primary group-hover:to-primary-dark group-hover:text-white group-hover:shadow-lg [&_svg]:h-10 [&_svg]:w-10">
                                {!! $service->icon_svg !!}
                            </div>
                            
                            <!-- Title -->
                            <h3 class="relative mt-6 text-lg font-bold text-slate-800 transition-colors group-hover:text-primary">
                                {{ $service->name }}
                            </h3>
                            
                            @if($service->description)
                                <p class="mt-2 text-sm text-slate-500 line-clamp-2 leading-relaxed">{{ $service->description }}</p>
                            @endif
                            
                            @if($service->price)
                                <div class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-slate-50 px-4 py-1.5 text-sm font-bold text-slate-700">
                                    <span class="text-primary">{{ number_format($service->price, 2) }}</span>
                                    <span class="text-xs text-slate-500">ر.س</span>
                                </div>
                            @endif
                            
                            <!-- Decorative Line -->
                            <div class="mx-auto mt-4 h-1 w-8 rounded-full bg-slate-100 transition-all duration-300 group-hover:w-16 group-hover:bg-accent-blue"></div>
                            
                            <!-- Accent Top Border -->
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary to-accent-blue transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if(!empty($servicesShowAllUrl))
            <div class="mt-12 text-center">
                <a href="{{ $servicesShowAllUrl }}"
                    class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-primary to-primary-dark px-8 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:scale-105 hover:shadow-lg active:scale-95">
                    <span>{{ $servicesShowAllLabel }}</span>
                    <svg class="h-4 w-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
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
                    delay: 3500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 4,
                    }
                }
            });
        });
    </script>
@endpush