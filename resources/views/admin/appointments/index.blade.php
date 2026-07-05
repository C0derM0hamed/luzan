@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <!-- Filter Panel -->
    <form method="GET" action="{{ route('admin.appointments.index') }}" class="mb-8 flex flex-wrap items-end gap-6 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
        <div class="flex-1 min-w-[200px] text-right">
            <label for="status" class="mb-2.5 block text-xs font-black text-slate-700">{{ $filterLabels['status'] }}</label>
            <div class="relative">
                <select name="status" id="status" class="h-12 w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50/30 pr-4 pl-10 text-xs font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-350">
                    <option value="">{{ $filterLabels['all'] }}</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </span>
            </div>
        </div>
        
        <div class="flex-1 min-w-[200px] text-right">
            <label for="date" class="mb-2.5 block text-xs font-black text-slate-700">{{ $filterLabels['date'] }}</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}" class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/30 px-4 text-xs font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-350">
        </div>
        
        <button type="submit" class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 text-xs font-black text-white shadow-xl shadow-slate-950/10 transition-all hover:bg-primary hover:shadow-primary/20 hover:scale-101 active:scale-99">
            <svg class="h-4.5 w-4.5 text-primary-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <span>{{ $filterLabels['apply'] }}</span>
        </button>
    </form>

    <!-- Table Card Container -->
    <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto scrollbar-hide">
            <table class="min-w-full text-xs text-right">
                <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-500">
                    <tr>
                        @foreach($tableHeaders as $header)
                            <th class="px-6 py-4.5 font-black uppercase tracking-wider">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <!-- Appointment ID -->
                            <td class="px-6 py-4 text-slate-400 font-extrabold">#{{ $appointment->id }}</td>
                            
                            <!-- Patient Details -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-900">{{ $appointment->full_name }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold mt-0.5">الهوية: {{ $appointment->national_id }}</span>
                                </div>
                            </td>
                            
                            <!-- National ID (Original Column preserved) -->
                            <td class="px-6 py-4 text-slate-650 font-semibold" dir="ltr">{{ $appointment->national_id }}</td>
                            
                            <!-- Mobile -->
                            <td class="px-6 py-4 text-slate-650 font-extrabold" dir="ltr">{{ $appointment->mobile }}</td>
                            
                            <!-- Target (Doctor / Specialty) -->
                            <td class="px-6 py-4 text-slate-700 font-bold">
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-slate-50 border border-slate-150 flex items-center justify-center shrink-0">
                                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    </div>
                                    <span>{{ $appointment->bookingTargetLabel() }}</span>
                                </div>
                            </td>
                            
                            <!-- Appointment Date -->
                            <td class="px-6 py-4 text-slate-650 font-bold" dir="ltr">
                                {{ $appointment->appointment_date->format('Y-m-d') }}
                            </td>
                            
                            <!-- Status Pill -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 rounded-xl px-3 py-1.5 text-[10px] font-black transition-all border {{ 
                                    $appointment->status === 'approved' ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 
                                    ($appointment->status === 'cancelled' ? 'bg-rose-50 border-rose-100 text-rose-800' : 'bg-amber-50 border-amber-100 text-amber-800') 
                                }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $appointment->status === 'approved' ? 'bg-emerald-500' : ($appointment->status === 'cancelled' ? 'bg-rose-500' : 'bg-amber-500') }}"></span>
                                    <span>{{ $appointmentStatusLabels[$appointment->status] ?? $appointment->status }}</span>
                                </span>
                            </td>
                            
                            <!-- Actions Grid -->
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-[10px] font-black text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-primary hover:border-slate-350 active:scale-95">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ $viewActionLabel }}</span>
                                    </a>
                                    
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-[10px] font-black text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-primary hover:border-slate-350 active:scale-95">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>{{ $editLabel }}</span>
                                    </a>
                                    
                                    @if($appointment->status === \App\Models\Appointment::STATUS_PENDING)
                                        <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-[10px] font-black text-emerald-700 shadow-sm transition hover:bg-emerald-100 hover:border-emerald-300 active:scale-95">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                <span>{{ $approveLabel ?? 'موافقة' }}</span>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="inline" onsubmit="return confirm('{{ $cancelConfirm ?? 'هل تريد إلغاء هذا الموعد؟' }}')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-[10px] font-black text-rose-600 shadow-sm transition hover:bg-rose-100 hover:border-rose-300 active:scale-95">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                <span>{{ $cancelActionLabel ?? 'إلغاء' }}</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400 font-bold">لا توجد مواعيد حالياً تطابق خيارات التصفية</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-6 flex justify-center">{{ $appointments->withQueryString()->links() }}</div>
@endsection
