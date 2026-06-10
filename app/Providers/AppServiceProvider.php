<?php

namespace App\Providers;

use App\View\Composers\AdminViewComposer;
use App\View\Composers\PublicLayoutComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer([
            'layouts.app',
            'home',
            'components.navbar',
            'components.footer',
            'components.hero',
            'components.booking-form',
            'components.services-section',
            'components.doctors-section',
            'components.branches-section',
            'pages.*',
        ], PublicLayoutComposer::class);

        View::composer([
            'layouts.admin',
            'admin.*',
        ], AdminViewComposer::class);
    }
}
