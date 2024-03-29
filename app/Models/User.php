<?php

namespace App\Models;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public static function getBy(mixed $columnName, mixed $operator = "=", mixed $value, string|array $select = ["*"]): array
    {
        try {

            $user = DB::table("users")
                ->where($columnName, $operator, $value)
                ->select($select)
                ->get();

            if ($user->isEmpty()) {
                return [
                    "ERROR"         => true,
                    "ERROR_MESSAGE" => "User not found",
                    "ERROR_CODE"    => 404,
                ];
            } else {
                $user        = $user[0];
                $user->CHATS = Chat::getAllWhereIsUser($user->USER_ID)["CHATS"];

                return [
                    "ERROR" => false,
                    "USER"  => $user
                ];
            }
        } catch (Exception $error) {
            return [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public static function add(array $user): array
    {
        try {
            $rememberToken = (string) app("RememberTokenManager")::createRememberToken();

            $columnId = DB::table("users")->insertGetId([
                "USERNAME"       => $user["USERNAME"],
                "EMAIL"          => $user["EMAIL"],
                "PASSWORD"       => password_hash($user["PASSWORD"], PASSWORD_DEFAULT),
                "REMEMBER_TOKEN" => $rememberToken,
            ]);

            return [
                "ERROR"          => false,
                "ID"             => $columnId,
                "REMEMBER_TOKEN" => $rememberToken,
            ];
        } catch (Exception $error) {
            return [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public static function deleteUser(int $id): array
    {
        try {
            DB::table("users")->where("USER_ID", "=", $id)->delete();

            return [
                "ERROR" => false
            ];
        } catch (Exception $error) {
            return [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public static function editPassword(int $id, string $password): array
    {
        try {
            DB::table("users")
                ->where("USER_ID", $id)
                ->update(["PASSWORD" => password_hash($password, PASSWORD_DEFAULT)]);

            return [
                "ERROR" => false
            ];
        } catch (Exception $error) {
            return [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public static function updateRememberToken(int $id): array
    {
        try {
            $rememberToken = (string) app("RememberTokenManager")::createRememberToken();

            DB::table("users")
                ->where("USER_ID", "=", $id)
                ->update([
                    "REMEMBER_TOKEN" => $rememberToken,
                ]);

            return [
                "ERROR"          => false,
                'REMEMBER_TOKEN' => $rememberToken,
            ];
        } catch (Exception $error) {
            return [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }
}
