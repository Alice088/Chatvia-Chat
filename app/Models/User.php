<?php

namespace App\Models;

use DB;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * get User
     *
     * @param int $id
     *
     * @return User | \Exception | null
     */
    public function get(int $id): User|\Exception|null
    {
        try {
            return DB::table("users")->find($id) ?? null;
        } catch (\Exception $error) {
            print_r($error);

            return (object) [ 
                "ERROR" => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE" => $error->getCode() ?? 500,
            ];
        }
    }

    //public function add(User $user): User|null
    //{
    //    try {
    //        DB::table("");
    //    }
    //    ;
    //}
}
