<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cookie;
use App\Services\AuthManagementService;
use Illuminate\Support\ServiceProvider;
use App\Services\SharedEncrypterService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthManagementService::class);
        $this->app->singleton(SharedEncrypterService::class, function($app){
            return new SharedEncrypterService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cookie::macro('createCrossSite', function ($name, $value, $minutes = 120) {
        //     return Cookie::make($name, $value, $minutes, '/', '.local', true, true, false, 'None');
        // });
    }
}
