<?php

namespace App\Http\Controllers;

use App\Services\AiAssistant\AiAssistantService;
use App\Services\AiAssistant\AiProviderException;
use App\Services\AiAssistant\AiSettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiChatController extends Controller
{
    public function chat(Request $request, AiAssistantService $assistant, AiSettingsService $settings): JsonResponse
    {
        if (! $settings->isEnabled() || ! $settings->hasConfiguredProvider()) {
            return response()->json([
                'error' => 'المساعد الذكي غير متاح حالياً. يرجى التواصل مع العيادة مباشرة.',
            ], 503);
        }

        $data = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:2000'],
            'session_id' => ['nullable', 'string', 'max:64'],
            'history' => ['nullable', 'array', 'max:20'],
            'history.*.role' => ['required_with:history', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:2000'],
        ], [
            'message.required' => 'يرجى كتابة رسالة.',
            'message.max' => 'الرسالة طويلة جداً.',
        ]);

        $history = $settings->isChatHistoryEnabled()
            ? ($data['history'] ?? [])
            : [];

        $identifier = sha1($request->ip().'|'.($request->userAgent() ?? 'unknown'));

        try {
            $result = $assistant->chat(
                message: $data['message'],
                history: $history,
                sessionId: $data['session_id'] ?? '',
                identifier: $identifier,
                ipAddress: $request->ip(),
            );

            return response()->json($result);
        } catch (AiProviderException $e) {
            return response()->json([
                'error' => $e->userMessage,
            ], $e->statusCode);
        }
    }
}
