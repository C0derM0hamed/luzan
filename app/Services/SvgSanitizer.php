<?php

namespace App\Services;

class SvgSanitizer
{
    public function sanitize(string $svg): string
    {
        $svg = trim($svg);

        if ($svg === '') {
            return '';
        }

        if (! str_contains($svg, '<svg')) {
            return e($svg);
        }

        $svg = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $svg) ?? $svg;
        $svg = preg_replace('/\s(on\w+|xmlns:xlink|xlink:href)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $svg) ?? $svg;
        $svg = preg_replace('/javascript\s*:/i', '', $svg) ?? $svg;

        if (! preg_match('/^<svg[\s>]/i', $svg)) {
            return e(strip_tags($svg));
        }

        return $svg;
    }
}
