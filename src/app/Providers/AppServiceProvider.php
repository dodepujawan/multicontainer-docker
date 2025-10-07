<?php

namespace App\Providers;
use App\Http\Middleware\TrustProxies;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // Tambahkan TrustProxies untuk semua request
    $this->app['router']->aliasMiddleware('trustproxies', TrustProxies::class);

    Route::middleware(['trustproxies'])->group(function () {
        // Semua route Laravel kamu tetap bisa diakses
    });
    }
}
