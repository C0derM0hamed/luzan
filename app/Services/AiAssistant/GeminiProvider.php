<?php

namespace App\Services\AiAssistant;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GeminiProvider implements AiProviderInterface
{
    private const BASE_URL = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct(private readonly string $apiKey)
    {
    }

    public function name(): string
    {
        return AiProviderRegistry::GEMINI;
    }

    public function chat(array $messages, string $model, float $temperature, int $maxTokens): array
    {
        $payload = $this->buildPayload($messages, $temperature, $maxTokens);

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->retry(2, 300, function (\Throwable $exception, \Illuminate\Http\Client\Request $request) {
                    if ($exception instanceof \Illuminate\Http\Client\ConnectionException)
                        return true;
                    return false;
                })
                ->timeout(45)
                ->connectTimeout(10)
                ->post(self::BASE_URL . '/models/' . urlencode($model) . ':generateContent?key=' . urlencode($this->apiKey), $payload);
        } catch (\Throwable $e) {
            throw new AiProviderException(
                'Gemini connection failed: ' . $e->getMessage(),
                statusCode: 503,
                provider: $this->name(),
            );
        }

        return $this->parseResponse($response, $model);
    }

    public function validateApiKey(string $apiKey, string $model): void
    {
        try {
            $response = Http::timeout(20)
                ->connectTimeout(10)
                ->get(self::BASE_URL . '/models/' . urlencode($model), ['key' => $apiKey]);
        } catch (\Throwable $e) {
            throw new AiProviderException(
                'Gemini validation connection failed: ' . $e->getMessage(),
                userMessage: 'تعذر التحقق من مفتاح Gemini. يرجى التحقق من الاتصال بالإنترنت.',
                statusCode: 422,
                eligibleForFallback: false,
                provider: $this->name(),
            );
        }

        if ($response->status() === 400 || $response->status() === 403) {
            throw new AiProviderException(
                'Invalid Gemini API key',
                userMessage: 'مفتاح Google Gemini غير صالح. يرجى التحقق من المفتاح وإعادة المحاولة.',
                statusCode: 422,
                eligibleForFallback: false,
                provider: $this->name(),
            );
        }

        if ($response->status() === 404) {
            throw new AiProviderException(
                'Gemini model not found',
                userMessage: 'نموذج Gemini المحدد غير متاح. يرجى اختيار نموذج آخر.',
                statusCode: 422,
                eligibleForFallback: false,
                provider: $this->name(),
            );
        }

        if (!$response->successful()) {
            throw new AiProviderException(
                'Gemini validation failed: ' . $response->body(),
                userMessage: 'فشل التحقق من مفتاح Gemini. يرجى التأكد من صحة المفتاح والنموذج.',
                statusCode: 422,
                eligibleForFallback: false,
                provider: $this->name(),
            );
        }
    }

    /**
     * @param  array<int, array{role: string, content: string}>  $messages
     * @return array<string, mixed>
     */
    private function buildPayload(array $messages, float $temperature, int $maxTokens): array
    {
        $systemInstruction = null;
        $contents = [];

        foreach ($messages as $message) {
            if ($message['role'] === 'system') {
                $systemInstruction = ['parts' => [['text' => $message['content']]]];

                continue;
            }

            $role = $message['role'] === 'assistant' ? 'model' : 'user';
            $contents[] = [
                'role' => $role,
                'parts' => [['text' => $message['content']]],
            ];
        }

        $payload = [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => $temperature,
                'maxOutputTokens' => $maxTokens,
            ],
        ];

        if ($systemInstruction !== null) {
            $payload['systemInstruction'] = $systemInstruction;
        }

        return $payload;
    }

    /**
     * @param  Response  $response
     * @return array{content: string, tokens_used: ?int, model: string, provider: string}
     */
    private function parseResponse($response, string $model): array
    {
        if (in_array($response->status(), [400, 401, 403], true)) {
            throw new AiProviderException(
                'Invalid Gemini API key or request',
                statusCode: 503,
                provider: $this->name(),
            );
        }

        if ($response->status() === 429) {
            throw new AiProviderException(
                'Gemini rate limit exceeded',
                statusCode: 429,
                provider: $this->name(),
            );
        }

        if (!$response->successful()) {
            throw new AiProviderException(
                'Gemini API error: ' . $response->body(),
                statusCode: 502,
                provider: $this->name(),
            );
        }

        $data = $response->json();
        $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!is_string($content) || trim($content) === '') {
            throw new AiProviderException(
                'Empty Gemini response',
                userMessage: 'عذراً، لم أتمكن من توليد رد مناسب. يرجى إعادة صياغة سؤالك.',
                provider: $this->name(),
            );
        }

        $tokens = null;
        if (isset($data['usageMetadata']['totalTokenCount'])) {
            $tokens = (int) $data['usageMetadata']['totalTokenCount'];
        }

        return [
            'content' => trim($content),
            'tokens_used' => $tokens,
            'model' => $model,
            'provider' => $this->name(),
        ];
    }
}
