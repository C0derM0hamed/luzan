<?php

namespace App\Services\AiAssistant;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class OpenAiProvider implements AiProviderInterface
{
    private const API_URL = 'https://api.openai.com/v1/chat/completions';

    private const MODELS_URL = 'https://api.openai.com/v1/models';

    public function __construct(private readonly string $apiKey) {}

    public function name(): string
    {
        return AiProviderRegistry::OPENAI;
    }

    public function chat(array $messages, string $model, float $temperature, int $maxTokens): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->apiKey,
                'Content-Type' => 'application/json',
            ])
                ->timeout(45)
                ->connectTimeout(10)
                ->post(self::API_URL, [
                    'model' => $model,
                    'messages' => $messages,
                    'temperature' => $temperature,
                    'max_tokens' => $maxTokens,
                ]);
        } catch (\Throwable $e) {
            throw new AiProviderException(
                'OpenAI connection failed: '.$e->getMessage(),
                statusCode: 503,
                provider: $this->name(),
            );
        }

        return $this->parseResponse($response, $model);
    }

    public function validateApiKey(string $apiKey, string $model): void
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$apiKey,
            ])
                ->timeout(20)
                ->connectTimeout(10)
                ->get(self::MODELS_URL);
        } catch (\Throwable $e) {
            throw new AiProviderException(
                'OpenAI validation connection failed: '.$e->getMessage(),
                userMessage: 'تعذر التحقق من مفتاح OpenAI. يرجى التحقق من الاتصال بالإنترنت.',
                statusCode: 422,
                eligibleForFallback: false,
                provider: $this->name(),
            );
        }

        if ($response->status() === 401) {
            throw new AiProviderException(
                'Invalid OpenAI API key',
                userMessage: 'مفتاح OpenAI غير صالح. يرجى التحقق من المفتاح وإعادة المحاولة.',
                statusCode: 422,
                eligibleForFallback: false,
                provider: $this->name(),
            );
        }

        if (! $response->successful()) {
            throw new AiProviderException(
                'OpenAI validation failed: '.$response->body(),
                userMessage: 'فشل التحقق من مفتاح OpenAI. يرجى التأكد من صحة المفتاح.',
                statusCode: 422,
                eligibleForFallback: false,
                provider: $this->name(),
            );
        }
    }

    /**
     * @param  Response  $response
     * @return array{content: string, tokens_used: ?int, model: string, provider: string}
     */
    private function parseResponse($response, string $model): array
    {
        if ($response->status() === 401) {
            throw new AiProviderException(
                'Invalid OpenAI API key',
                statusCode: 503,
                provider: $this->name(),
            );
        }

        if ($response->status() === 429) {
            throw new AiProviderException(
                'OpenAI rate limit exceeded',
                statusCode: 429,
                provider: $this->name(),
            );
        }

        if (! $response->successful()) {
            throw new AiProviderException(
                'OpenAI API error: '.$response->body(),
                statusCode: 502,
                provider: $this->name(),
            );
        }

        $data = $response->json();
        $content = $data['choices'][0]['message']['content'] ?? null;

        if (! is_string($content) || trim($content) === '') {
            throw new AiProviderException(
                'Empty OpenAI response',
                userMessage: 'عذراً، لم أتمكن من توليد رد مناسب. يرجى إعادة صياغة سؤالك.',
                provider: $this->name(),
            );
        }

        return [
            'content' => trim($content),
            'tokens_used' => $data['usage']['total_tokens'] ?? null,
            'model' => $data['model'] ?? $model,
            'provider' => $this->name(),
        ];
    }
}
