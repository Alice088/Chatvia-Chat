<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;

class Chat extends Model
{
    use HasFactory;

    public static function get(array $ids): array
    {
        try {
            $chat = DB::table("chats")
                ->whereIn("CHAT_ID", $ids)
                ->get()
            ;

            if ($chat->isEmpty()) {
                throw new Exception("Chat not found", 404);
            } else {
                return [
                    "ERROR" => false,
                    "CHAT"  => $chat[0]
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

    public static function add(array $chat): array
    {
        try {
            $chatId = DB::table("chats")->insertGetId([
                "TITLE"        => $chat["TITLE"],
                "OWNER_ID_TWO" => $chat["OWNER_ID_TWO"],
                "OWNER_ID_ONE" => $chat["OWNER_ID_ONE"],
            ]);

            return [
                "ERROR" => false,
                "ID" => $chatId,
            ];
        } catch (Exception $error) {
            return [
                "ERROR"         => true,
                "ERROR_MESSAGE" => $error->getMessage() ?? "Something went wrong",
                "ERROR_CODE"    => $error->getCode() ?? 500,
            ];
        }
    }

    public static function deleteChat(int $id): array
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

    public static function getAllWhereIsUser(int $id): array
    {
        try {
            $chats = DB::table("chats")
                ->where("OWNER_ID_ONE", "=", $id)
                ->orWhere("OWNER_ID_TWO", "=", $id)
                ->get()
            ;

            return [
                "ERROR" => false,
                "CHATS" => !!$chats->all() ? $chats->all() : null
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
