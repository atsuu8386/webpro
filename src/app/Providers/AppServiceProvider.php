<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Force HTTPS when request is secure or behind a proxy
        if (request()->secure() || request()->header('X-Forwarded-Proto') === 'https') {
            \URL::forceScheme('https');
        }

        Blade::if('adminCan', fn($p) => auth()->user()->hasPermissionTo($p, 'admin'));
        Blade::if('webCan', fn($p) => auth()->user()->hasPermissionTo($p, 'web'));
    }
}
