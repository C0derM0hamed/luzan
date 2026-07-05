<?php

namespace App\Services\AiAssistant;

class AiProviderFactory
{
    public function make(string $provider, string $apiKey): AiProviderInterface
    {
        return match ($provider) {
            AiProviderRegistry::GEMINI => new GeminiProvider($apiKey),
            AiProviderRegistry::OPENROUTER => new OpenRouterProvider($apiKey),
            AiProviderRegistry::OPENAI => new OpenAiProvider($apiKey),
            default => throw new \InvalidArgumentException("Unknown AI provider: {$provider}"),
        };
    }
}
