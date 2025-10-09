<?php

namespace App\Providers;
// use App\Http\Middleware\TrustProxies;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\Route;

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
       // Force HTTPS in non-local environments
        if($this->app->environment('production', 'staging')) {
            URL::forceScheme('https');
        }
    }
}
