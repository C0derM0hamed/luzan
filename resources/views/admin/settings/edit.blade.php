@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-3xl space-y-8">
        @csrf
        @method('PUT')

        @foreach($settingGroups as $group)
            <fieldset class="rounded-xl border border-border bg-white p-6 shadow-sm">
                <legend class="px-2 text-lg font-bold text-[#222]">{{ $group['title'] }}</legend>
                <div class="mt-4 space-y-4">
                    @foreach($group['fields'] as $field)
                        <div>
                            <label for="settings_{{ $field['key'] }}" class="mb-1 block text-sm font-semibold">{{ $field['label'] }}</label>
                            @if(($field['type'] ?? 'text') === 'textarea')
                                <textarea name="settings[{{ $field['key'] }}]" id="settings_{{ $field['key'] }}" rows="{{ $field['rows'] ?? 3 }}" class="w-full rounded border border-border px-3 py-2 text-sm" @if(!empty($field['dir'])) dir="{{ $field['dir'] }}" @endif>{{ old('settings.' . $field['key'], $settings[$field['key']] ?? '') }}</textarea>
                            @else
                                <input type="{{ $field['type'] ?? 'text' }}" name="settings[{{ $field['key'] }}]" id="settings_{{ $field['key'] }}" value="{{ old('settings.' . $field['key'], $settings[$field['key']] ?? '') }}" class="h-11 w-full rounded border border-border px-3 text-sm" @if(!empty($field['dir'])) dir="{{ $field['dir'] }}" @endif>
                            @endif
                            @if(!empty($field['hint']))
                                <p class="mt-1 text-xs text-muted">{{ $field['hint'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </fieldset>
        @endforeach

        <button type="submit" class="rounded bg-primary px-6 py-2 font-semibold text-white hover:bg-primary-dark">{{ $saveLabel }}</button>
    </form>
@endsection
