<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'info@luzanmedical.com'],
            [
                'name' => 'مدير النظام',
                'phone' => '0177221892',
                'password' => Hash::make('luzan@2026'),
                'is_admin' => true,
            ]
        );

        $defaultSettings = [
            ['key' => 'clinic_name', 'value' => 'مجمع لوزان التخصصي الطبي', 'group' => 'general'],
            ['key' => 'tagline', 'value' => 'رعايتك... أولويتنا', 'group' => 'general'],
            ['key' => 'phone', 'value' => '0177221892', 'group' => 'general'],
            ['key' => 'site_email', 'value' => 'info@luzanmedical.com', 'group' => 'general'],
            ['key' => 'address', 'value' => 'الباحة - محافظة قلوة - طريق الملك فهد بجانب بنك الراجحي', 'group' => 'general'],
            ['key' => 'hero_headline', 'value' => "مجمع لوزان\nالتخصصي الطبي", 'group' => 'content'],
            ['key' => 'hero_subtext', 'value' => 'مجمع طبي متكامل يضم نخبة من الأطباء والاستشاريين وأحدث الأجهزة الطبية لخدمة صحتك وراحة بالك', 'group' => 'content'],
            ['key' => 'about_title', 'value' => 'من نحن', 'group' => 'content'],
            ['key' => 'about_content', 'value' => 'مجمع لوزان التخصصي الطبي مركز رعاية صحية متكامل يقدم خدمات طبية شاملة بأيدي نخبة من الأطباء والاستشاريين. نلتزم بتقديم رعاية عالية الجودة باستخدام أحدث التقنيات الطبية، مع فروع في قلوة ونمرة لخدمة أهالي المنطقة.', 'group' => 'content'],
            ['key' => 'contact_title', 'value' => 'اتصل بنا', 'group' => 'content'],
            ['key' => 'contact_content', 'value' => 'نسعد بخدمتكم والرد على استفساراتكم. يمكنكم التواصل معنا عبر الهاتف أو البريد الإلكتروني أو زيارة أحد فروعنا.', 'group' => 'content'],
            ['key' => 'snapchat', 'value' => '#', 'group' => 'social'],
            ['key' => 'instagram', 'value' => '#', 'group' => 'social'],
            ['key' => 'twitter', 'value' => '#', 'group' => 'social'],
            ['key' => 'facebook', 'value' => '#', 'group' => 'social'],
            ['key' => 'meta_title', 'value' => 'مجمع لوزان التخصصي الطبي', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'رعاية طبية متخصصة في قلوة ونمرة', 'group' => 'seo'],
        ];

        foreach ($defaultSettings as $setting) {
            Setting::query()->updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }

        Branch::query()->updateOrCreate(
            ['name' => 'قلوة'],
            [
                'address' => 'الباحة - محافظة قلوة - طريق الملك فهد بجانب بنك الراجحي',
                'phone' => '0177221892',
                'email' => 'info@luzanmedical.com',
                'map_url' => 'https://maps.app.goo.gl/qVasuS47Xy1o3fTt8',
                'is_active' => true,
            ]
        );

        Branch::query()->updateOrCreate(
            ['name' => 'نمرة'],
            [
                'address' => 'العرضيات الشمالية - محافظة نمرة - الشارع العام مقابل أسواق العثيم',
                'phone' => '0557494079',
                'email' => 'info@luzanmedical.com',
                'map_url' => 'https://maps.app.goo.gl/TktXWqBfy2Jcaz2h9',
                'is_active' => true,
            ]
        );

        $this->call([
            ServiceSeeder::class,
            DoctorSeeder::class,
        ]);
    }
}
