<?php

use App\Http\Controllers\Auth\v1\LoginController;
use Illuminate\Support\Facades\Route;

/*--------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------*/


Route::name('Auth')->group(function () {
    Route::post('Auth/v1/login', [LoginController::class, 'login']);
});
