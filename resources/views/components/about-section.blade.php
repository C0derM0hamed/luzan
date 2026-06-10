<section id="about" class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4 lg:px-6">
        <div class="text-right">
            <h2 class="text-[22px] font-bold text-[#222]">{{ $aboutTitle }}</h2>
            <div class="mt-2 h-[3px] w-10 bg-accent-red"></div>
        </div>
        <div class="mt-6 max-w-3xl text-right text-base leading-relaxed text-[#444]">
            {!! nl2br(e($aboutContent)) !!}
        </div>
    </div>
</section>
