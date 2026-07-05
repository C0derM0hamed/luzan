@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    @php
        $formatCost = fn (?float $cost) => $cost !== null ? '$'.number_format($cost, 4) : '—';
        $formatNumber = fn (int $n) => number_format($n);
    @endphp

    <div class="max-w-6xl space-y-8">
        <!-- Top Title Bar -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-6">
            <div class="text-right space-y-1">
                <h2 class="text-xl font-black text-slate-900">إحصائيات استخدام الذكاء الاصطناعي</h2>
                <p class="text-xs font-semibold text-slate-400">تتبع الطلبات والرموز والتكلفة التقديرية لجميع مزودي AI.</p>
            </div>
            <a href="{{ route('admin.ai-assistant.edit') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-black text-slate-700 shadow-sm hover:bg-slate-50 transition active:scale-97">
                <svg class="h-4.5 w-4.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>إعدادات المساعد</span>
            </a>
        </div>

        <!-- Overall Summary Panels -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Stat 1 -->
            <div class="premium-card relative overflow-hidden rounded-3xl p-6 h-40 flex flex-col justify-between">
                <div class="relative z-10 text-right space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">إجمالي الطلبات</span>
                    <span class="text-3xl font-black text-slate-900 block pt-2">{{ $formatNumber($summary['total_requests']) }}</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-16 pointer-events-none z-0">
                    <svg class="w-full h-full" viewBox="0 0 120 30" preserveAspectRatio="none">
                        <polygon points="-5,35 0,22 20,28 40,15 60,22 80,10 100,18 120,5 125,35" fill="rgba(0,169,157,0.06)" />
                        <polyline points="0,22 20,28 40,15 60,22 80,10 100,18 120,5" fill="none" stroke="#00a99d" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="premium-card relative overflow-hidden rounded-3xl p-6 h-40 flex flex-col justify-between">
                <div class="relative z-10 text-right space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">إجمالي الرموز (Tokens)</span>
                    <span class="text-3xl font-black text-slate-900 block pt-2" dir="ltr">{{ $formatNumber($summary['total_tokens']) }}</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-16 pointer-events-none z-0">
                    <svg class="w-full h-full" viewBox="0 0 120 30" preserveAspectRatio="none">
                        <polygon points="-5,35 0,18 20,15 40,25 60,10 80,22 100,12 120,4 125,35" fill="rgba(14,165,233,0.06)" />
                        <polyline points="0,18 20,15 40,25 60,10 80,22 100,12 120,4" fill="none" stroke="#0ea5e9" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="premium-card relative overflow-hidden rounded-3xl p-6 h-40 flex flex-col justify-between sm:col-span-2 lg:col-span-1">
                <div class="relative z-10 text-right space-y-1">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">التكلفة التقديرية</span>
                    <span class="text-3xl font-black text-slate-900 block pt-2" dir="ltr">
                        {{ $summary['has_cost_data'] ? $formatCost($summary['estimated_cost']) : '—' }}
                    </span>
                    <span class="text-[9px] font-bold text-slate-400 block pt-1">
                        {{ $summary['has_cost_data'] ? 'USD — تقدير بناءً على أسعار النماذج' : 'لا توجد بيانات تكلفة بعد' }}
                    </span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-16 pointer-events-none z-0">
                    <svg class="w-full h-full" viewBox="0 0 120 30" preserveAspectRatio="none">
                        <polygon points="-5,35 0,25 20,20 40,22 60,15 80,18 100,8 120,6 125,35" fill="rgba(245,158,11,0.06)" />
                        <polyline points="0,25 20,20 40,22 60,15 80,18 100,8 120,6" fill="none" stroke="#f59e0b" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Today & Month Grid -->
        <div class="grid gap-6 sm:grid-cols-2">
            <!-- Today Usage -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-5">
                <h3 class="text-xs font-black text-slate-900">استخدام اليوم</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-slate-50/50 rounded-2xl p-3 border border-slate-100">
                        <span class="text-[10px] font-black text-slate-400 block">الطلبات</span>
                        <span class="mt-1.5 text-base font-black text-slate-900 block">{{ $formatNumber($today['requests']) }}</span>
                    </div>
                    <div class="bg-slate-50/50 rounded-2xl p-3 border border-slate-100">
                        <span class="text-[10px] font-black text-slate-400 block">الرموز</span>
                        <span class="mt-1.5 text-base font-black text-slate-900 block" dir="ltr">{{ $formatNumber($today['tokens']) }}</span>
                    </div>
                    <div class="bg-slate-50/50 rounded-2xl p-3 border border-slate-100">
                        <span class="text-[10px] font-black text-slate-400 block">التكلفة</span>
                        <span class="mt-1.5 text-base font-black text-slate-900 block" dir="ltr">{{ $today['has_cost_data'] ? $formatCost($today['estimated_cost']) : '—' }}</span>
                    </div>
                </div>
            </div>

            <!-- Month Usage -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-5">
                <h3 class="text-xs font-black text-slate-900">استخدام الشهر الحالي</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-slate-50/50 rounded-2xl p-3 border border-slate-100">
                        <span class="text-[10px] font-black text-slate-400 block">الطلبات</span>
                        <span class="mt-1.5 text-base font-black text-slate-900 block">{{ $formatNumber($month['requests']) }}</span>
                    </div>
                    <div class="bg-slate-50/50 rounded-2xl p-3 border border-slate-100">
                        <span class="text-[10px] font-black text-slate-400 block">الرموز</span>
                        <span class="mt-1.5 text-base font-black text-slate-900 block" dir="ltr">{{ $formatNumber($month['tokens']) }}</span>
                    </div>
                    <div class="bg-slate-50/50 rounded-2xl p-3 border border-slate-100">
                        <span class="text-[10px] font-black text-slate-400 block">التكلفة</span>
                        <span class="mt-1.5 text-base font-black text-slate-900 block" dir="ltr">{{ $month['has_cost_data'] ? $formatCost($month['estimated_cost']) : '—' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- By Provider & Model Grid -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Usage by Provider -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <h3 class="text-xs font-black text-slate-900 mb-5">الاستخدام حسب المزود</h3>
                @if($byProvider->isEmpty())
                    <p class="text-xs font-bold text-slate-400 py-6 text-center">لا توجد بيانات استخدام بعد.</p>
                @else
                    <div class="overflow-x-auto scrollbar-hide">
                        <table class="w-full text-xs text-right">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400">
                                    <th class="pb-3 px-2 font-black uppercase">المزود</th>
                                    <th class="pb-3 px-2 font-black uppercase">الطلبات</th>
                                    <th class="pb-3 px-2 font-black uppercase">الرموز</th>
                                    <th class="pb-3 px-2 font-black uppercase">التكلفة</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($byProvider as $row)
                                    <tr class="hover:bg-slate-50/30">
                                        <td class="py-3.5 px-2 font-black text-slate-800">{{ $row->provider_label }}</td>
                                        <td class="py-3.5 px-2 font-semibold text-slate-650">{{ $formatNumber($row->requests) }}</td>
                                        <td class="py-3.5 px-2 font-semibold text-slate-650" dir="ltr">{{ $formatNumber($row->tokens) }}</td>
                                        <td class="py-3.5 px-2 font-semibold text-slate-800" dir="ltr">{{ $row->estimated_cost !== null ? $formatCost($row->estimated_cost) : '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Usage by Model -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <h3 class="text-xs font-black text-slate-900 mb-5">الاستخدام حسب النموذج</h3>
                @if($byModel->isEmpty())
                    <p class="text-xs font-bold text-slate-400 py-6 text-center">لا توجد بيانات استخدام بعد.</p>
                @else
                    <div class="overflow-x-auto scrollbar-hide">
                        <table class="w-full text-xs text-right">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400">
                                    <th class="pb-3 px-2 font-black uppercase">النموذج</th>
                                    <th class="pb-3 px-2 font-black uppercase">الطلبات</th>
                                    <th class="pb-3 px-2 font-black uppercase">الرموز</th>
                                    <th class="pb-3 px-2 font-black uppercase">التكلفة</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($byModel as $row)
                                    <tr class="hover:bg-slate-50/30">
                                        <td class="py-3.5 px-2">
                                            <div class="flex flex-col">
                                                <span class="font-black text-slate-800">{{ $row->provider_label }}</span>
                                                <span class="text-[9px] font-semibold text-slate-400 font-mono mt-0.5" dir="ltr">{{ $row->model }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-2 font-semibold text-slate-650">{{ $formatNumber($row->requests) }}</td>
                                        <td class="py-3.5 px-2 font-semibold text-slate-650" dir="ltr">{{ $formatNumber($row->tokens) }}</td>
                                        <td class="py-3.5 px-2 font-semibold text-slate-800" dir="ltr">{{ $row->estimated_cost !== null ? $formatCost($row->estimated_cost) : '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Daily Graph Visualizer -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-6">
            <h3 class="text-xs font-black text-slate-900">الاستخدام اليومي (آخر 30 يوماً)</h3>
            @if($dailyUsage->isEmpty())
                <p class="text-xs font-bold text-slate-400 py-10 text-center">لا توجد بيانات يومية بعد.</p>
            @else
                <!-- CSS Visual Bar Chart -->
                <div class="flex items-end justify-between gap-1.5 h-44 pt-4 px-2 border-b border-slate-100">
                    @php
                        $maxRequests = $dailyUsage->max('requests') ?: 1;
                    @endphp
                    @foreach($dailyUsage->reverse() as $row)
                        @php
                            $heightPercent = max(5, round(($row->requests / $maxRequests) * 100));
                        @endphp
                        <div class="group relative flex-1 flex flex-col items-center">
                            <!-- Tooltip -->
                            <div class="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-20 pointer-events-none">
                                <div class="bg-slate-950 text-white text-[9px] font-black rounded-lg p-2 shadow-xl shrink-0 space-y-0.5 text-center min-w-[90px]">
                                    <span class="block border-b border-white/10 pb-1 text-slate-400" dir="ltr">{{ $row->date }}</span>
                                    <span class="block pt-0.5">الطلبات: {{ $formatNumber($row->requests) }}</span>
                                    <span class="block">التكلفة: {{ $row->estimated_cost !== null ? $formatCost($row->estimated_cost) : '—' }}</span>
                                </div>
                                <div class="w-1.5 h-1.5 bg-slate-950 rotate-45 -mt-1"></div>
                            </div>
                            <!-- Bar -->
                            <div class="w-full rounded-t bg-slate-100 group-hover:bg-primary transition-all duration-300" style="height: {{ $heightPercent }}px;"></div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between text-[9px] font-bold text-slate-400 px-1 pt-1">
                    <span>{{ $dailyUsage->last()->date }}</span>
                    <span>آخر 30 يوماً</span>
                    <span>{{ $dailyUsage->first()->date }}</span>
                </div>
            @endif
        </div>

        <!-- Monthly Graph Visualizer -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-6">
            <h3 class="text-xs font-black text-slate-900">الاستخدام الشهري (آخر 12 شهراً)</h3>
            @if($monthlyUsage->isEmpty())
                <p class="text-xs font-bold text-slate-400 py-10 text-center">لا توجد بيانات شهرية بعد.</p>
            @else
                <!-- CSS Visual Bar Chart -->
                <div class="flex items-end justify-between gap-3 h-44 pt-4 px-4 border-b border-slate-100">
                    @php
                        $maxMonthRequests = $monthlyUsage->max('requests') ?: 1;
                    @endphp
                    @foreach($monthlyUsage->reverse() as $row)
                        @php
                            $heightPercent = max(5, round(($row->requests / $maxMonthRequests) * 100));
                        @endphp
                        <div class="group relative flex-1 flex flex-col items-center">
                            <!-- Tooltip -->
                            <div class="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-20 pointer-events-none">
                                <div class="bg-slate-950 text-white text-[9px] font-black rounded-lg p-2 shadow-xl shrink-0 space-y-0.5 text-center min-w-[100px]">
                                    <span class="block border-b border-white/10 pb-1 text-slate-400" dir="ltr">{{ $row->month }}</span>
                                    <span class="block pt-0.5">الطلبات: {{ $formatNumber($row->requests) }}</span>
                                    <span class="block">التكلفة: {{ $row->estimated_cost !== null ? $formatCost($row->estimated_cost) : '—' }}</span>
                                </div>
                                <div class="w-1.5 h-1.5 bg-slate-950 rotate-45 -mt-1"></div>
                            </div>
                            <!-- Bar -->
                            <div class="w-full rounded-t-md bg-slate-100 group-hover:bg-primary transition-all duration-300" style="height: {{ $heightPercent }}px;"></div>
                            <span class="text-[9px] font-black text-slate-400 mt-2 truncate w-full text-center" dir="ltr">{{ $row->month }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
