<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'name'            => env('APP_NAME', 'Chatvia-chat'),

    'env'             => env('APP_ENV', 'production'),

    'debug'           => (bool) env('APP_DEBUG', false),

    'url'             => env('APP_URL', 'http://localhost'),

    'frontend_url'    => env('FRONTEND_URL', 'http://localhost:3000'),

    'asset_url'       => env('ASSET_URL'),

    'timezone'        => 'GMT',

    'locale'          => 'en',

    'fallback_locale' => 'en',

    'faker_locale'    => 'en_US',

    'key'             => env('APP_KEY'),

    'cipher'          => 'AES-256-CBC',

    'maintenance'     => [
        'driver' => 'file',
    ],

    'providers'       => ServiceProvider::defaultProviders()->merge([
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\HelperServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])->toArray(),

    'aliases'         => Facade::defaultAliases()->merge([
        // "RememberTokenManager" => App\Helpers\RememberTokenManager::class
    ])->toArray(),

];
