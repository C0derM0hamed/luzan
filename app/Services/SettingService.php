<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public function get(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }

    public function set(string $key, mixed $value, string $group = 'general'): void
    {
        Setting::set($key, $value, $group);
    }

    public function allGrouped(): array
    {
        return Setting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group')
            ->all();
    }
}
