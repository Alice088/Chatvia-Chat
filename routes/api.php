<?php

use App\Http\Controllers\v1\Auth\LoginController;
use App\Http\Controllers\v1\Auth\RegistrationController;
use App\Http\Controllers\v1\Auth\ResetController;
use Illuminate\Support\Facades\Route;


/*--------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------*/


Route::name("Auth")->group(function () {
    Route::post("Auth/login", [LoginController::class, "login"])
        ->name("Login");

    Route::post("Auth/registration", [RegistrationController::class, "register"])
        ->name("Registration");

    Route::get("Auth/quickLogin", [LoginController::class, "quickLogin"])
        ->name("QuickLogin");

    Route::patch("Auth/reset", [ResetController::class, "reset"])
        ->name("Reset");
});
