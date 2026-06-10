<div id="branches">
    <div class="text-right mb-10">
        <h2 class="text-3xl font-extrabold text-slate-800 leading-tight sm:text-4xl">
            {{ $branchesSectionTitle }}
        </h2>
        <div class="mt-3 h-1.5 w-16 rounded-full bg-gradient-to-r from-accent-red to-red-500"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
        @foreach($branches as $branch)
            <div class="group relative overflow-hidden rounded-3xl border border-slate-100 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-primary/10">
                <div class="absolute -right-16 -top-16 h-32 w-32 rounded-full bg-primary/5 transition-all duration-500 group-hover:scale-150"></div>
                
                <h3 class="text-2xl font-bold text-primary relative z-10">{{ $branch->name }}</h3>
                
                <div class="mt-5 space-y-3.5 text-[15px] text-slate-600 relative z-10">
                    <p class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <span class="leading-relaxed">{{ $branch->address }}</span>
                    </p>
                    <p class="flex items-center gap-3">
                        <svg class="h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        <span dir="ltr" class="font-semibold">{{ $branch->phone }}</span>
                    </p>
                    @if($branch->email)
                        <p class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <span>{{ $branch->email }}</span>
                        </p>
                    @endif
                    @if($branch->map_url)
                        <p class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            <a href="{{ $branch->map_url }}" target="_blank" rel="noopener noreferrer" class="text-primary font-bold hover:underline transition-all">موقع الفرع على الخريطة (GPS)</a>
                        </p>
                    @endif
                </div>

                @if($branch->map_url)
                    <div class="mt-6 pt-6 border-t border-slate-100 relative z-10 flex flex-col gap-4">
                        <div class="flex justify-between items-center">
                            <a href="{{ $branch->map_url }}" target="_blank" rel="noopener noreferrer" 
                               class="inline-flex items-center gap-2 rounded-full border border-primary/20 px-6 py-2.5 text-sm font-bold text-primary transition-all hover:bg-primary hover:text-white hover:border-primary hover:shadow-md">
                                <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $branchesMapLabel }}</span>
                            </a>
                        </div>
                        
                        <!-- Interactive Google Map Embed directly under the button -->
                        <div class="relative overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 shadow-inner h-60 w-full">
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
