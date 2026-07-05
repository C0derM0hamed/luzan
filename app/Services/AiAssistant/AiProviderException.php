<?php

namespace App\Services\AiAssistant;

use Exception;

class AiProviderException extends Exception
{
    public function __construct(
        string $message,
        public readonly string $userMessage = 'عذراً، حدث خطأ مؤقت. يرجى المحاولة لاحقاً أو التواصل مع العيادة مباشرة.',
        public readonly int $statusCode = 500,
        public readonly bool $eligibleForFallback = true,
        public readonly ?string $provider = null,
    ) {
        parent::__construct($message);
    }

    public static function allProvidersFailed(): self
    {
        return new self(
            'All AI providers failed',
            userMessage: 'عذراً، المساعد الذكي غير متاح حالياً. يرجى المحاولة لاحقاً أو التواصل مع العيادة مباشرة.',
            statusCode: 503,
            eligibleForFallback: false,
        );
    }
}
