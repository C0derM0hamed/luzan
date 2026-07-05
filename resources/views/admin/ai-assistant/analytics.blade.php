@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    @php
        $formatCost = fn (?float $cost) => $cost !== null ? '$'.number_format($cost, 4) : '—';
        $formatNumber = fn (int $n) => number_format($n);
    @endphp

    <div class="max-w-6xl space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-[#222]">إحصائيات استخدام الذكاء الاصطناعي</h2>
                <p class="mt-1 text-sm text-muted">تتبع الطلبات والرموز والتكلفة التقديرية لجميع مزودي AI.</p>
            </div>
            <a href="{{ route('admin.ai-assistant.edit') }}" class="inline-flex items-center gap-2 rounded-lg border border-border bg-white px-4 py-2 text-sm font-semibold text-primary hover:bg-primary/5 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                إعدادات المساعد
            </a>
        </div>

        {{-- Overall summary --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl border border-blue-100 bg-gradient-to-br from-blue-50 to-indigo-50 p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">إجمالي الطلبات</p>
                <p class="mt-2 text-3xl font-extrabold text-indigo-950">{{ $formatNumber($summary['total_requests']) }}</p>
            </div>
            <div class="rounded-xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-teal-50 p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">إجمالي الرموز (Tokens)</p>
                <p class="mt-2 text-3xl font-extrabold text-teal-950" dir="ltr">{{ $formatNumber($summary['total_tokens']) }}</p>
            </div>
            <div class="rounded-xl border border-amber-100 bg-gradient-to-br from-amber-50 to-yellow-50 p-5 shadow-sm sm:col-span-2 lg:col-span-1">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">التكلفة التقديرية</p>
                <p class="mt-2 text-3xl font-extrabold text-amber-950" dir="ltr">
                    @if($summary['has_cost_data'])
                        {{ $formatCost($summary['estimated_cost']) }}
                    @else
                        —
                    @endif
                </p>
                @if($summary['has_cost_data'])
                    <p class="mt-1 text-xs text-muted">USD — تقدير بناءً على أسعار النماذج</p>
                @else
                    <p class="mt-1 text-xs text-muted">غير متاح — لا توجد بيانات تكلفة بعد</p>
                @endif
            </div>
        </div>

        {{-- Today & Month --}}
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-xl border border-border bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-[#222] mb-4">استخدام اليوم</h3>
                <dl class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <dt class="text-xs text-muted">الطلبات</dt>
                        <dd class="mt-1 text-xl font-bold text-primary">{{ $formatNumber($today['requests']) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-muted">الرموز</dt>
                        <dd class="mt-1 text-xl font-bold text-primary" dir="ltr">{{ $formatNumber($today['tokens']) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-muted">التكلفة</dt>
                        <dd class="mt-1 text-xl font-bold text-primary" dir="ltr">{{ $today['has_cost_data'] ? $formatCost($today['estimated_cost']) : '—' }}</dd>
                    </div>
                </dl>
            </div>
            <div class="rounded-xl border border-border bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-[#222] mb-4">استخدام الشهر الحالي</h3>
                <dl class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <dt class="text-xs text-muted">الطلبات</dt>
                        <dd class="mt-1 text-xl font-bold text-primary">{{ $formatNumber($month['requests']) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-muted">الرموز</dt>
                        <dd class="mt-1 text-xl font-bold text-primary" dir="ltr">{{ $formatNumber($month['tokens']) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-muted">التكلفة</dt>
                        <dd class="mt-1 text-xl font-bold text-primary" dir="ltr">{{ $month['has_cost_data'] ? $formatCost($month['estimated_cost']) : '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- By Provider --}}
        <div class="rounded-xl border border-border bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-[#222] mb-4">الاستخدام حسب المزود</h3>
            @if($byProvider->isEmpty())
                <p class="text-sm text-muted">لا توجد بيانات استخدام بعد.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right">
                        <thead>
                            <tr class="border-b border-border text-muted">
                                <th class="py-2 px-3 font-semibold">المزود</th>
                                <th class="py-2 px-3 font-semibold">الطلبات</th>
                                <th class="py-2 px-3 font-semibold">الرموز</th>
                                <th class="py-2 px-3 font-semibold">التكلفة التقديرية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byProvider as $row)
                                <tr class="border-b border-border/60">
                                    <td class="py-3 px-3 font-semibold">{{ $row->provider_label }}</td>
                                    <td class="py-3 px-3">{{ $formatNumber($row->requests) }}</td>
                                    <td class="py-3 px-3" dir="ltr">{{ $formatNumber($row->tokens) }}</td>
                                    <td class="py-3 px-3" dir="ltr">{{ $row->estimated_cost !== null ? $formatCost($row->estimated_cost) : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- By Model --}}
        <div class="rounded-xl border border-border bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-[#222] mb-4">الاستخدام حسب النموذج</h3>
            @if($byModel->isEmpty())
                <p class="text-sm text-muted">لا توجد بيانات استخدام بعد.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right">
                        <thead>
                            <tr class="border-b border-border text-muted">
                                <th class="py-2 px-3 font-semibold">المزود</th>
                                <th class="py-2 px-3 font-semibold">النموذج</th>
                                <th class="py-2 px-3 font-semibold">الطلبات</th>
                                <th class="py-2 px-3 font-semibold">الرموز</th>
                                <th class="py-2 px-3 font-semibold">التكلفة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byModel as $row)
                                <tr class="border-b border-border/60">
                                    <td class="py-3 px-3">{{ $row->provider_label }}</td>
                                    <td class="py-3 px-3 font-mono text-xs" dir="ltr">{{ $row->model }}</td>
                                    <td class="py-3 px-3">{{ $formatNumber($row->requests) }}</td>
                                    <td class="py-3 px-3" dir="ltr">{{ $formatNumber($row->tokens) }}</td>
                                    <td class="py-3 px-3" dir="ltr">{{ $row->estimated_cost !== null ? $formatCost($row->estimated_cost) : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Daily Usage --}}
        <div class="rounded-xl border border-border bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-[#222] mb-4">الاستخدام اليومي (آخر 30 يوماً)</h3>
            @if($dailyUsage->isEmpty())
                <p class="text-sm text-muted">لا توجد بيانات يومية بعد.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right">
                        <thead>
                            <tr class="border-b border-border text-muted">
                                <th class="py-2 px-3 font-semibold">التاريخ</th>
                                <th class="py-2 px-3 font-semibold">الطلبات</th>
                                <th class="py-2 px-3 font-semibold">الرموز</th>
                                <th class="py-2 px-3 font-semibold">التكلفة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailyUsage as $row)
                                <tr class="border-b border-border/60">
                                    <td class="py-3 px-3 font-semibold" dir="ltr">{{ $row->date }}</td>
                                    <td class="py-3 px-3">{{ $formatNumber($row->requests) }}</td>
                                    <td class="py-3 px-3" dir="ltr">{{ $formatNumber($row->tokens) }}</td>
                                    <td class="py-3 px-3" dir="ltr">{{ $row->estimated_cost !== null ? $formatCost($row->estimated_cost) : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Monthly Usage --}}
        <div class="rounded-xl border border-border bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-[#222] mb-4">الاستخدام الشهري (آخر 12 شهراً)</h3>
            @if($monthlyUsage->isEmpty())
                <p class="text-sm text-muted">لا توجد بيانات شهرية بعد.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right">
                        <thead>
                            <tr class="border-b border-border text-muted">
                                <th class="py-2 px-3 font-semibold">الشهر</th>
                                <th class="py-2 px-3 font-semibold">الطلبات</th>
                                <th class="py-2 px-3 font-semibold">الرموز</th>
                                <th class="py-2 px-3 font-semibold">التكلفة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyUsage as $row)
                                <tr class="border-b border-border/60">
                                    <td class="py-3 px-3 font-semibold" dir="ltr">{{ $row->month }}</td>
                                    <td class="py-3 px-3">{{ $formatNumber($row->requests) }}</td>
                                    <td class="py-3 px-3" dir="ltr">{{ $formatNumber($row->tokens) }}</td>
                                    <td class="py-3 px-3" dir="ltr">{{ $row->estimated_cost !== null ? $formatCost($row->estimated_cost) : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
