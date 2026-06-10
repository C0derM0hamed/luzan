<section id="contact" class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4 lg:px-6">
        <div class="text-right">
            <h2 class="text-[22px] font-bold text-[#222]">{{ $contactTitle }}</h2>
            <div class="mt-2 h-[3px] w-10 bg-accent-red"></div>
        </div>

        @if(!empty($contactContent))
            <p class="mt-6 max-w-3xl text-right text-base text-[#444]">{{ $contactContent }}</p>
        @endif

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @if(!empty($phone))
                <div class="rounded-[10px] border border-[#eee] bg-surface p-5">
                    <h3 class="text-sm font-bold text-primary">الهاتف</h3>
                    <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="mt-2 block text-base text-[#222]" dir="ltr">{{ $phone }}</a>
                </div>
            @endif
            @if(!empty($siteEmail))
                <div class="rounded-[10px] border border-[#eee] bg-surface p-5">
                    <h3 class="text-sm font-bold text-primary">البريد الإلكتروني</h3>
                    <a href="mailto:{{ $siteEmail }}" class="mt-2 block text-base text-[#222]" dir="ltr">{{ $siteEmail }}</a>
                </div>
            @endif
            @if(!empty($contactAddress))
                <div class="rounded-[10px] border border-[#eee] bg-surface p-5 sm:col-span-2 lg:col-span-1">
                    <h3 class="text-sm font-bold text-primary">العنوان</h3>
                    <p class="mt-2 text-base text-[#222]">{{ $contactAddress }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
