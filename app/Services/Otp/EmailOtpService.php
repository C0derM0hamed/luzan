<?php

namespace App\Services\Otp;

use App\Mail\OtpMail;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Mail;

class EmailOtpService implements OtpServiceInterface
{
    /**
     * Send an OTP to the given email address.
     */
    public function send(string $recipient): bool
    {
        // Invalidate any previous unused OTPs for this email
        OtpCode::query()
            ->where('email', $recipient)
            ->whereNull('verified_at')
            ->delete();

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpCode::query()->create([
            'email' => $recipient,
            'code' => $code,
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
        ]);

        Mail::to($recipient)->send(new OtpMail($code));

        return true;
    }

    /**
     * Verify the OTP code for the given email address.
     */
    public function verify(string $recipient, string $code): bool
    {
        $otp = OtpCode::query()
            ->where('email', $recipient)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (! $otp) {
            return false;
        }

        if ($otp->isExpired()) {
            return false;
        }

        if ($otp->hasExceededAttempts()) {
            return false;
        }

        $otp->increment('attempts');

        if ($otp->code !== $code) {
            return false;
        }

        $otp->update(['verified_at' => now()]);

        return true;
    }

    /**
     * Clean up expired OTP codes older than 1 hour.
     */
    public function cleanup(): void
    {
        OtpCode::query()
            ->where('expires_at', '<', now()->subHour())
            ->delete();
    }
}
