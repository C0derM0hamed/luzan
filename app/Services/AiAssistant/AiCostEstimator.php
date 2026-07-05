<?php

namespace App\Services\AiAssistant;

class AiCostEstimator
{
    /**
     * Estimated USD cost per 1M tokens (blended input/output average).
     * Returns null when cost cannot be estimated.
     */
    public function estimatePerTokenUsd(string $provider, string $model): ?float
    {
        if (str_contains($model, ':free')) {
            return 0.0;
        }

        return match ($provider) {
            AiProviderRegistry::GEMINI => $this->geminiRate($model),
            AiProviderRegistry::OPENROUTER => $this->openRouterRate($model),
            AiProviderRegistry::OPENAI => $this->openAiRate($model),
            default => null,
        };
    }

    public function estimate(string $provider, string $model, ?int $tokens): ?float
    {
        if ($tokens === null || $tokens <= 0) {
            return null;
        }

        $ratePerToken = $this->estimatePerTokenUsd($provider, $model);

        if ($ratePerToken === null) {
            return null;
        }

        return round($ratePerToken * $tokens, 6);
    }

    private function geminiRate(string $model): float
    {
        if (str_contains($model, 'flash') || str_contains($model, '1.5')) {
            return 0.0;
        }

        return 2.50 / 1_000_000;
    }

    private function openRouterRate(string $model): ?float
    {
        if (str_starts_with($model, 'openai/')) {
            return $this->openAiRate(str_replace('openai/', '', $model));
        }

        if (str_starts_with($model, 'google/')) {
            return 0.0;
        }

        if (str_starts_with($model, 'meta-llama/')) {
            return 0.0;
        }

        return null;
    }

    private function openAiRate(string $model): ?float
    {
        return match (true) {
            str_contains($model, '4o-mini'), str_contains($model, '4.1-mini') => 0.60 / 1_000_000,
            str_contains($model, '4o'), str_contains($model, '4.1') => 5.00 / 1_000_000,
            str_contains($model, '3.5') => 1.50 / 1_000_000,
            default => null,
        };
    }
}
