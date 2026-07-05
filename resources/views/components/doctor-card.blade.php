@props(['doctor', 'bookButtonLabel'])

<div class="group relative overflow-hidden rounded-3xl border border-slate-200/60 bg-white p-6.5 text-center shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-primary/20 hover:shadow-xl hover:shadow-primary/5 flex flex-col justify-between h-[360px]">
    <!-- Top Accent Highlight Line -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary to-accent-blue transform scale-x-0 transition-transform duration-500 group-hover:scale-x-100"></div>

    <div class="space-y-4">
        <!-- Premium Double-Ring Circular Profile Frame -->
        <div class="relative mx-auto h-28 w-28 rounded-full p-1 bg-gradient-to-tr from-slate-100 to-slate-200/80 transition-all duration-500 group-hover:from-primary/25 group-hover:to-accent-blue/20">
            <div class="h-full w-full rounded-full border-2 border-white bg-slate-50 overflow-hidden shadow-inner flex items-center justify-center">
                @if($doctor->photo_url)
                    <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->name }}" class="h-full w-full object-cover transition-transform duration-750 group-hover:scale-105">
                @else
                    <div class="flex h-full w-full items-center justify-center bg-slate-50 text-slate-350">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
                    </div>
                @endif
            </div>
        </div>

        <!-- Doctor details -->
        <div class="space-y-2">
            <h3 class="text-base font-black text-slate-800 transition-colors duration-300 group-hover:text-primary leading-tight">
                {{ $doctor->name }}
            </h3>
            
            <span class="inline-block text-[10px] font-black text-primary bg-primary/8 px-3.5 py-1.5 rounded-full">
                {{ $doctor->specialty }}
            </span>
        </div>
        
        <!-- Working Hours -->
        <div class="flex items-center justify-center gap-1.5 rounded-2xl bg-slate-50/60 border border-slate-100 px-3.5 py-2.5 text-xs font-bold text-slate-500">
            <svg class="h-4 w-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="leading-none">{{ $doctor->working_hours }}</span>
        </div>
    </div>

    <!-- CTA Button -->
    <a href="{{ route('book') }}" 
       class="mt-5 block w-full rounded-xl border border-slate-200 bg-white py-2.5 text-center text-xs font-black text-slate-700 transition-all hover:bg-slate-900 hover:text-white hover:border-slate-900 active:scale-97">
        {{ $bookButtonLabel }}
    </a>
</div>
