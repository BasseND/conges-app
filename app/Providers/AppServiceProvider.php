<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\View\Composers\CompanyComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('fr');
        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');
        
        // Forcer HTTPS en production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Enregistrer le View Composer pour les données de la société
        View::composer('*', CompanyComposer::class);
    }
}
