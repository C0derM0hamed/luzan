<?php

namespace App\Services\AiAssistant;

interface AiProviderInterface
{
    public function name(): string;

    /**
     * @param  array<int, array{role: string, content: string}>  $messages
     * @return array{content: string, tokens_used: ?int, model: string, provider: string}
     *
     * @throws AiProviderException
     */
    public function chat(array $messages, string $model, float $temperature, int $maxTokens): array;

    /**
     * @throws AiProviderException
     */
    public function validateApiKey(string $apiKey, string $model): void;
}
