<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\v1\ErrorResource;
use App\Mail\v1\Auth\ResetMail;
use Mail;

class ResetController extends Controller
{
    public function reset(Request $request)
    {
        try {
            $data = User::getBy("EMAIL", "LIKE", $request->input("EMAIL"));

            if ($data["ERROR"]) {
                return new ErrorResource($data);
            } else {
                $newPassword = (string) app("PasswordManager")::createRandomPassword();
                User::editPassword($data["USER"]->ID, $newPassword);

                // return (new ResetMail($newPassword))->render();

                Mail::to($data["USER"]->EMAIL)->send((new ResetMail($newPassword)));

                return [
                    "data" => [
                        "ERROR" => false
                    ]
                ];
            }
        } catch (\Exception $error) {
            $error = [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];

            return new ErrorResource($error);
        }
    }
}
