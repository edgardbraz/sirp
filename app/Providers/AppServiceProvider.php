<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ConfeaApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ConfeaApiService::class, function ($app) {
            return new ConfeaApiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
