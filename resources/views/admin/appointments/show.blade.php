@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="max-w-3xl rounded-xl border border-border bg-white p-6 shadow-sm">
        <dl class="grid gap-4 sm:grid-cols-2">
            @foreach($appointmentDetails as $label => $value)
                <div>
                    <dt class="text-xs font-semibold text-muted">{{ $label }}</dt>
                    <dd class="mt-1 text-sm font-medium text-[#222]">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
        <div class="mt-6 flex flex-wrap gap-3">
            @if($appointment->status === \App\Models\Appointment::STATUS_PENDING)
                <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="rounded bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">{{ $approveLabel }}</button>
                </form>
                <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="inline" onsubmit="return confirm('{{ $cancelConfirm }}')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="rounded bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">{{ $cancelActionLabel }}</button>
                </form>
            @endif
            <a href="{{ route('admin.appointments.edit', $appointment) }}" class="rounded bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-primary-dark">{{ $editLabel }}</a>
            <a href="{{ route('admin.appointments.index') }}" class="rounded border border-border px-4 py-2 text-sm hover:bg-surface">{{ $backLabel }}</a>
        </div>
    </div>
@endsection
