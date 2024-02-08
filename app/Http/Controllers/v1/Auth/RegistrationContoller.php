<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ErrorResource;
use App\Http\Resources\v1\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;

class RegistrationContoller extends Controller
{
    public function register(Request $request)
    {
        $data = User::getBy(columnName: "EMAIL", operator: "LIKE", value: $request->input("EMAIL"));

        if ($data["ERROR"] && $data["ERROR_CODE"] === 404) {
            $dataUser = User::add($request->all());

            if ($dataUser["ERROR"]) {
                return new ErrorResource($dataUser);
            } else {
                $newUser  = User::getBy(columnName: "EMAIL", operator: "LIKE", value: $request->input("EMAIL"));

                $response = new Response(new UserResource($newUser));
                $response->withCookie(cookie("REMEMBER_TOKEN", $dataUser["REMEMBER_TOKEN"], 2880));

                return $response;
            }
        } elseif (array_key_exists("USER", $data)) {
            unset($data["USER"]);
            $data["ERROR"]         = true;
            $data["ERROR_MESSAGE"] = "a User with this email already exists!.";
            $data["ERROR_CODE"]    = 401;

            return new ErrorResource($data);
        } else {
            return new ErrorResource($data);
        }
    }
}
