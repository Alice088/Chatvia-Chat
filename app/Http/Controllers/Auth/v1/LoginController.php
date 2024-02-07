<?php

namespace App\Http\Controllers\Auth\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\v1\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        return new LoginResource(User::getBy("EMAIL", $request->input("EMAIL")));
    }
}
