<?php

namespace App\Services\AiAssistant;

use App\Services\SettingService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class AiSettingsService
{
    private const GROUP = 'ai_assistant';

    private const DEFAULT_INSTRUCTIONS = <<<'TEXT'
أنت المساعد الذكي الرسمي لمجمع لوزان التخصصي الطبي. مهمتك مساعدة المرضى والزوار بالإجابة على استفساراتهم بشكل ودود ومهني.

قواعد مهمة:
- استخدم فقط المعلومات المقدمة في سياق العيادة. لا تخترع أي معلومات غير موجودة.
- إذا لم تجد الإجابة في السياق، اعتذر بلطف واطلب من المريض التواصل مع العيادة مباشرة.
- أجب بالعربية افتراضياً. إذا كتب المستخدم بالإنجليزية، أجب بالإنجليزية.
- لا تقدم تشخيصاً طبياً أو وصفات علاج. وجّه المريض للطبيب المختص.
- كن موجزاً وواضحاً. استخدم نقاطاً عند الحاجة لتسهيل القراءة.
- تحدث بصفتك ممثلاً رسمياً للمجمع.
TEXT;

    private const DEFAULT_WELCOME = 'مرحباً بك في مجمع لوزان التخصصي الطبي! 👋

أنا مساعدك الذكي، هنا لمساعدتك في:
• حجز المواعيد
• معرفة الأطباء والتخصصات
• الخدمات والعروض
• الفروع وساعات العمل
• التواصل مع المجمع

كيف يمكنني مساعدتك اليوم؟';

    public function __construct(private SettingService $settings)
    {
    }

    public function isEnabled(): bool
    {
        return $this->settings->get('ai_enabled', '0') === '1';
    }

    public function getPrimaryProvider(): string
    {
        $provider = (string) $this->settings->get('ai_provider', AiProviderRegistry::GEMINI);

        return AiProviderRegistry::isValid($provider) ? $provider : AiProviderRegistry::GEMINI;
    }

    public function isProviderEnabled(string $provider): bool
    {
        $key = "ai_{$provider}_enabled";

        return $this->settings->get($key, '1') === '1';
    }

    public function hasProviderApiKey(string $provider): bool
    {
        return $this->getProviderApiKey($provider) !== null;
    }

    public function getProviderApiKey(string $provider): ?string
    {
        $settingKey = $this->providerApiKeySetting($provider);
        $encrypted = $this->settings->get($settingKey);

        if (!is_string($encrypted) || trim($encrypted) === '') {
            return null;
        }

        try {
            return Crypt::decryptString($encrypted);
        } catch (DecryptException) {
            return null;
        }
    }

    public function setProviderApiKey(string $provider, ?string $key): void
    {
        if ($key === null || trim($key) === '') {
            return;
        }

        $this->settings->set(
            $this->providerApiKeySetting($provider),
            Crypt::encryptString(trim($key)),
            self::GROUP,
        );
    }

    public function getProviderModel(string $provider): string
    {
        $model = trim((string) $this->settings->get("ai_{$provider}_model", ''));

        if ($model !== '') {
            return $model;
        }

        return AiProviderRegistry::defaultModel($provider);
    }

    /** @deprecated Use getProviderApiKey() */
    public function getApiKey(): ?string
    {
        return $this->getProviderApiKey(AiProviderRegistry::OPENAI);
    }

    /** @deprecated Use setProviderApiKey() */
    public function setApiKey(?string $key): void
    {
        $this->setProviderApiKey(AiProviderRegistry::OPENAI, $key);
    }

    /** @deprecated Use getProviderModel() */
    public function getModel(): string
    {
        return $this->getProviderModel($this->getPrimaryProvider());
    }

    public function hasConfiguredProvider(): bool
    {
        return count($this->getFallbackChain()) > 0;
    }

    /** @deprecated Use hasConfiguredProvider() */
    public function hasApiKey(): bool
    {
        return $this->hasConfiguredProvider();
    }

    /**
     * @return list<string>
     */
    public function getFallbackChain(): array
    {
        $chain = [];
        $primary = $this->getPrimaryProvider();

        if ($this->isProviderConfigured($primary)) {
            $chain[] = $primary;
        }

        foreach (AiProviderRegistry::fallbackOrder() as $provider) {
            if ($provider === $primary) {
                continue;
            }

            if ($this->isProviderConfigured($provider)) {
                $chain[] = $provider;
            }
        }

        return $chain;
    }

    public function isProviderConfigured(string $provider): bool
    {
        return $this->isProviderEnabled($provider) && $this->hasProviderApiKey($provider);
    }

    public function getTemperature(): float
    {
        $value = (float) $this->settings->get('ai_temperature', '0.3');

        return max(0.0, min(1.0, $value));
    }

    public function getMaxTokens(): int
    {
        return max(100, min(8000, (int) $this->settings->get('ai_max_tokens', 2048)));
    }

    public function getSystemInstructions(): string
    {
        $custom = $this->settings->get('ai_system_instructions');

        if ($custom === null) {
            return self::DEFAULT_INSTRUCTIONS;
        }

        return trim((string) $custom);
    }

    public function getWelcomeMessage(): string
    {
        $custom = trim((string) $this->settings->get('ai_welcome_message', ''));

        return $custom !== '' ? $custom : self::DEFAULT_WELCOME;
    }

    public function getDailyLimit(): int
    {
        return max(1, (int) $this->settings->get('ai_daily_limit', 50));
    }

    public function isChatHistoryEnabled(): bool
    {
        return $this->settings->get('ai_chat_history_enabled', '1') === '1';
    }

    public function isLoggingEnabled(): bool
    {
        return $this->settings->get('ai_logging_enabled', '1') === '1';
    }

    /**
     * @return array<string, mixed>
     */
    public function getPublicConfig(): array
    {
        return [
            'enabled' => $this->isEnabled() && $this->hasConfiguredProvider(),
            'welcomeMessage' => $this->getWelcomeMessage(),
            'chatHistoryEnabled' => $this->isChatHistoryEnabled(),
            'clinicName' => $this->settings->get('clinic_name', 'مجمع لوزان التخصصي الطبي'),
            'quickActions' => $this->quickActions(),
        ];
    }

    /**
     * @return array<int, array{label: string, message: string, url: ?string}>
     */
    public function quickActions(): array
    {
        return [
            ['label' => 'حجز موعد', 'message' => 'أريد حجز موعد', 'url' => route('book')],
            ['label' => 'الأطباء', 'message' => 'ما هي قائمة الأطباء والتخصصات المتوفرة؟', 'url' => route('doctors')],
            ['label' => 'الخدمات', 'message' => 'ما هي الخدمات الطبية المتوفرة؟', 'url' => route('services')],
            ['label' => 'الفروع', 'message' => 'أين توجد فروع المجمع وما هي بيانات التواصل؟', 'url' => route('branches')],
            ['label' => 'العروض', 'message' => 'هل توجد عروض حالية؟', 'url' => route('offers')],
            ['label' => 'اتصل بنا', 'message' => 'كيف يمكنني التواصل مع المجمع؟', 'url' => route('contact')],
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateFromAdmin(array $data): void
    {
        $booleanKeys = ['ai_enabled', 'ai_chat_history_enabled', 'ai_logging_enabled'];

        foreach ($booleanKeys as $key) {
            $this->settings->set($key, ($data[$key] ?? false) ? '1' : '0', self::GROUP);
        }

        if (isset($data['ai_provider']) && AiProviderRegistry::isValid((string) $data['ai_provider'])) {
            $this->settings->set('ai_provider', (string) $data['ai_provider'], self::GROUP);
        }

        if (isset($data['ai_temperature'])) {
            $this->settings->set('ai_temperature', (string) $this->getTemperatureFromInput($data['ai_temperature']), self::GROUP);
        }

        if (isset($data['ai_max_tokens'])) {
            $this->settings->set('ai_max_tokens', (string) max(100, min(8000, (int) $data['ai_max_tokens'])), self::GROUP);
        }

        if (array_key_exists('ai_system_instructions', $data)) {
            $this->settings->set('ai_system_instructions', (string) $data['ai_system_instructions'], self::GROUP);
        }

        if (array_key_exists('ai_welcome_message', $data)) {
            $this->settings->set('ai_welcome_message', (string) $data['ai_welcome_message'], self::GROUP);
        }

        if (isset($data['ai_daily_limit'])) {
            $this->settings->set('ai_daily_limit', (string) max(1, (int) $data['ai_daily_limit']), self::GROUP);
        }

        foreach (AiProviderRegistry::all() as $provider) {
            $enabledKey = "ai_{$provider}_enabled";
            if (array_key_exists($enabledKey, $data)) {
                $this->settings->set($enabledKey, ($data[$enabledKey] ?? false) ? '1' : '0', self::GROUP);
            }

            $modelKey = "ai_{$provider}_model";
            if (isset($data[$modelKey]) && trim((string) $data[$modelKey]) !== '') {
                $this->settings->set($modelKey, trim((string) $data[$modelKey]), self::GROUP);
            }

            $apiKeyField = "ai_{$provider}_api_key";
            if (!empty($data[$apiKeyField])) {
                $this->setProviderApiKey($provider, (string) $data[$apiKeyField]);
            }
        }

        ClinicContextBuilder::clearCache();
    }

    /**
     * @return array<string, mixed>
     */
    public function getAdminFormData(): array
    {
        $providers = [];

        foreach (AiProviderRegistry::all() as $provider) {
            $providers[$provider] = [
                'enabled' => $this->isProviderEnabled($provider),
                'has_api_key' => $this->hasProviderApiKey($provider),
                'api_key' => $this->getProviderApiKey($provider),
                'model' => $this->getProviderModel($provider),
            ];
        }

        return [
            'ai_enabled' => $this->isEnabled(),
            'ai_provider' => $this->getPrimaryProvider(),
            'ai_temperature' => $this->getTemperature(),
            'ai_max_tokens' => $this->getMaxTokens(),
            'ai_system_instructions' => $this->settings->get('ai_system_instructions') ?? self::DEFAULT_INSTRUCTIONS,
            'ai_welcome_message' => $this->settings->get('ai_welcome_message', self::DEFAULT_WELCOME),
            'ai_daily_limit' => $this->getDailyLimit(),
            'ai_chat_history_enabled' => $this->isChatHistoryEnabled(),
            'ai_logging_enabled' => $this->isLoggingEnabled(),
            'providers' => $providers,
        ];
    }

    private function providerApiKeySetting(string $provider): string
    {
        return "ai_{$provider}_api_key";
    }

    private function getTemperatureFromInput(mixed $value): float
    {
        return max(0.0, min(1.0, (float) $value));
    }
}
