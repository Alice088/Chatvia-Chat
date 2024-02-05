<?php

namespace App\Models;


use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function get(int $id): User|\Exception
    {
        try {
            return DB::table("users")->find($id) ?? throw new \Exception("User not found", 404);
        } catch (\Exception $error) {
            print_r($error);

            return (object) [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public function add(User $user): array|\Exception
    {
        try {
            DB::table("users")->insert([
                "USERNAME" => $user["USERNAME"],
                "EMAIL"    => $user["EMAIL"],
                "PASSWORD" => password_hash($user["PASSWORD"], PASSWORD_DEFAULT),
                "REMEMBER_TOKEN" => createRememberToken()
            ]);

            return (object) [
                "ERROR" => false
            ];
        } catch (\Exception $error) {
            print_r($error);

            return (object) [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public function delete(int $id): array|\Exception
    {
        try {
            DB::table("users");

            return (object) [
                "ERROR" => false
            ];
        } catch (\Exception $error) {
            print_r($error);

            return (object) [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public function editPassword(int $id, string $password): array|\Exception
    {
        try {
            DB::table("users")
                ->where("id", $id)
                ->update(["PASSWORD" => password_hash($password, PASSWORD_DEFAULT)]);

            return (object) [
                "ERROR" => false
            ];
        } catch (\Exception $error) {
            print_r($error);

            return (object) [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }
}
