<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\RememberTokenManager;
use App\Helpers\PasswordManager;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind("RememberTokenManager", function () {
            return RememberTokenManager::class;
        });

        $this->app->bind("PasswordManager", function () {
            return PasswordManager::class;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
