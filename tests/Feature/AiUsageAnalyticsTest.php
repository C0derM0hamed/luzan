<?php

namespace Tests\Feature;

use App\Models\AiUsageRecord;
use App\Models\User;
use App\Services\AiAssistant\AiProviderRegistry;
use App\Services\AiAssistant\AiSettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiUsageAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    private function enableAssistant(string $provider = AiProviderRegistry::OPENAI, string $apiKey = 'sk-test-key'): void
    {
        app(AiSettingsService::class)->updateFromAdmin([
            'ai_enabled' => true,
            'ai_provider' => $provider,
            "ai_{$provider}_api_key" => $apiKey,
            'ai_daily_limit' => 50,
            'ai_logging_enabled' => false,
            'ai_gemini_enabled' => true,
            'ai_openrouter_enabled' => true,
            'ai_openai_enabled' => true,
        ]);
    }

    public function test_successful_chat_records_token_usage(): void
    {
        $this->seed();
        $this->enableAssistant();

        Http::fake([
            'api.openai.com/*' => Http::response([
                'model' => 'gpt-4o-mini',
                'choices' => [['message' => ['role' => 'assistant', 'content' => 'رد']]],
                'usage' => ['total_tokens' => 150],
            ], 200),
        ]);

        $this->postJson('/api/ai/chat', ['message' => 'مرحباً'])->assertOk();

        $this->assertDatabaseHas('ai_usage_records', [
            'provider' => AiProviderRegistry::OPENAI,
            'model' => 'gpt-4o-mini',
            'tokens_used' => 150,
            'status' => 'success',
        ]);
    }

    public function test_usage_is_recorded_even_when_chat_logging_disabled(): void
    {
        $this->seed();
        $this->enableAssistant();

        Http::fake([
            'api.openai.com/*' => Http::response([
                'model' => 'gpt-4o-mini',
                'choices' => [['message' => ['role' => 'assistant', 'content' => 'رد']]],
                'usage' => ['total_tokens' => 80],
            ], 200),
        ]);

        $this->postJson('/api/ai/chat', ['message' => 'test'])->assertOk();

        $this->assertDatabaseCount('ai_chat_logs', 0);
        $this->assertDatabaseCount('ai_usage_records', 1);
    }

    public function test_admin_can_view_analytics_page(): void
    {
        $this->seed();

        AiUsageRecord::query()->create([
            'provider' => AiProviderRegistry::GEMINI,
            'model' => 'gemini-2.0-flash',
            'tokens_used' => 500,
            'estimated_cost' => 0,
            'status' => 'success',
        ]);

        $admin = User::query()->where('is_admin', true)->first();

        $response = $this->actingAs($admin)->get(route('admin.ai-assistant.analytics'));

        $response->assertOk();
        $response->assertSee('إحصائيات استخدام الذكاء الاصطناعي');
        $response->assertSee('إجمالي الطلبات');
        $response->assertSee('Google Gemini');
        $response->assertSee('gemini-2.0-flash');
    }
}
