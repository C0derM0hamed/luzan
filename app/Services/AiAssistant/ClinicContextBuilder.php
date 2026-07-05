<?php

namespace App\Services\AiAssistant;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Offer;
use App\Models\Service;
use App\Services\SettingService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class ClinicContextBuilder
{
    public function __construct(private SettingService $settings) {}

    public function build(): string
    {
        return Cache::remember('ai_clinic_context', now()->addMinutes(5), function () {
            return $this->compileContext();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('ai_clinic_context');
    }

    private function compileContext(): string
    {
        $sections = [
            $this->generalInfo(),
            $this->branchesSection(),
            $this->doctorsSection(),
            $this->servicesSection(),
            $this->offersSection(),
            $this->navigationSection(),
            $this->patientReportsSection(),
        ];

        return implode("\n\n", array_filter($sections));
    }

    private function generalInfo(): string
    {
        return implode("\n", [
            '=== معلومات عامة عن المجمع ===',
            'اسم المجمع: '.$this->settings->get('clinic_name', 'مجمع لوزان التخصصي الطبي'),
            'الشعار: '.$this->settings->get('tagline', 'رعايتك... أولويتنا'),
            'الهاتف: '.$this->settings->get('phone', ''),
            'البريد الإلكتروني: '.$this->settings->get('site_email', ''),
            'العنوان: '.$this->settings->get('address', ''),
            'عن المجمع: '.$this->settings->get('about_content', ''),
            'معلومات التواصل: '.$this->settings->get('contact_content', ''),
        ]);
    }

    private function branchesSection(): string
    {
        $branches = Branch::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        if ($branches->isEmpty()) {
            return '=== الفروع ==='."\n".'لا توجد فروع مسجلة حالياً.';
        }

        $lines = ['=== الفروع ==='];

        foreach ($branches as $branch) {
            $lines[] = implode(' | ', array_filter([
                'الفرع: '.$branch->name,
                $branch->address ? 'العنوان: '.$branch->address : null,
                $branch->phone ? 'الهاتف: '.$branch->phone : null,
                $branch->email ? 'البريد: '.$branch->email : null,
                $branch->map_url ? 'الخريطة: '.$branch->map_url : null,
            ]));
        }

        return implode("\n", $lines);
    }

    private function doctorsSection(): string
    {
        $doctors = Doctor::query()
            ->where('is_active', true)
            ->with('branches:id,name')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        if ($doctors->isEmpty()) {
            return '=== الأطباء ==='."\n".'لا يوجد أطباء مسجلون حالياً.';
        }

        $lines = ['=== الأطباء والتخصصات ==='];

        foreach ($doctors as $doctor) {
            $branchNames = $doctor->branches->pluck('name')->implode('، ');
            $lines[] = implode(' | ', array_filter([
                'الاسم: '.$doctor->name,
                'التخصص: '.$doctor->specialty,
                $doctor->working_hours ? 'ساعات العمل: '.$doctor->working_hours : null,
                $branchNames !== '' ? 'الفروع: '.$branchNames : null,
            ]));
        }

        return implode("\n", $lines);
    }

    private function servicesSection(): string
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        if ($services->isEmpty()) {
            return '=== الخدمات ==='."\n".'لا توجد خدمات مسجلة حالياً.';
        }

        $lines = ['=== الخدمات الطبية ==='];

        foreach ($services as $service) {
            $price = $service->price ? number_format((float) $service->price, 2).' ر.س' : null;
            $lines[] = implode(' | ', array_filter([
                'الخدمة: '.$service->name,
                $service->description ? 'الوصف: '.$service->description : null,
                $price ? 'السعر: '.$price : null,
            ]));
        }

        return implode("\n", $lines);
    }

    private function offersSection(): string
    {
        $offers = Offer::query()->active()->latest()->get();

        if ($offers->isEmpty()) {
            return '=== العروض ==='."\n".'لا توجد عروض نشطة حالياً.';
        }

        $lines = ['=== العروض الحالية ==='];

        foreach ($offers as $offer) {
            $lines[] = implode(' | ', array_filter([
                'العنوان: '.$offer->title,
                $offer->description ? 'التفاصيل: '.$offer->description : null,
                'من: '.$offer->start_date->format('Y-m-d'),
                'إلى: '.$offer->end_date->format('Y-m-d'),
            ]));
        }

        return implode("\n", $lines);
    }

    private function navigationSection(): string
    {
        return implode("\n", [
            '=== روابط مهمة ===',
            'حجز موعد: '.(Route::has('book') ? route('book') : '/book'),
            'الأطباء: '.(Route::has('doctors') ? route('doctors') : '/doctors'),
            'الخدمات: '.(Route::has('services') ? route('services') : '/services'),
            'الفروع: '.(Route::has('branches') ? route('branches') : '/branches'),
            'العروض: '.(Route::has('offers') ? route('offers') : '/offers'),
            'اتصل بنا: '.(Route::has('contact') ? route('contact') : '/contact'),
            'من نحن: '.(Route::has('about') ? route('about') : '/about'),
        ]);
    }

    private function patientReportsSection(): string
    {
        return implode("\n", [
            '=== تقارير المرضى ===',
            'يمكن للمرضى الوصول إلى تقاريرهم الطبية عبر بوابة المرضى بعد التحقق بالبريد الإلكتروني.',
            'رابط بوابة المرضى: '.(Route::has('reports.login') ? route('reports.login') : '/reports'),
            'لا يمكن للمساعد الوصول إلى تقارير المرضى أو مشاركتها — يجب توجيه المريض لاستخدام البوابة.',
        ]);
    }
}
