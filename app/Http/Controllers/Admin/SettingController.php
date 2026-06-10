<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private const ALLOWED_KEYS = [
        'clinic_name',
        'tagline',
        'phone',
        'site_email',
        'address',
        'hero_headline',
        'hero_subtext',
        'about_title',
        'about_content',
        'contact_title',
        'contact_content',
        'snapchat',
        'instagram',
        'twitter',
        'facebook',
        'meta_title',
        'meta_description',
    ];

    private const GROUP_MAP = [
        'clinic_name' => 'general',
        'tagline' => 'general',
        'phone' => 'general',
        'site_email' => 'general',
        'address' => 'general',
        'hero_headline' => 'content',
        'hero_subtext' => 'content',
        'about_title' => 'content',
        'about_content' => 'content',
        'contact_title' => 'content',
        'contact_content' => 'content',
        'snapchat' => 'social',
        'instagram' => 'social',
        'twitter' => 'social',
        'facebook' => 'social',
        'meta_title' => 'seo',
        'meta_description' => 'seo',
    ];

    public function edit(SettingService $settings)
    {
        $all = Setting::query()->pluck('value', 'key')->all();

        $settingGroups = [
            [
                'title' => 'عام',
                'fields' => [
                    ['key' => 'clinic_name', 'label' => 'اسم المجمع'],
                    ['key' => 'tagline', 'label' => 'الشعار'],
                    ['key' => 'phone', 'label' => 'رقم الهاتف', 'dir' => 'ltr'],
                    ['key' => 'site_email', 'label' => 'البريد الإلكتروني', 'dir' => 'ltr'],
                    ['key' => 'address', 'label' => 'العنوان', 'type' => 'textarea'],
                ],
            ],
            [
                'title' => 'محتوى الصفحة الرئيسية',
                'fields' => [
                    ['key' => 'hero_headline', 'label' => 'البانر', 'type' => 'textarea', 'hint' => 'يمكن استخدام سطر جديد'],
                    ['key' => 'hero_subtext', 'label' => 'البانر', 'type' => 'textarea'],
                    ['key' => 'about_title', 'label' => 'عنوان قسم من نحن'],
                    ['key' => 'about_content', 'label' => 'محتوى من نحن', 'type' => 'textarea', 'rows' => 5],
                    ['key' => 'contact_title', 'label' => 'عنوان قسم اتصل بنا'],
                    ['key' => 'contact_content', 'label' => 'محتوى اتصل بنا', 'type' => 'textarea', 'rows' => 4],
                ],
            ],
            [
                'title' => 'وسائل التواصل',
                'fields' => [
                    ['key' => 'snapchat', 'label' => 'سناب شات', 'dir' => 'ltr'],
                    ['key' => 'instagram', 'label' => 'انستغرام', 'dir' => 'ltr'],
                    ['key' => 'twitter', 'label' => 'تويتر', 'dir' => 'ltr'],
                    ['key' => 'facebook', 'label' => 'فيسبوك', 'dir' => 'ltr'],
                ],
            ],
            [
                'title' => 'SEO',
                'fields' => [
                    ['key' => 'meta_title', 'label' => 'عنوان الصفحة'],
                    ['key' => 'meta_description', 'label' => 'وصف الصفحة', 'type' => 'textarea'],
                ],
            ],
        ];

        return view('admin.settings.edit', [
            'pageTitle' => 'إعدادات الموقع',
            'settings' => $all,
            'settingGroups' => $settingGroups,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'string'],
        ], [
            'settings.required' => 'لا توجد إعدادات للحفظ.',
        ]);

        foreach ($data['settings'] as $key => $value) {
            if (!in_array($key, self::ALLOWED_KEYS, true)) {
                continue;
            }

            Setting::set($key, $value, self::GROUP_MAP[$key] ?? 'general');
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'تم حفظ الإعدادات بنجاح.');
    }
}
