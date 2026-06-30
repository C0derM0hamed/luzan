<?php

namespace App\View\Composers;

use App\Models\Appointment;
use App\Models\Offer;
use App\Models\Service;
use App\Services\SettingService;
use Illuminate\View\View;

class PublicLayoutComposer
{
    public function __construct(private SettingService $settings) {}

    public function compose(View $view): void
    {
        $clinicName = $this->settings->get('clinic_name', 'مجمع لوزان التخصصي الطبي');
        $phone = $this->settings->get('phone', '0177221892');
        $tagline = $this->settings->get('tagline', 'رعايتك... أولويتنا');
        $siteEmail = $this->settings->get('site_email', 'info@luzanmedical.com');
        $homeUrl = route('home');

        $footerServices = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $footerQuickLinks = [
            ['label' => 'الرئيسية', 'url' => route('home')],
            ['label' => 'من نحن', 'url' => route('about')],
            ['label' => 'الخدمات', 'url' => route('services')],
            ['label' => 'الأطباء', 'url' => route('doctors')],
            ['label' => 'حجز موعد', 'url' => route('book')],
            ['label' => 'بوابة المرضى', 'url' => route('reports.login')],
            ['label' => 'اتصل بنا', 'url' => route('contact')],
        ];

        $socialLinks = $this->buildSocialLinks();

        $latestOffer = Offer::query()->active()->latest()->first();

        $view->with([
            'clinicName' => $clinicName,
            'siteTitle' => $this->settings->get('meta_title', $clinicName),
            'phone' => $phone,
            'siteEmail' => $siteEmail,
            'tagline' => $tagline,
            'latestOffer' => $latestOffer,
            'footerServices' => $footerServices,
            'footerQuickLinks' => $footerQuickLinks,
            'socialLinks' => $socialLinks,
            'copyrightText' => 'جميع الحقوق محفوظة © '.date('Y').' '.$clinicName,
            'pageTitle' => $this->settings->get('meta_title', $clinicName),
            'heroHeadline' => $this->settings->get('hero_headline', "مجمع لوزان\nالتخصصي الطبي"),
            'heroSubtext' => $this->settings->get('hero_subtext', 'مجمع طبي متكامل يضم نخبة من الأطباء والاستشاريين وأحدث الأجهزة الطبية لخدمة صحتك وراحة بالك'),
            'heroBadges' => $this->defaultHeroBadges(),
            'aboutTitle' => $this->settings->get('about_title', 'من نحن'),
            'aboutContent' => $this->settings->get('about_content', ''),
            'contactTitle' => $this->settings->get('contact_title', 'اتصل بنا'),
            'contactContent' => $this->settings->get('contact_content', ''),
            'contactAddress' => $this->settings->get('address', ''),
            'servicesSectionTitle' => 'خدماتنا',
            'doctorsSectionTitle' => 'أطباؤنا',
            'branchesSectionTitle' => 'فروعنا',
            'bookingFormTitle' => 'احجز موعدك الآن',
            'bookingFormSubtitle' => 'احجز موعدك بكل سهولة',
            'bookingSubmitLabel' => 'احجز الآن',
            'bookButtonLabel' => 'احجز موعد',
            'viewOnMapLabel' => 'عرض على الخريطة',
            'branchesMapLabel' => 'عرض على الخريطة',
            'aboutUrl' => route('about'),
            'contactUrl' => route('contact'),
            'servicesShowAllUrl' => route('services'),
            'servicesShowAllLabel' => 'عرض جميع الخدمات',
            'doctorsShowAllUrl' => route('doctors'),
            'doctorsShowAllLabel' => 'عرض جميع الأطباء',
        ]);
    }

    private function defaultHeroBadges(): array
    {
        return [
            ['label' => 'أطباء متخصصون', 'icon_svg' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/><path d="M15.5 10.5l1.5-1.5-1.5-1.5M8.5 10.5L7 9l1.5-1.5" stroke="white" stroke-width="1.5"/></svg>'],
            ['label' => 'خدمات متكاملة', 'icon_svg' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-1.99.9-1.99 2L3 19c0 1.1.89 2 1.99 2H19c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-6 13h-2v-3H8v-2h3V8h2v3h3v2h-3v3z"/></svg>'],
            ['label' => 'رعاية فائقة', 'icon_svg' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/><path d="M11 14h2V9h-2v5zm0-7h2V5h-2v2z" fill="white"/></svg>'],
        ];
    }

    private function buildSocialLinks(): array
    {
        $icon = fn (string $path) => '<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="'.$path.'"/></svg>';

        $networks = [
            'snapchat' => ['name' => 'Snapchat', 'path' => 'M12 2C9.5 2 8 4 8 6.5c0 1.5.5 2.5 1 3.5-.5.5-1 1-1 2 0 1.5 1.5 2.5 3 2.5h2c1.5 0 3-1 3-2.5 0-1-.5-1.5-1-2 .5-1 1-2 1-3.5C16 4 14.5 2 12 2z'],
            'instagram' => ['name' => 'Instagram', 'path' => 'M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm5 5a5 5 0 100 10 5 5 0 000-10zm6.5-.75a1.25 1.25 0 11-2.5 0 1.25 1.25 0 012.5 0z'],
            'twitter' => ['name' => 'Twitter', 'path' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
            'facebook' => ['name' => 'Facebook', 'path' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
        ];

        $links = [];
        foreach ($networks as $key => $meta) {
            $url = $this->settings->get($key, '#');
            $links[] = [
                'name' => $meta['name'],
                'url' => $url ?: '#',
                'icon_svg' => $icon($meta['path']),
            ];
        }

        return $links;
    }
}
