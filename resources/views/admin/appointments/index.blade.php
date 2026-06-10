@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <form method="GET" action="{{ route('admin.appointments.index') }}" class="mb-6 flex flex-wrap items-end gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <div class="flex-1 min-w-[200px]">
            <label for="status" class="mb-2 block text-xs font-bold text-slate-700">{{ $filterLabels['status'] }}</label>
            <select name="status" id="status" class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
                <option value="">{{ $filterLabels['all'] }}</option>
                @foreach($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <label for="date" class="mb-2 block text-xs font-bold text-slate-700">{{ $filterLabels['date'] }}</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}" class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
        </div>
        <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary px-6 text-sm font-bold text-white shadow-md shadow-primary/10 transition-all hover:bg-primary-dark hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <span>{{ $filterLabels['apply'] }}</span>
        </button>
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50/70 text-right border-b border-slate-100 text-slate-700">
                <tr>
                    @foreach($tableHeaders as $header)
                        <th class="px-6 py-4 font-semibold">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-slate-500 font-medium">#{{ $appointment->id }}</td>
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $appointment->full_name }}</td>
                        <td class="px-6 py-4 text-slate-600 font-medium" dir="ltr">{{ $appointment->national_id }}</td>
                        <td class="px-6 py-4 text-slate-650 font-semibold" dir="ltr">{{ $appointment->mobile }}</td>
                        <td class="px-6 py-4 text-slate-700 font-semibold">{{ $appointment->bookingTargetLabel() }}</td>
                        <td class="px-6 py-4 text-slate-600 font-semibold">{{ $appointment->appointment_date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold transition-all {{ $appointmentStatusClasses[$appointment->status] ?? 'bg-slate-150 text-slate-700' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $appointment->status === 'approved' ? 'bg-green-500' : ($appointment->status === 'cancelled' ? 'bg-red-500' : 'bg-yellow-500') }}"></span>
                                <span>{{ $appointmentStatusLabels[$appointment->status] ?? $appointment->status }}</span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-primary hover:border-slate-300">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>{{ $viewActionLabel }}</span>
                                </a>
                                <a href="{{ route('admin.appointments.edit', $appointment) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-primary hover:border-slate-300">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>{{ $editLabel }}</span>
                                </a>
                                @if($appointment->status === \App\Models\Appointment::STATUS_PENDING)
                                    <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-green-200 bg-green-50 px-3 py-2 text-xs font-bold text-green-700 shadow-sm transition hover:bg-green-100 hover:text-green-800">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            <span>{{ $approveLabel ?? 'موافقة' }}</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="inline" onsubmit="return confirm('{{ $cancelConfirm ?? 'هل تريد إلغاء هذا الموعد؟' }}')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-red-150 bg-red-50 px-3 py-2 text-xs font-bold text-red-600 shadow-sm transition hover:bg-red-100 hover:text-red-700">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            <span>{{ $cancelActionLabel ?? 'إلغاء' }}</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($tableHeaders) }}" class="px-6 py-10 text-center text-slate-400 font-medium">لا توجد مواعيد حالياً</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $appointments->withQueryString()->links() }}</div>
@endsection
