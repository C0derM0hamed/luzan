<?php

namespace App\Services\Otp;

interface OtpServiceInterface
{
    /**
     * Send an OTP to the given recipient.
     */
    public function send(string $recipient): bool;

    /**
     * Verify the OTP code for the given recipient.
     */
    public function verify(string $recipient, string $code): bool;

    /**
     * Clean up expired OTP codes.
     */
    public function cleanup(): void;
}
