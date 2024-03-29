<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Auth\UserResource;
use App\Http\Resources\v1\ErrorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = User::getBy("EMAIL", "LIKE", $request->input("EMAIL"));

        if ($data["ERROR"]) {
            return new ErrorResource($data);
        } elseif (password_verify($request->input("PASSWORD"), $data["USER"]->PASSWORD)) {
            $response = new Response(new UserResource($data));

            switch ($request->input("REMEMBER")) {
                case true: {
                    $createTokenResult = User::updateRememberToken($data["USER"]->USER_ID);

                    $response->withCookie(cookie(
                        'REMEMBER_TOKEN',
                        $createTokenResult["ERROR"] ? $data["USER"]->REMEMBER_TOKEN : $createTokenResult["REMEMBER_TOKEN"],
                        //if create token went wrong then it will use the old remember_token from BD.
                        2880)
                    );

                    break;
                }

                case false: {
                    $response->withCookie(Cookie::forget("REMEMBER_TOKEN"));
                    break;
                }
            }

            return $response;
        } else {
            $data["ERROR"]         = true;
            $data['ERROR_MESSAGE'] = "Password is wrong!.";
            $data['ERROR_CODE']    = 401;

            return new ErrorResource($data);
        }
    }

    public function quickLogin(Request $request)
    {
        if (!Cookie::has("REMEMBER_TOKEN")) {
            $error = [
                "ERROR"         => true,
                "ERROR_MESSAGE" => "A remember token not found",
                "ERROR_CODE"    => 401,
            ];

            return new ErrorResource($error);
        }

        $rememberToken = $request->cookie("REMEMBER_TOKEN");

        $userData = User::getBy("REMEMBER_TOKEN", "LIKE", $rememberToken);

        switch ($userData["ERROR"]) {
            case true: {
                $userData["ERROR_MESSAGE"] = $userData['ERROR_CODE'] === 404
                    ? "A remember isn't valid"
                    : $userData['ERROR_MESSAGE']
                ;

                $userData["ERROR_CODE"] = 401;

                return new ErrorResource($userData);
            }

            case false: {
                return new Response(new UserResource($userData));
            }
        }
    }
}
