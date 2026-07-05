<?php

namespace App\Services\AiAssistant;

class AiProviderRegistry
{
    public const GEMINI = 'gemini';

    public const OPENROUTER = 'openrouter';

    public const OPENAI = 'openai';

    /** @return list<string> */
    public static function all(): array
    {
        return [self::GEMINI, self::OPENROUTER, self::OPENAI];
    }

    /** @return list<string> */
    public static function fallbackOrder(): array
    {
        return [self::GEMINI, self::OPENROUTER, self::OPENAI];
    }

    public static function label(string $provider): string
    {
        return self::definition($provider)['label'];
    }

    public static function defaultModel(string $provider): string
    {
        return self::definition($provider)['default_model'];
    }

    /** @return list<string> */
    public static function suggestedModels(string $provider): array
    {
        return self::definition($provider)['models'];
    }

    public static function apiKeyPlaceholder(string $provider): string
    {
        return self::definition($provider)['key_placeholder'];
    }

    public static function isValid(string $provider): bool
    {
        return in_array($provider, self::all(), true);
    }

    /**
     * @return array{label: string, default_model: string, models: list<string>, key_placeholder: string, free_tier: bool}
     */
    public static function definition(string $provider): array
    {
        return match ($provider) {
            self::GEMINI => [
                'label' => 'Google Gemini',
                'default_model' => 'gemini-2.0-flash',
                'models' => [
                    'gemini-2.0-flash',
                    'gemini-2.5-flash-preview-05-20',
                    'gemini-1.5-flash',
                ],
                'key_placeholder' => 'AIza...',
                'free_tier' => true,
            ],
            self::OPENROUTER => [
                'label' => 'OpenRouter',
                'default_model' => 'google/gemini-2.0-flash-exp:free',
                'models' => [
                    'google/gemini-2.0-flash-exp:free',
                    'meta-llama/llama-3.3-70b-instruct:free',
                    'openai/gpt-4o-mini',
                    'anthropic/claude-3.5-haiku',
                ],
                'key_placeholder' => 'sk-or-...',
                'free_tier' => true,
            ],
            self::OPENAI => [
                'label' => 'OpenAI',
                'default_model' => 'gpt-4o-mini',
                'models' => [
                    'gpt-4o-mini',
                    'gpt-4o',
                    'gpt-4.1-mini',
                    'gpt-4.1',
                ],
                'key_placeholder' => 'sk-...',
                'free_tier' => false,
            ],
            default => throw new \InvalidArgumentException("Unknown AI provider: {$provider}"),
        };
    }

    /**
     * @return array<string, array{label: string, default_model: string, models: list<string>, key_placeholder: string, free_tier: bool}>
     */
    public static function definitions(): array
    {
        $definitions = [];

        foreach (self::all() as $provider) {
            $definitions[$provider] = self::definition($provider);
        }

        return $definitions;
    }
}
