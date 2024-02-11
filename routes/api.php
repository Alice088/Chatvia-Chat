<?php

use App\Http\Controllers\v1\Auth\LoginController;
use App\Http\Controllers\v1\Auth\RegistrationContoller;
use App\Http\Controllers\v1\Auth\ResetController;
use Illuminate\Support\Facades\Route;


/*--------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------*/


Route::name("Auth")->group(function () {
    Route::post("Auth/login", [LoginController::class, "login"]);
    Route::post("Auth/registration", [RegistrationContoller::class, "register"]);
    Route::post("Auth/reset", [ResetController::class, "reset"]);
    Route::post("Auth/quickLoign", [LoginController::class, "quickLogin"]);
});
