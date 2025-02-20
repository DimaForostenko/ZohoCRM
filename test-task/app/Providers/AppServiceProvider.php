<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\ZohoTokenService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
{
    $this->app->singleton(ZohoTokenService::class, function ($app) {
        return new ZohoTokenService();
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
