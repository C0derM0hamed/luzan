<?php

namespace App\Services\AiAssistant;

use App\Models\AiUsageRecord;

class AiUsageRecorder
{
    public function __construct(private AiCostEstimator $costEstimator) {}

    /**
     * @param  array{content: string, tokens_used: ?int, model: string, provider: string}  $result
     */
    public function record(array $result): void
    {
        $tokens = $result['tokens_used'] ?? null;
        $provider = $result['provider'];
        $model = $result['model'];

        AiUsageRecord::query()->create([
            'provider' => $provider,
            'model' => $model,
            'tokens_used' => $tokens,
            'estimated_cost' => $this->costEstimator->estimate($provider, $model, $tokens),
            'status' => 'success',
        ]);
    }
}
