@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="max-w-2xl space-y-4 rounded-xl border border-border bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label for="full_name" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['full_name'] }}</label>
            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $appointment->full_name) }}" required class="h-11 w-full rounded border border-border px-3 text-sm">
        </div>
        <div>
            <label for="national_id" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['national_id'] }}</label>
            <input type="text" name="national_id" id="national_id" value="{{ old('national_id', $appointment->national_id) }}" required class="h-11 w-full rounded border border-border px-3 text-sm" dir="ltr">
        </div>
        <div>
            <label for="mobile" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['mobile'] }}</label>
            <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $appointment->mobile) }}" required class="h-11 w-full rounded border border-border px-3 text-sm" dir="ltr">
        </div>
        <div>
            <label for="doctor_id" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['doctor_id'] }}</label>
            <select name="doctor_id" id="doctor_id" class="h-11 w-full rounded border border-border px-3 text-sm">
                <option value="">{{ $fieldLabels['doctor_none'] ?? '— بدون طبيب (تخصص فقط) —' }}</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" @selected(old('doctor_id', $appointment->doctor_id) == $doctor->id)>{{ $doctor->name }} — {{ $doctor->specialty }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="specialty" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['specialty'] ?? 'التخصص' }}</label>
            <input type="text" name="specialty" id="specialty" value="{{ old('specialty', $appointment->specialty) }}" class="h-11 w-full rounded border border-border px-3 text-sm">
        </div>
        <div>
            <label for="appointment_date" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['appointment_date'] }}</label>
            <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required class="h-11 w-full rounded border border-border px-3 text-sm">
        </div>
        <div>
            <label for="status" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['status'] }}</label>
            <select name="status" id="status" required class="h-11 w-full rounded border border-border px-3 text-sm">
                @foreach($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $appointment->status) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="notes" class="mb-1 block text-sm font-semibold">{{ $fieldLabels['notes'] }}</label>
            <textarea name="notes" id="notes" rows="4" class="w-full rounded border border-border px-3 py-2 text-sm">{{ old('notes', $appointment->notes) }}</textarea>
        </div>
        <button type="submit" class="rounded bg-primary px-6 py-2 font-semibold text-white hover:bg-primary-dark">{{ $saveLabel }}</button>
    </form>
@endsection
