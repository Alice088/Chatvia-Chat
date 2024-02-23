<?php

namespace Tests\Feature\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use DB;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_add(): void
    {
        Schema::connection('mysql_test');

        DB::beginTransaction();
        $addResult = User::add([
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
        ]);
        DB::commit();

        $this->assertFalse($addResult["ERROR"], $addResult["ERROR_MESSAGE"] ?? '');
        $this->assertDatabaseHas('users', [
            "USER_ID" => $addResult["ID"],
        ]);
    }

    public function test_delete(): void
    {
        Schema::connection('mysql_test');

        DB::beginTransaction();
        $addResult = User::add([
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
        ]);
        DB::commit();

        DB::beginTransaction();
        $deleteResult = User::deleteUser($addResult["ID"]);
        DB::commit();

        $this->assertFalse($addResult["ERROR"],  $addResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($deleteResult["ERROR"],  $deleteResult["ERROR_MESSAGE"] ?? '');
    }

    public function test_getBy(): void
    {
        Schema::connection('mysql_test');

        DB::beginTransaction();
        $addResult = User::add([
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
        ]);
        
        $getResult = User::getBy("USER_ID", "=", $addResult["ID"]);
        DB::commit();

        $this->assertFalse($getResult["ERROR"],  $getResult["ERROR_MESSAGE"] ?? '');
        $this->assertTrue($addResult["ID"] === $getResult["USER"]->USER_ID);
        $this->assertFalse($addResult["ERROR"],  $addResult["ERROR_MESSAGE"] ?? '');
    }

    public function test_editPassword(): void
    {
        Schema::connection('mysql_test');
        $newPassword = app("PasswordManager")::createRandomPassword();

        DB::beginTransaction();
        $addResult = User::add([
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40)
        ]);
        DB::commit();

        DB::beginTransaction();
        $editResult = User::editPassword($addResult["ID"], $newPassword);
        $getResult = User::getBy("USER_ID", "=", $addResult["ID"]);
        DB::commit();

        $this->assertFalse($getResult["ERROR"], $getResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($editResult["ERROR"],  $editResult["ERROR_MESSAGE"] ?? '');
        $this->assertTrue(password_verify($newPassword, $getResult["USER"]->PASSWORD));
        $this->assertFalse($addResult["ERROR"], $addResult["ERROR_MESSAGE"] ?? '');
    }

    public function test_updateRememberToken(): void
    {
        Schema::connection('mysql_test');

        DB::beginTransaction();
        $addResult = User::add([
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40)
        ]);
        DB::commit();

        DB::beginTransaction();
        $getResult = User::getBy("USER_ID", "=", $addResult["ID"]);
        $updateResult = User::updateRememberToken($addResult["ID"]);
        DB::commit();


        $this->assertFalse($getResult["ERROR"],  $getResult["ERROR_MESSAGE"] ?? '');
        $this->assertFalse($updateResult["ERROR"], $updateResult["ERROR_MESSAGE"] ?? '');
        $this->assertTrue($getResult["USER"]->REMEMBER_TOKEN !== $updateResult["REMEMBER_TOKEN"]);
        $this->assertFalse($addResult["ERROR"], $addResult["ERROR_MESSAGE"] ?? '');
    }
}
