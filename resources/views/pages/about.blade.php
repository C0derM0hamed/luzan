@extends('layouts.app')

@section('title', 'من نحن')

@section('content')
<!-- Header Banner -->
<section class="relative bg-gradient-to-r from-primary to-primary-dark py-20 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-accent-blue/20 blur-3xl"></div>
    
    <div class="relative z-10 mx-auto max-w-7xl px-4 text-center lg:px-6">
        <h1 class="text-4xl font-extrabold sm:text-5xl leading-tight">من نحن</h1>
        <p class="mt-4 text-lg text-white/90 max-w-2xl mx-auto">تعرف على مجمع لوزان التخصصي الطبي ورسالتنا في تقديم أرقى مستويات الرعاية الصحية</p>
    </div>
</section>

<!-- Content Area -->
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7">
                <div class="text-right">
                    <span class="text-sm font-bold text-accent-blue tracking-wider uppercase">قصتنا ورؤيتنا</span>
                    <h2 class="text-3xl font-extrabold text-slate-800 mt-2 leading-tight sm:text-4xl">نبذة عن مجمع لوزان</h2>
                    <div class="mt-3 h-1.5 w-16 rounded-full bg-gradient-to-r from-accent-red to-red-500"></div>
                </div>
                
                <div class="mt-8 text-lg text-slate-600 leading-relaxed space-y-6 text-justify">
                    <p>
                        {!! nl2br(e($aboutContent ?? 'مجمع لوزان التخصصي الطبي هو مركز رعاية صحية متكامل يقدم خدمات طبية شاملة بأيدي نخبة من الأطباء والاستشاريين. نحن ملتزمون بتقديم رعاية عالية الجودة باستخدام أحدث التقنيات الطبية، مع فروع متعددة لخدمة أهالي المنطقة.')) !!}
                    </p>
                </div>
            </div>

            <!-- Side Card decoration -->
            <div class="lg:col-span-5">
                <div class="relative rounded-3xl border border-slate-100 bg-slate-50 p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-primary mb-6">قيمنا الأساسية</h3>
                    
                    <div class="space-y-6">
                        <div class="flex gap-4 items-start">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-primary text-white font-bold text-lg">١</div>
                            <div>
                                <h4 class="font-bold text-slate-800">الجودة الفائقة</h4>
                                <p class="text-sm text-slate-500 mt-1">نلتزم بأعلى معايير الرعاية والتعقيم والتشخيص الطبي الصحيح.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 items-start">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-accent-blue text-white font-bold text-lg">٢</div>
                            <div>
                                <h4 class="font-bold text-slate-800">رعاية المريض</h4>
                                <p class="text-sm text-slate-500 mt-1">المريض هو محور اهتمامنا، ونسعى دائماً لتوفير سبل الراحة والخصوصية.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 items-start">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-accent-red text-white font-bold text-lg">٣</div>
                            <div>
                                <h4 class="font-bold text-slate-800">التقنيات الحديثة</h4>
                                <p class="text-sm text-slate-500 mt-1">نستعين بأحدث الأجهزة والتقنيات الطبية لضمان كفاءة علاجية قصوى.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
