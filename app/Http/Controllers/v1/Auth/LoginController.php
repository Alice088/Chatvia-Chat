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

            if ($request->input("REMEMBER")) {
                $createTokenResult = User::updateRememberToken($data["USER"]->ID);

                $response->withCookie(cookie(
                    'REMEMBER_TOKEN',
                    $createTokenResult["ERROR"] ? $data["USER"]->REMEMBER_TOKEN : $createTokenResult["REMEMBER_TOKEN"],
                    //if create token went wrong then it will use the old remember_token from BD.
                    2880)
                );
            }

            return $response;
        } else {
            $data["ERROR"]         = true;
            $data['ERROR_MESSAGE'] = "Password is wrong!.";
            $data['ERROR_CODE']    = 401;

            return new ErrorResource($data);
        }
    }
}
