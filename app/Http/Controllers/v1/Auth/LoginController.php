<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;
use App\Http\Resources\v1\ErrorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = User::getBy("EMAIL", "LIKE", $request->input("EMAIL"));

        if ($data["ERROR"]) {
            return new ErrorResource($data);
        } elseif (password_verify($request->input("PASSWORD"), $data["USER"]->PASSWORD)) {
            $response = new Response(new UserResource($data));
            $request->input("REMEMBER")
                ? $response->withCookie(cookie('REMEMBER_TOKEN', $data["USER"]->REMEMBER_TOKEN, 2880)) //добавить добавление токена
                : null
            ;

            return $response;
        } else {
            $data["ERROR"]         = true;
            $data['ERROR_MESSAGE'] = "Password is wrong!.";
            $data['ERROR_CODE']    = 401;

            return new ErrorResource($data);
        }
    }
}
