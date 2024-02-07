<?php

namespace App\Models;


use DB;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Collection;

class User extends Model
{
    use HasFactory;

    public static function getBy(string $columnName, string $value): array
    {
        try {
            $user = DB::table("users")
                ->where($columnName, $value)
                ->get();

            if ($user->isEmpty()) {
                throw new Exception("User not found", 404);
            } else {
                $user = $user[ 0 ];
                $user->CHATS = Chat::getAllWhereIsUser($user->ID)["CHATS"];


                return [
                    "ERROR" => false,
                    "USER"  => $user
                ];
            }
        } catch (Exception $error) {
            print_r($error);

            return [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public function add(User $user): array|Exception
    {
        try {
            $rememberToken = createRememberToken();

            DB::table("users")->insert([
                "USERNAME"       => $user[ "USERNAME" ],
                "EMAIL"          => $user[ "EMAIL" ],
                "PASSWORD"       => password_hash($user[ "PASSWORD" ], PASSWORD_DEFAULT),
                "REMEMBER_TOKEN" => $rememberToken,
            ]);

            return (object) [
                "ERROR"          => false,
                'REMEMBER_TOKEN' => $rememberToken,
            ];
        } catch (Exception $error) {
            print_r($error);

            return (object) [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public function deleteUser(int $id): array|Exception
    {
        try {
            DB::table("users")->where("id", "=", $id)->delete();

            return (object) [
                "ERROR" => false
            ];
        } catch (Exception $error) {
            print_r($error);

            return (object) [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public function editPassword(int $id, string $password): array|Exception
    {
        try {
            DB::table("users")
                ->where("id", $id)
                ->update(["PASSWORD" => password_hash($password, PASSWORD_DEFAULT)]);

            return (object) [
                "ERROR" => false
            ];
        } catch (Exception $error) {
            print_r($error);

            return (object) [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public function editRememberToken(int $id)
    {
        try {
            $rememberToken = createRememberToken();

            DB::table("users")
                ->where("id", "=", $id)
                ->update([
                    "REMEMBER_TOKEN" => $rememberToken,
                ]);

            return (object) [
                "ERROR"          => false,
                'REMEMBER_TOKEN' => $rememberToken,
            ];
        } catch (Exception $error) {
            print_r($error);

            return (object) [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }
}
