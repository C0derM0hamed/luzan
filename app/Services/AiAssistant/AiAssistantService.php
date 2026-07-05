<?php

namespace App\Services\AiAssistant;

use App\Models\AiChatLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiAssistantService
{
    public function __construct(
        private AiSettingsService $settings,
        private ClinicContextBuilder $contextBuilder,
        private AiUsageTracker $usageTracker,
        private AiProviderFactory $providerFactory,
        private AiUsageRecorder $usageRecorder,
    ) {}

    /**
     * @param  array<int, array{role: string, content: string}>  $history
     * @return array{reply: string, session_id: string}
     */
    public function chat(string $message, array $history, string $sessionId, string $identifier, ?string $ipAddress): array
    {
        if (! $this->settings->isEnabled()) {
            throw new AiProviderException(
                'AI assistant is disabled',
                userMessage: 'المساعد الذكي غير متاح حالياً. يرجى التواصل مع العيادة مباشرة.',
                statusCode: 503,
                eligibleForFallback: false,
            );
        }

        $chain = $this->settings->getFallbackChain();

        if ($chain === []) {
            throw new AiProviderException(
                'No AI provider configured',
                userMessage: 'المساعد الذكي غير مهيأ حالياً. يرجى التواصل مع العيادة مباشرة.',
                statusCode: 503,
                eligibleForFallback: false,
            );
        }

        if (! $this->usageTracker->hasRemainingQuota($identifier)) {
            throw new AiProviderException(
                'Daily usage limit reached',
                userMessage: 'تم الوصول إلى الحد اليومي لاستخدام المساعد الذكي. يرجى المحاولة غداً أو التواصل مع العيادة.',
                statusCode: 429,
                eligibleForFallback: false,
            );
        }

        $sessionId = $sessionId !== '' ? $sessionId : (string) Str::uuid();
        $messages = $this->buildMessages($message, $history);
        $temperature = $this->settings->getTemperature();
        $maxTokens = $this->settings->getMaxTokens();

        $lastException = null;

        foreach ($chain as $providerName) {
            $apiKey = $this->settings->getProviderApiKey($providerName);

            if ($apiKey === null) {
                continue;
            }

            $model = $this->settings->getProviderModel($providerName);

            try {
                $provider = $this->providerFactory->make($providerName, $apiKey);
                $result = $provider->chat($messages, $model, $temperature, $maxTokens);

                $this->usageTracker->increment($identifier);
                $this->usageRecorder->record($result);

                if ($this->settings->isLoggingEnabled()) {
                    AiChatLog::query()->create([
                        'session_id' => $sessionId,
                        'ip_address' => $ipAddress,
                        'user_message' => $message,
                        'assistant_message' => $result['content'],
                        'model' => $result['provider'].':'.$result['model'],
                        'tokens_used' => $result['tokens_used'],
                        'status' => 'success',
                    ]);
                }

                if ($providerName !== $this->settings->getPrimaryProvider()) {
                    Log::info('AI assistant used fallback provider', [
                        'provider' => $providerName,
                        'model' => $result['model'],
                        'session_id' => $sessionId,
                    ]);
                }

                return [
                    'reply' => $result['content'],
                    'session_id' => $sessionId,
                ];
            } catch (AiProviderException $e) {
                $lastException = $e;

                Log::warning('AI provider attempt failed', [
                    'provider' => $providerName,
                    'message' => $e->getMessage(),
                    'session_id' => $sessionId,
                ]);
            }
        }

        if ($this->settings->isLoggingEnabled()) {
            AiChatLog::query()->create([
                'session_id' => $sessionId,
                'ip_address' => $ipAddress,
                'user_message' => $message,
                'assistant_message' => null,
                'model' => null,
                'status' => 'error',
                'error_message' => $lastException?->getMessage() ?? 'All providers failed',
            ]);
        }

        throw AiProviderException::allProvidersFailed();
    }

    /**
     * @param  array<int, array{role: string, content: string}>  $history
     * @return array<int, array{role: string, content: string}>
     */
    private function buildMessages(string $message, array $history): array
    {
        $systemContent = $this->settings->getSystemInstructions()
            ."\n\n--- سياق بيانات المجمع (المصدر الوحيد للمعلومات) ---\n\n"
            .$this->contextBuilder->build();

        $messages = [
            ['role' => 'system', 'content' => $systemContent],
        ];

        foreach ($history as $entry) {
            if (! isset($entry['role'], $entry['content'])) {
                continue;
            }

            if (! in_array($entry['role'], ['user', 'assistant'], true)) {
                continue;
            }

            $content = trim((string) $entry['content']);

            if ($content === '') {
                continue;
            }

            $messages[] = [
                'role' => $entry['role'],
                'content' => Str::limit($content, 2000, ''),
            ];
        }

        $messages[] = ['role' => 'user', 'content' => trim($message)];

        return $messages;
    }
}
