<section id="doctors" class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div class="text-right">
                <span class="text-sm font-bold text-accent-blue tracking-wider uppercase">فريقنا الطبي</span>
                <h2 class="text-3xl font-extrabold text-slate-800 mt-1 leading-tight sm:text-4xl">
                    {{ $doctorsSectionTitle }}
                </h2>
                <div class="mt-3 h-1.5 w-16 rounded-full bg-gradient-to-r from-accent-red to-red-500"></div>
            </div>
            
            <!-- Custom Navigation Buttons -->
            <div class="mt-6 md:mt-0 flex gap-3">
                <button onclick="document.getElementById('doctors-slider').scrollBy({ left: 320, behavior: 'smooth' })"
                    class="flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-all hover:bg-primary hover:text-white hover:border-primary hover:shadow-md active:scale-95" aria-label="السابق">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button onclick="document.getElementById('doctors-slider').scrollBy({ left: -320, behavior: 'smooth' })"
                    class="flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-all hover:bg-primary hover:text-white hover:border-primary hover:shadow-md active:scale-95" aria-label="التالي">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Slider Container -->
        <div id="doctors-slider" class="flex gap-6 overflow-x-auto pb-6 scrollbar-none snap-x snap-mandatory scroll-smooth" style="-ms-overflow-style: none; scrollbar-width: none;">
            @foreach($doctors as $doctor)
                <div class="snap-start shrink-0 w-[260px] sm:w-[280px] md:w-[300px]">
                    @include('components.doctor-card', ['doctor' => $doctor, 'bookButtonLabel' => $bookButtonLabel])
                </div>
            @endforeach
        </div>

        @if(!empty($doctorsShowAllUrl))
            <div class="mt-12 text-center">
                <a href="{{ $doctorsShowAllUrl }}" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-primary to-primary-dark px-8 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:scale-105 hover:shadow-lg active:scale-95">
                    <span>{{ $doctorsShowAllLabel }}</span>
                    <svg class="h-4 w-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>
