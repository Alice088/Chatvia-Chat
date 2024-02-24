<?php

namespace Tests\Feature\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use DB;
use App\Models\Chat;
use App\Models\User;

class ChatModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_add(): void
    {
        DB::beginTransaction();
        $addUserResult = User::add([
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
        ]);
        DB::commit();

        DB::beginTransaction();
        $addChatResult = Chat::add([
            "TITLE"        => "Test chat",
            "OWNER_ID_TWO" => $addUserResult["ID"],
            "OWNER_ID_ONE" => $addUserResult["ID"],
        ]);
        DB::commit();

        $this->assertFalse($addUserResult["ERROR"], $addUserResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($addChatResult["ERROR"], $addChatResult["ERROR_MESSAGE"] ?? '');
        $this->assertDatabaseHas('chats', [
            "CHAT_ID" => $addChatResult["ID"],
        ]);
    }

    public function test_get(): void
    {
        DB::beginTransaction();
        $addUserResult = User::add([
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
        ]);
        DB::commit();

        DB::beginTransaction();
        $addChatResult = Chat::add([
            "TITLE"        => "Test chat",
            "OWNER_ID_TWO" => $addUserResult["ID"],
            "OWNER_ID_ONE" => $addUserResult["ID"],
        ]);
        DB::commit();

        DB::beginTransaction();
        $getChatResult = Chat::get([$addChatResult["ID"]]);
        DB::commit();

        $this->assertFalse($addUserResult["ERROR"], $addUserResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($addChatResult["ERROR"], $addChatResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($getChatResult["ERROR"], $getChatResult["ERROR_MESSAGE"] ?? '');
        $this->assertDatabaseHas('chats', [
            "CHAT_ID" => $addChatResult["ID"],
        ]);
    }

    public function test_deleteChat(): void
    {
        DB::beginTransaction();
        $addUserResult = User::add([
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
        ]);
        DB::commit();
        
        DB::beginTransaction();
        $addChatResult = Chat::add([
            "TITLE"        => "Test chat",
            "OWNER_ID_TWO" => $addUserResult["ID"],
            "OWNER_ID_ONE" => $addUserResult["ID"],
        ]);
        DB::commit();

        $this->assertDatabaseHas('chats', [
            "CHAT_ID" => $addChatResult["ID"],
        ]);
        
        DB::beginTransaction();
        $deleteChatResult = Chat::deleteChat($addChatResult["ID"]);
        DB::commit();
        
        $this->assertFalse($addChatResult["ERROR"], $addChatResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($addUserResult["ERROR"], $addUserResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($deleteChatResult["ERROR"], $deleteChatResult["ERROR_MESSAGE"] ?? '');
    }

    public function test_getAllWhereIsUser(): void
    {
        DB::beginTransaction();
        $addUserResult = User::add([
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
        ]);
        DB::commit();

        DB::beginTransaction();
        $addChatResult = Chat::add([
            "TITLE"        => "Test chat",
            "OWNER_ID_TWO" => $addUserResult["ID"],
            "OWNER_ID_ONE" => $addUserResult["ID"],
        ]);
        DB::commit();

        
        DB::beginTransaction();
        $getChatResult = Chat::getAllWhereIsUser($addChatResult["ID"]);
        DB::commit();
        
        $this->assertFalse($addChatResult["ERROR"], $addChatResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($addUserResult["ERROR"], $addUserResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($getChatResult["ERROR"], $getChatResult["ERROR_MESSAGE"] ?? '');
        $this->assertDatabaseHas('chats', [
            "CHAT_ID" => $addChatResult["ID"],
        ]);
    }
}
