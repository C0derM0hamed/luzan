@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <!-- Statistics Grid -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($stats as $stat)
            @php
                $icon = '';
                $strokeColor = '';
                $sparklinePoints = '';
                $glowColor = '';
                
                if ($loop->index === 0) {
                    $icon = '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
                    $strokeColor = '#00a99d'; // Primary Teal
                    $glowColor = 'rgba(0, 169, 157, 0.1)';
                    $sparklinePoints = '0,25 15,20 30,30 45,15 60,10 75,18 90,8 105,12 120,5';
                } elseif ($loop->index === 1) {
                    $icon = '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z"/></svg>';
                    $strokeColor = '#0ea5e9'; // Accent Blue
                    $glowColor = 'rgba(14, 165, 233, 0.1)';
                    $sparklinePoints = '0,15 15,22 30,10 45,25 60,20 75,5 90,14 105,8 120,3';
                } elseif ($loop->index === 2) {
                    $icon = '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>';
                    $strokeColor = '#8b5cf6'; // Violet
                    $glowColor = 'rgba(139, 92, 246, 0.1)';
                    $sparklinePoints = '0,20 15,10 30,22 45,8 60,15 75,25 90,10 105,5 120,4';
                } else {
                    $icon = '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                    $strokeColor = '#f59e0b'; // Amber
                    $glowColor = 'rgba(245, 158, 11, 0.1)';
                    $sparklinePoints = '0,25 15,28 30,20 45,18 60,12 75,10 90,22 105,15 120,8';
                }
            @endphp
            
            <div class="premium-card relative overflow-hidden rounded-3xl p-6 flex flex-col justify-between h-44">
                <!-- Top Details -->
                <div class="flex items-start justify-between relative z-10">
                    <div class="space-y-1 text-right">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">{{ $stat['label'] }}</span>
                        <span class="text-3xl font-black text-slate-900 block pt-1.5">{{ $stat['value'] }}</span>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-500 shadow-sm" style="color: {{ $strokeColor }}">
                        {!! $icon !!}
                    </div>
                </div>

                <!-- Sparkline Visualizer Overlay at bottom -->
                <div class="absolute bottom-0 left-0 right-0 h-16 pointer-events-none z-0">
                    <svg class="w-full h-full" viewBox="0 0 120 30" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="grad-{{ $loop->index }}" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="{{ $strokeColor }}" stop-opacity="0.2" />
                                <stop offset="100%" stop-color="{{ $strokeColor }}" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <!-- Area -->
                        <polygon points="-5,35 {{ $sparklinePoints }} 125,35" fill="url(#grad-{{ $loop->index }})" />
                        <!-- Line -->
                        <polyline points="{{ $sparklinePoints }}" fill="none" stroke="{{ $strokeColor }}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Recent Appointments Container -->
    @if($recentAppointments->isNotEmpty())
        <div class="mt-10 overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6.5 py-5.5 flex items-center justify-between">
                <h2 class="font-black text-slate-900 text-sm">{{ $recentAppointmentsTitle }}</h2>
                <span class="inline-flex h-2.5 w-2.5 rounded-full bg-primary animate-pulse"></span>
            </div>
            
            <div class="overflow-x-auto scrollbar-hide">
                <table class="min-w-full text-xs text-right">
                    <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-500">
                        <tr>
                            @foreach($appointmentTableHeaders as $header)
                                <th class="px-6 py-4 font-black uppercase tracking-wider">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/80">
                        @foreach($recentAppointments as $appointment)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <!-- Client Details -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-900">{{ $appointment->full_name }}</span>
                                        <span class="text-[10px] text-slate-400 font-semibold mt-0.5">الهوية: {{ $appointment->national_id }}</span>
                                    </div>
                                </td>
                                <!-- Mobile Phone -->
                                <td class="px-6 py-4 text-slate-650 font-extrabold" dir="ltr">{{ $appointment->mobile }}</td>
                                <!-- Doctor Name -->
                                <td class="px-6 py-4 text-slate-700 font-bold">
                                    @if($appointment->doctor)
                                        <div class="flex items-center gap-2">
                                            <div class="h-6 w-6 rounded-full bg-slate-50 border border-slate-150 flex items-center justify-center shrink-0">
                                                <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            </div>
                                            <span>{{ $appointment->doctor->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-slate-400 font-semibold">—</span>
                                    @endif
                                </td>
                                <!-- Visit Date -->
                                <td class="px-6 py-4 text-slate-650 font-bold" dir="ltr">
                                    {{ $appointment->appointment_date->format('Y-m-d') }}
                                </td>
                                <!-- Status Badge -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-xl px-3 py-1.5 text-[10px] font-black transition-all border {{ 
                                        $appointment->status === 'approved' ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 
                                        ($appointment->status === 'cancelled' ? 'bg-rose-50 border-rose-100 text-rose-800' : 'bg-amber-50 border-amber-100 text-amber-800') 
                                    }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $appointment->status === 'approved' ? 'bg-emerald-500' : ($appointment->status === 'cancelled' ? 'bg-rose-500' : 'bg-amber-500') }}"></span>
                                        <span>{{ $appointmentStatusLabels[$appointment->status] ?? $appointment->status }}</span>
                                    </span>
                                </td>
                                <!-- Action Button -->
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-[10px] font-black text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-primary hover:border-slate-350 active:scale-95">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ $viewActionLabel }}</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
