<?php

namespace App\Services\AiAssistant;

use App\Models\AiChatUsage;
use Carbon\Carbon;

class AiUsageTracker
{
    public function __construct(private AiSettingsService $settings) {}

    public function hasRemainingQuota(string $identifier): bool
    {
        return $this->getRemainingQuota($identifier) > 0;
    }

    public function getRemainingQuota(string $identifier): int
    {
        $limit = $this->settings->getDailyLimit();
        $used = $this->getTodayCount($identifier);

        return max(0, $limit - $used);
    }

    public function increment(string $identifier): void
    {
        $today = Carbon::today()->toDateString();

        $usage = AiChatUsage::query()
            ->whereDate('usage_date', $today)
            ->where('identifier', $identifier)
            ->first();

        if ($usage) {
            $usage->increment('message_count');

            return;
        }

        AiChatUsage::query()->create([
            'usage_date' => $today,
            'identifier' => $identifier,
            'message_count' => 1,
        ]);
    }

    public function getTodayCount(string $identifier): int
    {
        return (int) AiChatUsage::query()
            ->whereDate('usage_date', Carbon::today())
            ->where('identifier', $identifier)
            ->value('message_count');
    }

    public function getTodayTotalCount(): int
    {
        return (int) AiChatUsage::query()
            ->whereDate('usage_date', Carbon::today())
            ->sum('message_count');
    }
}
