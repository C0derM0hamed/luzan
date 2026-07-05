<section id="doctors" class="py-20 bg-slate-50/40 border-t border-slate-100 overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 pb-6 border-b border-slate-200/60">
            <div class="text-right space-y-2.5">
                <span class="text-[10px] font-black text-primary tracking-widest uppercase bg-primary/10 px-3.5 py-1.5 rounded-full inline-block">أطباؤنا الاستشاريون</span>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight sm:text-4xl">
                    {{ $doctorsSectionTitle }}
                </h2>
                <p class="text-xs font-bold text-slate-400 max-w-xl">
                    نخبة من الاستشاريين والأخصائيين ذوي الخبرة الكبيرة والكفاءة الطبية العالية لتقديم أفضل سبل الرعاية والعلاج.
                </p>
            </div>
            
            <!-- Custom Circular Navigation Buttons -->
            <div class="mt-6 md:mt-0 flex gap-2 shrink-0">
                <button onclick="document.getElementById('doctors-slider').scrollBy({ left: 320, behavior: 'smooth' })"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-250 bg-white text-slate-500 shadow-sm transition-all hover:bg-slate-900 hover:text-white hover:border-slate-900 active:scale-95" aria-label="السابق">
                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button onclick="document.getElementById('doctors-slider').scrollBy({ left: -320, behavior: 'smooth' })"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-250 bg-white text-slate-500 shadow-sm transition-all hover:bg-slate-900 hover:text-white hover:border-slate-900 active:scale-95" aria-label="التالي">
                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Slider Container -->
        <div id="doctors-slider" class="flex gap-6 overflow-x-auto pb-6 scrollbar-hide snap-x snap-mandatory scroll-smooth" style="-ms-overflow-style: none; scrollbar-width: none;">
            @foreach($doctors as $doctor)
                <div class="snap-start shrink-0 w-[270px] sm:w-[280px] md:w-[290px] py-1">
                    @include('components.doctor-card', ['doctor' => $doctor, 'bookButtonLabel' => $bookButtonLabel])
                </div>
            @endforeach
        </div>

        @if(!empty($doctorsShowAllUrl))
            <div class="mt-8 text-center">
                <a href="{{ $doctorsShowAllUrl }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-8 py-3.5 text-xs font-black text-white shadow-xl shadow-slate-950/10 transition-all hover:bg-primary hover:shadow-primary/20 hover:scale-102 active:scale-98">
                    <span>{{ $doctorsShowAllLabel }}</span>
                    <svg class="h-4 w-4 transform rotate-180 text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>
