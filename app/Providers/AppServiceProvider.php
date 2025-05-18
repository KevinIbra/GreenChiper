<?php


namespace App\Providers;

use App\Services\SteganographyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SteganographyService::class, function ($app) {
            return new SteganographyService();
        });
    }
}