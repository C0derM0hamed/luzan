<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AiAssistant\AiUsageAnalyticsService;

class AiUsageAnalyticsController extends Controller
{
    public function index(AiUsageAnalyticsService $analytics)
    {
        $data = $analytics->getDashboardData();

        return view('admin.ai-assistant.analytics', [
            'pageTitle' => 'إحصائيات استخدام الذكاء الاصطناعي',
            'summary' => $data['summary'],
            'today' => $data['today'],
            'month' => $data['month'],
            'byProvider' => $data['byProvider'],
            'byModel' => $data['byModel'],
            'dailyUsage' => $data['dailyUsage'],
            'monthlyUsage' => $data['monthlyUsage'],
        ]);
    }
}
