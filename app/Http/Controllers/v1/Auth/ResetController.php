<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\v1\ErrorResource;

class ResetController extends Controller
{
    public function reset(Request $request)
    {
        $data = User::getBy("EMAIL", "LIKE", $request->input("EMAIL"));

        if ($data["ERROR"]) {
            return new ErrorResource($data);
        } else {
            $newPassword = createRandomPassword();
            $subject     = "Reset password from Chatvia-chat";
            $text        = "Hello, {$data["USER"]->USERNAME}! \n
            You have changed password in Chatvia-Chat, \n
            here's your new password: $newPassword";
            $headers     = 'From: gbawhjjejj@gmail.com' . "\r\n" .
                'Reply-To: gbawhjjejj@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            ;

            User::editPassword($data["USER"]->ID, $newPassword);

            ini_set("SMTP", "smtp.gmail.com");
            ini_set("smtp_port", "587");

            mail($data["USER"]->EMAIL, $subject, $text, $headers);

            return [
                "data" => [
                    "ERROR" => false
                ]
            ];
        }
    }
}
