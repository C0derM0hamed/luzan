<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;

// Load HealthIcons JSON
$healthIconsData = json_decode(file_get_contents(__DIR__.'/node_modules/@iconify-json/healthicons/icons.json'), true);
$healthIcons = $healthIconsData['icons'];

function getHealthIcon($name, $healthIcons) {
    if (isset($healthIcons[$name])) {
        $body = $healthIcons[$name]['body'];
        $width = $healthIcons[$name]['width'] ?? 48;
        $height = $healthIcons[$name]['height'] ?? 48;
        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 '.$width.' '.$height.'" fill="currentColor" width="100%" height="100%">'.$body.'</svg>';
    }
    return '';
}

// Map services to icon names
$map = [
    'الطب العام' => 'stethoscope-outline',
    'الطوارئ' => 'ambulance-outline',
    'الباطنة' => 'stomach-outline',
    'النساء والولادة' => 'pregnant-outline', // Fallback to female if pregnant doesn't exist
    'الأطفال' => 'child-program-outline', // Fallback to baby
    'الجلدية والتجميل والليزر' => 'dermatology-outline', // Fallback to face or similar
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
    'العلاج الطبيعي' => 'exercise-outline', // Or physical-therapy
    'الحجامة' => 'blood-drop-outline',
];

// Verify icon names and provide fallbacks
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

$services = Service::all();
$count = 0;
foreach ($services as $service) {
    $iconName = $map[$service->name] ?? 'stethoscope-outline';
    
    // Check fallback
    while(!isset($healthIcons[$iconName]) && isset($fallbacks[$iconName])) {
        $iconName = $fallbacks[$iconName];
    }
    
    if (!isset($healthIcons[$iconName])) {
        // Find any icon containing the word
        $baseWord = explode('-', $iconName)[0];
        foreach(array_keys($healthIcons) as $key) {
            if (strpos($key, $baseWord) !== false && strpos($key, 'outline') !== false) {
                $iconName = $key;
                break;
            }
        }
    }
    
    if (!isset($healthIcons[$iconName])) {
        $iconName = 'health-worker-outline'; // Ultimate fallback
    }

    $service->icon_svg = getHealthIcon($iconName, $healthIcons);
    $service->save();
    $count++;
    echo "Updated {$service->name} with {$iconName}\n";
}

echo "Updated $count services with specific HealthIcons SVGs.\n";
