<?php

namespace App\Services\AiAssistant;

class AiApiKeyValidator
{
    public function __construct(private AiProviderFactory $factory) {}

    /**
     * @throws AiProviderException
     */
    public function validate(string $provider, string $apiKey, string $model): void
    {
        if (! AiProviderRegistry::isValid($provider)) {
            throw new AiProviderException(
                "Unknown provider: {$provider}",
                userMessage: 'مزود الذكاء الاصطناعي غير معروف.',
                statusCode: 422,
                eligibleForFallback: false,
            );
        }

        $this->factory->make($provider, trim($apiKey))->validateApiKey(trim($apiKey), $model);
    }
}
