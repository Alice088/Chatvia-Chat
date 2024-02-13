<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\RememberTokenManager;
use App\Helpers\PasswordManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton("RememberTokenManager", function () {
            return new RememberTokenManager;
        });

        $this->app->singleton("PasswordManager", function () {
           return new PasswordManager;
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
