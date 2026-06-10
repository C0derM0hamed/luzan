@props(['doctor', 'bookButtonLabel'])

<div class="w-full rounded-3xl border border-slate-100 bg-white p-6 text-center shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:border-primary/15 group">
    <!-- Doctor Photo Frame -->
    <div class="relative mx-auto h-28 w-28 rounded-full border-4 border-slate-50 bg-slate-100 shadow-md overflow-hidden transition-transform duration-500 group-hover:scale-105">
        @if($doctor->photo_url)
            <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->name }}" class="h-full w-full object-cover">
        @else
            <div class="flex h-full w-full items-center justify-center bg-slate-200 text-slate-400">
                <svg class="h-12 w-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
            </div>
        @endif
    </div>

    <!-- Doctor Details -->
    <h3 class="mt-5 text-base font-extrabold text-slate-800 transition-colors duration-300 group-hover:text-primary">{{ $doctor->name }}</h3>
    <span class="mt-1.5 inline-block text-xs font-bold text-primary bg-primary/5 px-2.5 py-1 rounded-lg">{{ $doctor->specialty }}</span>
    
    <!-- Working Hours Badge -->
    <div class="mt-4 flex items-center justify-center gap-1.5 rounded-xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-500 border border-slate-100">
        <svg class="h-3.5 w-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="leading-tight">{{ $doctor->working_hours }}</span>
    </div>

    <!-- CTA Button -->
    <a href="{{ route('book') }}" class="mt-6 block w-full rounded-xl border border-primary/25 bg-white py-2.5 text-center text-xs font-extrabold text-primary shadow-sm transition-all hover:bg-primary hover:text-white hover:border-primary hover:shadow-md hover:-translate-y-0.5 active:translate-y-0">{{ $bookButtonLabel }}</a>
</div>
