@if($latestOffer)
<div x-data="{ show: false }" x-init="if (!sessionStorage.getItem('offerPopupShown')) { setTimeout(() => { show = true; sessionStorage.setItem('offerPopupShown', 'true'); }, 3000); }" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="show" x-cloak>
    <div x-show="show" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="show" x-transition class="relative transform overflow-hidden rounded-3xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <button @click="show = false" class="absolute top-4 left-4 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-black/20 text-white hover:bg-black/40 backdrop-blur transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                @if($latestOffer->image_url)
                    <div class="aspect-video w-full overflow-hidden">
                        <img src="{{ $latestOffer->image_url }}" alt="{{ $latestOffer->title }}" class="h-full w-full object-cover">
                    </div>
                @else
                    <div class="aspect-video w-full bg-gradient-to-r from-primary to-primary-dark flex items-center justify-center">
                        <svg class="h-16 w-16 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    </div>
                @endif
                <div class="bg-white px-6 pb-6 pt-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="rounded-full bg-red-50 text-red-600 px-2 py-0.5 text-[10px] font-bold border border-red-100 uppercase tracking-wider">عرض حصري</span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-800" id="modal-title">{{ $latestOffer->title }}</h3>
                    <div class="mt-3">
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $latestOffer->description }}</p>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-primary bg-primary/5 w-max px-3 py-1.5 rounded-lg">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>ينتهي العرض في: {{ $latestOffer->end_date->format('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" @click="show = false" class="w-full sm:w-auto rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-colors text-center">إغلاق</button>
                    <a href="{{ route('book') }}" class="w-full sm:w-auto text-center rounded-xl bg-gradient-to-r from-primary to-primary-dark px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-primary/20 transition-all hover:scale-105 active:scale-95">احجز موعدك الآن</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
