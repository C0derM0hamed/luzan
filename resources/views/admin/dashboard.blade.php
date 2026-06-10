@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($stats as $stat)
            @php
                $icon = '';
                $bgClass = '';
                $textClass = '';
                $iconClass = '';
                
                if ($loop->index === 0) {
                    $icon = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
                    $bgClass = 'from-blue-50 to-indigo-50 border-blue-100';
                    $textClass = 'text-indigo-950';
                    $iconClass = 'bg-indigo-500 text-white shadow-indigo-100';
                } elseif ($loop->index === 1) {
                    $icon = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z"/></svg>';
                    $bgClass = 'from-emerald-50 to-teal-50 border-emerald-100';
                    $textClass = 'text-teal-950';
                    $iconClass = 'bg-teal-500 text-white shadow-teal-100';
                } elseif ($loop->index === 2) {
                    $icon = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>';
                    $bgClass = 'from-purple-50 to-fuchsia-50 border-purple-100';
                    $textClass = 'text-purple-950';
                    $iconClass = 'bg-purple-500 text-white shadow-purple-100';
                } else {
                    $icon = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                    $bgClass = 'from-amber-50 to-yellow-50 border-amber-100';
                    $textClass = 'text-amber-950';
                    $iconClass = 'bg-amber-500 text-white shadow-amber-100';
                }
            @endphp
            
            <div class="relative overflow-hidden rounded-2xl border bg-gradient-to-br p-6 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5 {{ $bgClass }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $stat['label'] }}</p>
                        <p class="mt-2 text-3xl font-extrabold {{ $textClass }}">{{ $stat['value'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl shadow-lg shadow-black/5 {{ $iconClass }}">
                        {!! $icon !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($recentAppointments->isNotEmpty())
        <div class="mt-8 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-5 bg-white">
                <h2 class="font-bold text-slate-800 text-base">{{ $recentAppointmentsTitle }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50/70 text-right border-b border-slate-100 text-slate-700">
                        <tr>
                            @foreach($appointmentTableHeaders as $header)
                                <th class="px-6 py-4 font-semibold">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentAppointments as $appointment)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $appointment->full_name }}</td>
                                <td class="px-6 py-4 text-slate-650 font-semibold" dir="ltr">{{ $appointment->mobile }}</td>
                                <td class="px-6 py-4 text-slate-700 font-semibold">{{ $appointment->doctor?->name }}</td>
                                <td class="px-6 py-4 text-slate-600 font-semibold">{{ $appointment->appointment_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold transition-all {{ $appointmentStatusClasses[$appointment->status] ?? 'bg-slate-150 text-slate-700' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $appointment->status === 'approved' ? 'bg-green-500' : ($appointment->status === 'cancelled' ? 'bg-red-500' : 'bg-yellow-500') }}"></span>
                                        <span>{{ $appointmentStatusLabels[$appointment->status] ?? $appointment->status }}</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-primary hover:border-slate-300">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
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
