<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AiAssistant\AiProviderRegistry;
use App\Services\AiAssistant\AiSettingsService;
use App\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiAssistantTest extends TestCase
{
    use RefreshDatabase;

    private function enableAssistant(string $provider = AiProviderRegistry::OPENAI, string $apiKey = 'sk-test-key'): void
    {
        $settings = app(AiSettingsService::class);
        $settings->updateFromAdmin([
            'ai_enabled' => true,
            'ai_provider' => $provider,
            "ai_{$provider}_api_key" => $apiKey,
            'ai_daily_limit' => 50,
            'ai_chat_history_enabled' => true,
            'ai_logging_enabled' => true,
            'ai_gemini_enabled' => true,
            'ai_openrouter_enabled' => true,
            'ai_openai_enabled' => true,
        ]);
    }

    public function test_assistant_widget_hidden_when_disabled(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('ai-assistant-root', false);
    }

    public function test_assistant_widget_visible_when_enabled(): void
    {
        $this->seed();
        $this->enableAssistant();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('ai-assistant-root', false);
        $response->assertSee('المساعد الذكي', false);
    }

    public function test_default_provider_is_gemini(): void
    {
        $this->seed();

        $settings = app(AiSettingsService::class);

        $this->assertEquals(AiProviderRegistry::GEMINI, $settings->getPrimaryProvider());
        $this->assertEquals('gemini-2.0-flash', $settings->getProviderModel(AiProviderRegistry::GEMINI));
    }

    public function test_chat_endpoint_rejects_when_disabled(): void
    {
        $this->seed();

        $response = $this->postJson('/api/ai/chat', [
            'message' => 'مرحباً',
        ]);

        $response->assertStatus(503);
        $response->assertJsonFragment(['error' => 'المساعد الذكي غير متاح حالياً. يرجى التواصل مع العيادة مباشرة.']);
    }

    public function test_openai_provider_returns_successful_reply(): void
    {
        $this->seed();
        $this->enableAssistant(AiProviderRegistry::OPENAI);

        Http::fake([
            'api.openai.com/*' => Http::response([
                'model' => 'gpt-4o-mini',
                'choices' => [
                    ['message' => ['role' => 'assistant', 'content' => 'مرحباً! نقدم خدمات طبية متنوعة في مجمع لوزان.']],
                ],
                'usage' => ['total_tokens' => 120],
            ], 200),
        ]);

        $response = $this->postJson('/api/ai/chat', [
            'message' => 'ما هي الخدمات؟',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['reply', 'session_id']);
        $response->assertJsonFragment(['reply' => 'مرحباً! نقدم خدمات طبية متنوعة في مجمع لوزان.']);
    }

    public function test_gemini_provider_returns_successful_reply(): void
    {
        $this->seed();
        $this->enableAssistant(AiProviderRegistry::GEMINI, 'AIza-test-key');

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    ['content' => ['parts' => [['text' => 'أهلاً بك في مجمع لوزان!']]]],
                ],
                'usageMetadata' => ['totalTokenCount' => 80],
            ], 200),
        ]);

        $response = $this->postJson('/api/ai/chat', [
            'message' => 'مرحباً',
        ]);

        $response->assertOk();
        $response->assertJsonFragment(['reply' => 'أهلاً بك في مجمع لوزان!']);
    }

    public function test_openrouter_provider_returns_successful_reply(): void
    {
        $this->seed();
        $this->enableAssistant(AiProviderRegistry::OPENROUTER, 'sk-or-test-key');

        Http::fake([
            'openrouter.ai/*' => Http::response([
                'model' => 'google/gemini-2.0-flash-exp:free',
                'choices' => [
                    ['message' => ['role' => 'assistant', 'content' => 'مرحباً من OpenRouter!']],
                ],
                'usage' => ['total_tokens' => 50],
            ], 200),
        ]);

        $response = $this->postJson('/api/ai/chat', [
            'message' => 'مرحباً',
        ]);

        $response->assertOk();
        $response->assertJsonFragment(['reply' => 'مرحباً من OpenRouter!']);
    }

    public function test_automatic_fallback_from_gemini_to_openai(): void
    {
        $this->seed();

        $settings = app(AiSettingsService::class);
        $settings->updateFromAdmin([
            'ai_enabled' => true,
            'ai_provider' => AiProviderRegistry::GEMINI,
            'ai_gemini_api_key' => 'AIza-fail-key',
            'ai_openai_api_key' => 'sk-fallback-key',
            'ai_gemini_enabled' => true,
            'ai_openai_enabled' => true,
            'ai_openrouter_enabled' => false,
        ]);

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response(['error' => ['message' => 'Rate limit']], 429),
            'api.openai.com/*' => Http::response([
                'model' => 'gpt-4o-mini',
                'choices' => [['message' => ['role' => 'assistant', 'content' => 'رد من OpenAI بعد فشل Gemini']]],
                'usage' => ['total_tokens' => 30],
            ], 200),
        ]);

        $response = $this->postJson('/api/ai/chat', [
            'message' => 'سؤال',
        ]);

        $response->assertOk();
        $response->assertJsonFragment(['reply' => 'رد من OpenAI بعد فشل Gemini']);
    }

    public function test_all_providers_fail_returns_friendly_message(): void
    {
        $this->seed();

        $settings = app(AiSettingsService::class);
        $settings->updateFromAdmin([
            'ai_enabled' => true,
            'ai_provider' => AiProviderRegistry::GEMINI,
            'ai_gemini_api_key' => 'AIza-fail',
            'ai_openrouter_api_key' => 'sk-or-fail',
            'ai_openai_api_key' => 'sk-fail',
            'ai_gemini_enabled' => true,
            'ai_openrouter_enabled' => true,
            'ai_openai_enabled' => true,
        ]);

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response(['error' => ['message' => 'fail']], 429),
            'openrouter.ai/*' => Http::response(['error' => ['message' => 'fail']], 502),
            'api.openai.com/*' => Http::response(['error' => ['message' => 'fail']], 500),
        ]);

        $response = $this->postJson('/api/ai/chat', [
            'message' => 'مرحباً',
        ]);

        $response->assertStatus(503);
        $response->assertJsonFragment(['error' => 'عذراً، المساعد الذكي غير متاح حالياً. يرجى المحاولة لاحقاً أو التواصل مع العيادة مباشرة.']);
    }

    public function test_daily_limit_is_enforced(): void
    {
        $this->seed();
        $this->enableAssistant();

        app(AiSettingsService::class)->updateFromAdmin([
            'ai_enabled' => true,
            'ai_daily_limit' => 1,
        ]);

        Http::fake([
            'api.openai.com/*' => Http::response([
                'model' => 'gpt-4o-mini',
                'choices' => [['message' => ['role' => 'assistant', 'content' => 'رد']]],
                'usage' => ['total_tokens' => 10],
            ], 200),
        ]);

        $this->postJson('/api/ai/chat', ['message' => 'سؤال 1'])->assertOk();

        $response = $this->postJson('/api/ai/chat', ['message' => 'سؤال 2']);

        $response->assertStatus(429);
        $response->assertJsonFragment(['error' => 'تم الوصول إلى الحد اليومي لاستخدام المساعد الذكي. يرجى المحاولة غداً أو التواصل مع العيادة.']);
    }

    public function test_admin_can_access_ai_settings_page(): void
    {
        $this->seed();

        $admin = User::query()->where('is_admin', true)->first();

        $response = $this->actingAs($admin)->get(route('admin.ai-assistant.edit'));

        $response->assertOk();
        $response->assertSee('المساعد الذكي للمرضى');
        $response->assertSee('Google Gemini');
        $response->assertSee('OpenRouter');
    }

    public function test_admin_rejects_invalid_api_key_on_save(): void
    {
        $this->seed();

        $admin = User::query()->where('is_admin', true)->first();

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response(['error' => ['message' => 'API key not valid']], 400),
        ]);

        $response = $this->actingAs($admin)->put(route('admin.ai-assistant.update'), [
            'ai_enabled' => '1',
            'ai_provider' => AiProviderRegistry::GEMINI,
            'ai_temperature' => '0.3',
            'ai_max_tokens' => '900',
            'ai_daily_limit' => '50',
            'ai_gemini_api_key' => 'invalid-key',
            'ai_gemini_model' => 'gemini-2.0-flash',
            'ai_openrouter_model' => 'google/gemini-2.0-flash-exp:free',
            'ai_openai_model' => 'gpt-4o-mini',
            'ai_gemini_enabled' => '1',
            'ai_openrouter_enabled' => '1',
            'ai_openai_enabled' => '1',
        ]);

        $response->assertSessionHasErrors('ai_gemini_api_key');
    }

    public function test_admin_can_update_settings_without_changing_api_key(): void
    {
        $this->seed();
        $this->enableAssistant(AiProviderRegistry::OPENAI, 'sk-original-key');

        $admin = User::query()->where('is_admin', true)->first();

        $response = $this->actingAs($admin)->put(route('admin.ai-assistant.update'), [
            'ai_enabled' => '1',
            'ai_provider' => AiProviderRegistry::OPENAI,
            'ai_temperature' => '0.5',
            'ai_max_tokens' => '800',
            'ai_openai_model' => 'gpt-4o',
            'ai_gemini_model' => 'gemini-2.0-flash',
            'ai_openrouter_model' => 'google/gemini-2.0-flash-exp:free',
            'ai_system_instructions' => 'تعليمات مخصصة',
            'ai_welcome_message' => 'مرحباً بك!',
            'ai_daily_limit' => '100',
            'ai_chat_history_enabled' => '1',
            'ai_logging_enabled' => '1',
            'ai_gemini_enabled' => '1',
            'ai_openrouter_enabled' => '1',
            'ai_openai_enabled' => '1',
        ]);

        $response->assertRedirect(route('admin.ai-assistant.edit'));
        $response->assertSessionHas('success');

        $settings = app(AiSettingsService::class);
        $this->assertTrue($settings->isEnabled());
        $this->assertEquals('gpt-4o', $settings->getProviderModel(AiProviderRegistry::OPENAI));
        $this->assertEquals('sk-original-key', $settings->getProviderApiKey(AiProviderRegistry::OPENAI));
        $this->assertEquals(0.5, $settings->getTemperature());
    }

    public function test_api_key_is_encrypted_in_database(): void
    {
        $this->seed();

        app(AiSettingsService::class)->setProviderApiKey(AiProviderRegistry::OPENAI, 'sk-secret-test-key');

        $rawValue = app(SettingService::class)->get('ai_openai_api_key');

        $this->assertNotEquals('sk-secret-test-key', $rawValue);
        $this->assertEquals('sk-secret-test-key', app(AiSettingsService::class)->getProviderApiKey(AiProviderRegistry::OPENAI));
    }

    public function test_homepage_still_works_after_ai_integration(): void
    {
        $this->seed();
        $this->enableAssistant();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('مجمع لوزان');
        $response->assertSee('خدماتنا');
    }
}
