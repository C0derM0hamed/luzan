<?php

namespace App\Services\AiAssistant;

use App\Models\AiUsageRecord;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AiUsageAnalyticsService
{
    /**
     * @return array<string, mixed>
     */
    public function getDashboardData(): array
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();

        return [
            'summary' => $this->summary(),
            'today' => $this->periodSummary($today, Carbon::now()),
            'month' => $this->periodSummary($monthStart, Carbon::now()),
            'byProvider' => $this->byProvider(),
            'byModel' => $this->byModel(),
            'dailyUsage' => $this->dailyUsage(30),
            'monthlyUsage' => $this->monthlyUsage(12),
        ];
    }

    /**
     * @return array{total_requests: int, total_tokens: int, estimated_cost: ?float, has_cost_data: bool}
     */
    private function summary(): array
    {
        $row = AiUsageRecord::query()
            ->where('status', 'success')
            ->selectRaw('COUNT(*) as total_requests')
            ->selectRaw('COALESCE(SUM(tokens_used), 0) as total_tokens')
            ->selectRaw('SUM(CASE WHEN estimated_cost IS NOT NULL THEN 1 ELSE 0 END) as cost_rows')
            ->selectRaw('SUM(estimated_cost) as estimated_cost')
            ->first();

        $costRows = (int) ($row->cost_rows ?? 0);
        $totalRequests = (int) ($row->total_requests ?? 0);

        return [
            'total_requests' => $totalRequests,
            'total_tokens' => (int) ($row->total_tokens ?? 0),
            'estimated_cost' => $costRows > 0 ? (float) ($row->estimated_cost ?? 0) : null,
            'has_cost_data' => $costRows > 0,
        ];
    }

    /**
     * @return array{requests: int, tokens: int, estimated_cost: ?float, has_cost_data: bool}
     */
    private function periodSummary(Carbon $from, Carbon $to): array
    {
        $row = AiUsageRecord::query()
            ->where('status', 'success')
            ->whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->selectRaw('COUNT(*) as total_requests')
            ->selectRaw('COALESCE(SUM(tokens_used), 0) as total_tokens')
            ->selectRaw('SUM(CASE WHEN estimated_cost IS NOT NULL THEN 1 ELSE 0 END) as cost_rows')
            ->selectRaw('SUM(estimated_cost) as estimated_cost')
            ->first();

        $costRows = (int) ($row->cost_rows ?? 0);

        return [
            'requests' => (int) ($row->total_requests ?? 0),
            'tokens' => (int) ($row->total_tokens ?? 0),
            'estimated_cost' => $costRows > 0 ? (float) ($row->estimated_cost ?? 0) : null,
            'has_cost_data' => $costRows > 0,
        ];
    }

    /**
     * @return Collection<int, object{provider: string, requests: int, tokens: int, estimated_cost: ?float}>
     */
    private function byProvider(): Collection
    {
        return AiUsageRecord::query()
            ->where('status', 'success')
            ->select('provider')
            ->selectRaw('COUNT(*) as requests')
            ->selectRaw('COALESCE(SUM(tokens_used), 0) as tokens')
            ->selectRaw('SUM(estimated_cost) as estimated_cost')
            ->groupBy('provider')
            ->orderByDesc('requests')
            ->get()
            ->map(fn ($row) => (object) [
                'provider' => $row->provider,
                'provider_label' => AiProviderRegistry::label($row->provider),
                'requests' => (int) $row->requests,
                'tokens' => (int) $row->tokens,
                'estimated_cost' => $row->estimated_cost !== null ? (float) $row->estimated_cost : null,
            ]);
    }

    /**
     * @return Collection<int, object{provider: string, model: string, requests: int, tokens: int, estimated_cost: ?float}>
     */
    private function byModel(): Collection
    {
        return AiUsageRecord::query()
            ->where('status', 'success')
            ->select('provider', 'model')
            ->selectRaw('COUNT(*) as requests')
            ->selectRaw('COALESCE(SUM(tokens_used), 0) as tokens')
            ->selectRaw('SUM(estimated_cost) as estimated_cost')
            ->groupBy('provider', 'model')
            ->orderByDesc('requests')
            ->limit(20)
            ->get()
            ->map(fn ($row) => (object) [
                'provider' => $row->provider,
                'provider_label' => AiProviderRegistry::label($row->provider),
                'model' => $row->model,
                'requests' => (int) $row->requests,
                'tokens' => (int) $row->tokens,
                'estimated_cost' => $row->estimated_cost !== null ? (float) $row->estimated_cost : null,
            ]);
    }

    /**
     * @return Collection<int, object{date: string, requests: int, tokens: int, estimated_cost: ?float}>
     */
    private function dailyUsage(int $days): Collection
    {
        $driver = DB::connection()->getDriverName();
        $dateExpr = $driver === 'sqlite'
            ? "strftime('%Y-%m-%d', created_at)"
            : 'DATE(created_at)';

        return AiUsageRecord::query()
            ->where('status', 'success')
            ->where('created_at', '>=', Carbon::today()->subDays($days - 1)->startOfDay())
            ->selectRaw("{$dateExpr} as usage_date")
            ->selectRaw('COUNT(*) as requests')
            ->selectRaw('COALESCE(SUM(tokens_used), 0) as tokens')
            ->selectRaw('SUM(estimated_cost) as estimated_cost')
            ->groupBy('usage_date')
            ->orderBy('usage_date')
            ->get()
            ->map(fn ($row) => (object) [
                'date' => $row->usage_date,
                'requests' => (int) $row->requests,
                'tokens' => (int) $row->tokens,
                'estimated_cost' => $row->estimated_cost !== null ? (float) $row->estimated_cost : null,
            ]);
    }

    /**
     * @return Collection<int, object{month: string, requests: int, tokens: int, estimated_cost: ?float}>
     */
    private function monthlyUsage(int $months): Collection
    {
        $driver = DB::connection()->getDriverName();
        $monthExpr = $driver === 'sqlite'
            ? "strftime('%Y-%m', created_at)"
            : "DATE_FORMAT(created_at, '%Y-%m')";

        return AiUsageRecord::query()
            ->where('status', 'success')
            ->where('created_at', '>=', Carbon::now()->subMonths($months - 1)->startOfMonth())
            ->selectRaw("{$monthExpr} as usage_month")
            ->selectRaw('COUNT(*) as requests')
            ->selectRaw('COALESCE(SUM(tokens_used), 0) as tokens')
            ->selectRaw('SUM(estimated_cost) as estimated_cost')
            ->groupBy('usage_month')
            ->orderBy('usage_month')
            ->get()
            ->map(fn ($row) => (object) [
                'month' => $row->usage_month,
                'requests' => (int) $row->requests,
                'tokens' => (int) $row->tokens,
                'estimated_cost' => $row->estimated_cost !== null ? (float) $row->estimated_cost : null,
            ]);
    }
}
