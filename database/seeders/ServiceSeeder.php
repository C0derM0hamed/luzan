<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    private const DEFAULT_ICON = '<svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>';

    public function run(): void
    {
        $services = [
            'الطب العام',
            'الطوارئ',
            'الباطنة',
            'النساء والولادة',
            'الأطفال',
            'الجلدية والتجميل والليزر',
            'العظام والمفاصل',
            'الأسنان',
            'التقويم',
            'التركيبات والزراعات',
            'علاج العصب',
            'صحة الفم',
            'الأنف والأذن والحنجرة',
            'أمراض الصدر والربو والحساسية',
            'الأشعة',
            'المختبر',
            'العلاج الطبيعي',
            'الحجامة',
        ];

        // Load HealthIcons JSON if available
        $healthIcons = [];
        $jsonPath = base_path('node_modules/@iconify-json/healthicons/icons.json');
        if (file_exists($jsonPath)) {
            $healthIconsData = json_decode(file_get_contents($jsonPath), true);
            $healthIcons = $healthIconsData['icons'] ?? [];
        }

        $map = [
            'الطب العام' => 'stethoscope-outline',
            'الطوارئ' => 'ambulance-outline',
            'الباطنة' => 'stomach-outline',
            'النساء والولادة' => 'pregnant-outline',
            'الأطفال' => 'child-program-outline',
            'الجلدية والتجميل والليزر' => 'dermatology-outline',
            'العظام والمفاصل' => 'bone-outline',
            'الأسنان' => 'tooth-outline',
            'التقويم' => 'tooth-outline',
            'التركيبات والزراعات' => 'tooth-outline',
            'علاج العصب' => 'tooth-outline',
            'صحة الفم' => 'tooth-outline',
            'الأنف والأذن والحنجرة' => 'ear-outline',
            'أمراض الصدر والربو والحساسية' => 'lungs-outline',
            'الأشعة' => 'radiology-outline',
            'المختبر' => 'microscope-outline',
            'العلاج الطبيعي' => 'exercise-outline',
            'الحجامة' => 'blood-drop-outline',
        ];

        $fallbacks = [
            'pregnant-outline' => 'pregnancy-outline',
            'child-program-outline' => 'baby-outline',
            'dermatology-outline' => 'face-outline',
            'radiology-outline' => 'xray-outline',
            'exercise-outline' => 'walking-outline',
            'pregnancy-outline' => 'mother-outline',
            'mother-outline' => 'female-outline',
            'ear-outline' => 'hearing-outline',
        ];

        foreach ($services as $index => $name) {
            $iconSvg = self::DEFAULT_ICON;

            if (!empty($healthIcons)) {
                $iconName = $map[$name] ?? 'stethoscope-outline';
                
                while (!isset($healthIcons[$iconName]) && isset($fallbacks[$iconName])) {
                    $iconName = $fallbacks[$iconName];
                }
                
                if (!isset($healthIcons[$iconName])) {
                    $baseWord = explode('-', $iconName)[0];
                    foreach (array_keys($healthIcons) as $key) {
                        if (strpos($key, $baseWord) !== false && strpos($key, 'outline') !== false) {
                            $iconName = $key;
                            break;
                        }
                    }
                }
                
                if (!isset($healthIcons[$iconName])) {
                    $iconName = 'health-worker-outline';
                }

                if (isset($healthIcons[$iconName])) {
                    $body = $healthIcons[$iconName]['body'];
                    $width = $healthIcons[$iconName]['width'] ?? 48;
                    $height = $healthIcons[$iconName]['height'] ?? 48;
                    $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 '.$width.' '.$height.'" fill="currentColor" width="100%" height="100%">'.$body.'</svg>';
                }
            }

            Service::query()->updateOrCreate(
                ['name' => $name],
                [
                    'icon_svg' => $iconSvg,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
