@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="max-w-3xl overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        <!-- Header banner inside card -->
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-950 p-6.5 text-right text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/5 border border-white/10 text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-black text-white leading-tight">تفاصيل الموعد</h3>
                    <p class="text-[10px] text-slate-400 font-bold mt-1">طلب موعد رقم #{{ $appointment->id }}</p>
                </div>
            </div>
            <!-- Status Badge -->
            <span class="inline-flex items-center gap-1.5 rounded-xl px-3 py-1.5 text-[10px] font-black transition-all border {{ 
                $appointment->status === 'approved' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 
                ($appointment->status === 'cancelled' ? 'bg-rose-500/10 border-rose-500/20 text-rose-400' : 'bg-amber-500/10 border-amber-500/20 text-amber-400') 
            }}">
                <span class="h-1.5 w-1.5 rounded-full {{ $appointment->status === 'approved' ? 'bg-emerald-400' : ($appointment->status === 'cancelled' ? 'bg-rose-400' : 'bg-amber-400') }}"></span>
                <span>{{ $appointmentStatusLabels[$appointment->status] ?? $appointment->status }}</span>
            </span>
        </div>

        <div class="p-8">
            <!-- Data Grid -->
            <dl class="grid gap-6 sm:grid-cols-2 text-right">
                @foreach($appointmentDetails as $label => $value)
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-4.5 space-y-1.5">
                        <dt class="text-[10px] font-black text-slate-400 uppercase tracking-wider">{{ $label }}</dt>
                        <dd class="text-sm font-bold text-slate-800">{{ $value ?: '—' }}</dd>
                    </div>
                @endforeach
            </dl>

            <!-- Actions row -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap gap-2.5">
                    @if($appointment->status === \App\Models\Appointment::STATUS_PENDING)
                        <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-6 text-xs font-black text-white shadow-lg shadow-emerald-600/10 transition hover:bg-emerald-700 hover:scale-101 active:scale-99">
                                <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ $approveLabel }}</span>
                            </button>
                        </form>
                        <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="inline" onsubmit="return confirm('{{ $cancelConfirm }}')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-2xl bg-rose-600 px-6 text-xs font-black text-white shadow-lg shadow-rose-600/10 transition hover:bg-rose-700 hover:scale-101 active:scale-99">
                                <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                <span>{{ $cancelActionLabel }}</span>
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 text-xs font-black text-white shadow-xl shadow-slate-950/10 transition hover:bg-primary hover:shadow-primary/20 hover:scale-101 active:scale-99">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>{{ $editLabel }}</span>
                    </a>
                </div>
                
                <a href="{{ route('admin.appointments.index') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-6 text-xs font-black text-slate-700 transition hover:bg-slate-50 active:scale-97">
                    <span>{{ $backLabel }}</span>
                </a>
            </div>
        </div>
    </div>
@endsection
