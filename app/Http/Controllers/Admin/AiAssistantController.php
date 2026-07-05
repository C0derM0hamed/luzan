<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiChatLog;
use App\Services\AiAssistant\AiApiKeyValidator;
use App\Services\AiAssistant\AiProviderException;
use App\Services\AiAssistant\AiProviderRegistry;
use App\Services\AiAssistant\AiSettingsService;
use App\Services\AiAssistant\AiUsageTracker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AiAssistantController extends Controller
{
    public function edit(AiSettingsService $settings, AiUsageTracker $usageTracker)
    {
        $recentLogs = collect();

        if ($settings->isLoggingEnabled()) {
            $recentLogs = AiChatLog::query()
                ->latest()
                ->limit(10)
                ->get();
        }

        return view('admin.ai-assistant.edit', [
            'pageTitle' => 'المساعد الذكي',
            'settings' => $settings->getAdminFormData(),
            'providerDefinitions' => AiProviderRegistry::definitions(),
            'fallbackOrder' => AiProviderRegistry::fallbackOrder(),
            'todayUsage' => $usageTracker->getTodayTotalCount(),
            'dailyLimit' => $settings->getDailyLimit(),
            'recentLogs' => $recentLogs,
        ]);
    }

    public function update(Request $request, AiSettingsService $settings, AiApiKeyValidator $keyValidator)
    {
        $data = $request->validate([
            'ai_enabled' => ['nullable', 'boolean'],
            'ai_provider' => ['required', Rule::in(AiProviderRegistry::all())],
            'ai_temperature' => ['required', 'numeric', 'min:0', 'max:1'],
            'ai_max_tokens' => ['required', 'integer', 'min:100', 'max:4000'],
            'ai_system_instructions' => ['nullable', 'string', 'max:10000'],
            'ai_welcome_message' => ['nullable', 'string', 'max:5000'],
            'ai_daily_limit' => ['required', 'integer', 'min:1', 'max:10000'],
            'ai_chat_history_enabled' => ['nullable', 'boolean'],
            'ai_logging_enabled' => ['nullable', 'boolean'],
            'ai_gemini_enabled' => ['nullable', 'boolean'],
            'ai_openrouter_enabled' => ['nullable', 'boolean'],
            'ai_openai_enabled' => ['nullable', 'boolean'],
            'ai_gemini_api_key' => ['nullable', 'string', 'max:255'],
            'ai_openrouter_api_key' => ['nullable', 'string', 'max:255'],
            'ai_openai_api_key' => ['nullable', 'string', 'max:255'],
            'ai_gemini_model' => ['required', 'string', 'max:150'],
            'ai_openrouter_model' => ['required', 'string', 'max:150'],
            'ai_openai_model' => ['required', 'string', 'max:150'],
        ], [
            'ai_provider.required' => 'يرجى اختيار مزود الذكاء الاصطناعي الأساسي.',
            'ai_provider.in' => 'مزود الذكاء الاصطناعي غير صالح.',
            'ai_temperature.required' => 'يرجى تحديد درجة الحرارة (Temperature).',
            'ai_max_tokens.required' => 'يرجى تحديد الحد الأقصى للرموز.',
            'ai_daily_limit.required' => 'يرجى تحديد الحد اليومي.',
        ]);

        $validationErrors = [];

        foreach (AiProviderRegistry::all() as $provider) {
            $newKey = trim((string) ($data["ai_{$provider}_api_key"] ?? ''));

            if ($newKey === '') {
                continue;
            }

            try {
                $keyValidator->validate(
                    $provider,
                    $newKey,
                    $data["ai_{$provider}_model"],
                );
            } catch (AiProviderException $e) {
                $validationErrors["ai_{$provider}_api_key"] = $e->userMessage;
            }
        }

        $primaryProvider = $data['ai_provider'];
        $primaryHasExistingKey = $settings->hasProviderApiKey($primaryProvider);
        $primaryNewKey = trim((string) ($data["ai_{$primaryProvider}_api_key"] ?? ''));

        if ($request->boolean('ai_enabled') && ! $primaryHasExistingKey && $primaryNewKey === '') {
            $validationErrors["ai_{$primaryProvider}_api_key"] = 'مفتاح API مطلوب للمزود الأساسي عند تفعيل المساعد.';
        }

        if ($validationErrors !== []) {
            return back()
                ->withInput()
                ->withErrors($validationErrors);
        }

        $settings->updateFromAdmin([
            'ai_enabled' => $request->boolean('ai_enabled'),
            'ai_provider' => $data['ai_provider'],
            'ai_temperature' => $data['ai_temperature'],
            'ai_max_tokens' => $data['ai_max_tokens'],
            'ai_system_instructions' => $data['ai_system_instructions'] ?? '',
            'ai_welcome_message' => $data['ai_welcome_message'] ?? '',
            'ai_daily_limit' => $data['ai_daily_limit'],
            'ai_chat_history_enabled' => $request->boolean('ai_chat_history_enabled'),
            'ai_logging_enabled' => $request->boolean('ai_logging_enabled'),
            'ai_gemini_enabled' => $request->boolean('ai_gemini_enabled'),
            'ai_openrouter_enabled' => $request->boolean('ai_openrouter_enabled'),
            'ai_openai_enabled' => $request->boolean('ai_openai_enabled'),
            'ai_gemini_api_key' => $data['ai_gemini_api_key'] ?? null,
            'ai_openrouter_api_key' => $data['ai_openrouter_api_key'] ?? null,
            'ai_openai_api_key' => $data['ai_openai_api_key'] ?? null,
            'ai_gemini_model' => $data['ai_gemini_model'],
            'ai_openrouter_model' => $data['ai_openrouter_model'],
            'ai_openai_model' => $data['ai_openai_model'],
        ]);

        return redirect()
            ->route('admin.ai-assistant.edit')
            ->with('success', 'تم حفظ إعدادات المساعد الذكي بنجاح.');
    }
}
