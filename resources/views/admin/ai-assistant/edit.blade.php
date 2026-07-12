@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="rounded-xl border border-primary/20 bg-gradient-to-l from-primary/5 to-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-[#222]">المساعد الذكي للمرضى</h2>
                    <p class="mt-1 text-sm text-muted">إدارة المساعد الذكي مع دعم متعدد المزودين والتبديل التلقائي عند فشل أي مزود.</p>
                </div>
                <div class="flex flex-col gap-2 sm:items-end">
                    <a href="{{ route('admin.ai-assistant.analytics') }}" class="inline-flex items-center gap-2 rounded-lg border border-border bg-white px-4 py-2 text-sm font-semibold text-primary hover:bg-primary/5 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        إحصائيات الاستخدام
                    </a>
                    <div class="rounded-xl border border-border bg-white px-4 py-3 text-sm">
                        <span class="text-muted">استخدام اليوم:</span>
                        <span class="mr-1 font-bold text-primary">{{ $todayUsage }}</span>
                        <span class="text-muted">/ {{ $dailyLimit }}</span>
                    </div>
                </div>
            </div>
            <p class="mt-3 text-xs text-muted">
                ترتيب التبديل التلقائي:
                @foreach($fallbackOrder as $index => $provider)
                    <span class="font-semibold text-primary-dark">{{ $providerDefinitions[$provider]['label'] }}</span>@if($index < count($fallbackOrder) - 1)<span class="mx-1">←</span>@endif
                @endforeach
            </p>
        </div>

        <form action="{{ route('admin.ai-assistant.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <fieldset class="rounded-xl border border-border bg-white p-6 shadow-sm">
                <legend class="px-2 text-lg font-bold text-[#222]">التفعيل والإعدادات العامة</legend>
                <div class="mt-4 space-y-5">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="ai_enabled" value="0">
                        <input type="checkbox" name="ai_enabled" value="1" class="h-5 w-5 rounded border-border text-primary focus:ring-primary/30" @checked(old('ai_enabled', $settings['ai_enabled']))>
                        <span class="text-sm font-semibold">تفعيل المساعد الذكي على الموقع</span>
                    </label>

                    <div>
                        <label for="ai_provider" class="mb-1 block text-sm font-semibold">المزود الأساسي</label>
                        <select name="ai_provider" id="ai_provider" class="h-11 w-full rounded border border-border px-3 text-sm">
                            @foreach($providerDefinitions as $key => $definition)
                                <option value="{{ $key }}" @selected(old('ai_provider', $settings['ai_provider']) === $key)>
                                    {{ $definition['label'] }}
                                    @if($definition['free_tier']) (مجاني) @endif
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-muted">يُستخدم Google Gemini افتراضياً لتوفره المجاني. يتم التبديل تلقائياً للمزود التالي عند الفشل.</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="ai_temperature" class="mb-1 block text-sm font-semibold">Temperature</label>
                            <input type="number" name="ai_temperature" id="ai_temperature" min="0" max="1" step="0.1" value="{{ old('ai_temperature', $settings['ai_temperature']) }}" class="h-11 w-full rounded border border-border px-3 text-sm" dir="ltr">
                            <p class="mt-1 text-xs text-muted">0 = دقيق، 1 = إبداعي. يُنصح بـ 0.3 للإجابات الطبية.</p>
                        </div>
                        <div>
                            <label for="ai_max_tokens" class="mb-1 block text-sm font-semibold">Max Tokens</label>
                            <input type="number" name="ai_max_tokens" id="ai_max_tokens" min="100" max="8000" value="{{ old('ai_max_tokens', $settings['ai_max_tokens']) }}" class="h-11 w-full rounded border border-border px-3 text-sm" dir="ltr">
                        </div>
                    </div>
                </div>
            </fieldset>

            @foreach($providerDefinitions as $providerKey => $definition)
                @php
                    $providerSettings = $settings['providers'][$providerKey];
                    $apiKeyField = "ai_{$providerKey}_api_key";
                    $modelField = "ai_{$providerKey}_model";
                    $enabledField = "ai_{$providerKey}_enabled";
                @endphp
                <fieldset class="rounded-xl border border-border bg-white p-6 shadow-sm">
                    <legend class="px-2 text-lg font-bold text-[#222]">
                        {{ $definition['label'] }}
                        @if($definition['free_tier'])
                            <span class="mr-2 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">مجاني</span>
                        @endif
                    </legend>
                    <div class="mt-4 space-y-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="hidden" name="{{ $enabledField }}" value="0">
                            <input type="checkbox" name="{{ $enabledField }}" value="1" class="h-5 w-5 rounded border-border text-primary focus:ring-primary/30" @checked(old($enabledField, $providerSettings['enabled']))>
                            <span class="text-sm font-semibold">تفعيل هذا المزود (يشمل التبديل التلقائي)</span>
                        </label>

                        <div>
                            <label for="{{ $apiKeyField }}" class="mb-1 block text-sm font-semibold">مفتاح API — {{ $definition['label'] }}</label>
                            <input
                                type="text"
                                name="{{ $apiKeyField }}"
                                id="{{ $apiKeyField }}"
                                autocomplete="off"
                                value="{{ old($apiKeyField, $providerSettings['api_key']) }}"
                                placeholder="{{ $definition['key_placeholder'] }}"
                                class="h-11 w-full rounded border px-3 text-sm font-mono @error($apiKeyField) border-red-400 @else border-border @enderror"
                                dir="ltr"
                            >
                            @error($apiKeyField)
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @elseif($providerSettings['has_api_key'])
                                <p class="mt-1 flex items-center gap-1 text-xs text-emerald-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    تم تعيين مفتاح API — يُتحقق منه قبل الحفظ
                                </p>
                            @else
                                <p class="mt-1 text-xs text-muted">يُتحقق من صحة المفتاح قبل الحفظ.</p>
                            @endif
                        </div>

                        <div>
                            <label for="{{ $modelField }}" class="mb-1 block text-sm font-semibold">النموذج — {{ $definition['label'] }}</label>
                            <input
                                type="text"
                                name="{{ $modelField }}"
                                id="{{ $modelField }}"
                                list="{{ $modelField }}_suggestions"
                                value="{{ old($modelField, $providerSettings['model']) }}"
                                class="h-11 w-full rounded border border-border px-3 text-sm font-mono"
                                dir="ltr"
                                required
                            >
                            <datalist id="{{ $modelField }}_suggestions">
                                @foreach($definition['models'] as $model)
                                    <option value="{{ $model }}"></option>
                                @endforeach
                            </datalist>
                            <p class="mt-1 text-xs text-muted">يمكنك اختيار نموذج مقترح أو كتابة اسم نموذج مخصص.</p>
                        </div>
                    </div>
                </fieldset>
            @endforeach

            <fieldset class="rounded-xl border border-border bg-white p-6 shadow-sm">
                <legend class="px-2 text-lg font-bold text-[#222]">الشخصية والرسائل</legend>
                <div class="mt-4 space-y-4">
                    <div>
                        <label for="ai_system_instructions" class="mb-1 block text-sm font-semibold">تعليمات المساعد (System Prompt)</label>
                        <textarea name="ai_system_instructions" id="ai_system_instructions" rows="8" class="w-full rounded border border-border px-3 py-2 text-sm leading-relaxed">{{ old('ai_system_instructions', $settings['ai_system_instructions']) }}</textarea>
                        <p class="mt-1 text-xs text-muted">يحدد شخصية المساعد وقواعد الإجابة. يُضاف تلقائياً سياق بيانات المجمع.</p>
                    </div>

                    <div>
                        <label for="ai_welcome_message" class="mb-1 block text-sm font-semibold">رسالة الترحيب</label>
                        <textarea name="ai_welcome_message" id="ai_welcome_message" rows="6" class="w-full rounded border border-border px-3 py-2 text-sm leading-relaxed">{{ old('ai_welcome_message', $settings['ai_welcome_message']) }}</textarea>
                    </div>
                </div>
            </fieldset>

            <fieldset class="rounded-xl border border-border bg-white p-6 shadow-sm">
                <legend class="px-2 text-lg font-bold text-[#222]">الحدود والخصوصية</legend>
                <div class="mt-4 space-y-5">
                    <div>
                        <label for="ai_daily_limit" class="mb-1 block text-sm font-semibold">الحد اليومي للرسائل (لكل زائر)</label>
                        <input type="number" name="ai_daily_limit" id="ai_daily_limit" min="1" max="10000" value="{{ old('ai_daily_limit', $settings['ai_daily_limit']) }}" class="h-11 w-full max-w-xs rounded border border-border px-3 text-sm" dir="ltr">
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="ai_chat_history_enabled" value="0">
                        <input type="checkbox" name="ai_chat_history_enabled" value="1" class="h-5 w-5 rounded border-border text-primary focus:ring-primary/30" @checked(old('ai_chat_history_enabled', $settings['ai_chat_history_enabled']))>
                        <span class="text-sm font-semibold">السماح بسجل المحادثة خلال الجلسة</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="ai_logging_enabled" value="0">
                        <input type="checkbox" name="ai_logging_enabled" value="1" class="h-5 w-5 rounded border-border text-primary focus:ring-primary/30" @checked(old('ai_logging_enabled', $settings['ai_logging_enabled']))>
                        <span class="text-sm font-semibold">تفعيل تسجيل المحادثات (Logging)</span>
                    </label>
                </div>
            </fieldset>

            <button type="submit" class="rounded bg-primary px-6 py-2.5 font-semibold text-white hover:bg-primary-dark transition">{{ $saveLabel }}</button>
        </form>

        @if($recentLogs->isNotEmpty())
            <div class="rounded-xl border border-border bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-[#222] mb-4">آخر المحادثات المسجلة</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right">
                        <thead>
                            <tr class="border-b border-border text-muted">
                                <th class="py-2 px-3 font-semibold">التاريخ</th>
                                <th class="py-2 px-3 font-semibold">رسالة المستخدم</th>
                                <th class="py-2 px-3 font-semibold">المزود / النموذج</th>
                                <th class="py-2 px-3 font-semibold">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentLogs as $log)
                                <tr class="border-b border-border/60">
                                    <td class="py-3 px-3 whitespace-nowrap text-xs text-muted">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="py-3 px-3 max-w-xs truncate">{{ Str::limit($log->user_message, 80) }}</td>
                                    <td class="py-3 px-3 text-xs font-mono" dir="ltr">{{ $log->model ?? '—' }}</td>
                                    <td class="py-3 px-3">
                                        @if($log->status === 'success')
                                            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">نجاح</span>
                                        @else
                                            <span class="rounded-full bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-700">خطأ</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
