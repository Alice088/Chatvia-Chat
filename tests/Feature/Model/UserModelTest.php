<?php

namespace Tests\Feature\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Database\Factories\UserFactory;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_add(): void
    {
        Schema::connection('mysql_test');
        $username = fake()->name();
        $email    = fake()->unique()->safeEmail();
        $password = fake()->unique()->password(10, 40);

        $addResult = User::add([
            "USERNAME" => $username,
            "EMAIL"    => $email,
            "PASSWORD" => $password,
        ]);

        $this->assertFalse($addResult["ERROR"]);
        $this->assertDatabaseHas('users', [
            "USERNAME"       => $username,
            "EMAIL"          => $email,
            "REMEMBER_TOKEN" => $result["REMEMBER_TOKEN"]
        ]);
    }

        public function test_delete(): void
    {
        Schema::connection('mysql_test');
        $username = fake()->name();
        $email    = fake()->unique()->safeEmail();
        $password = fake()->unique()->password(10, 40);

        $addResult = User::add([
            "USERNAME" => $username,
            "EMAIL"    => $email,
            "PASSWORD" => $password,
        ]);

        $this->assertFalse($addResult["ERROR"]);

        $deleteResult = User::deleteUser()

        $this->assertDatabaseHas('users', [
            "USERNAME"       => $username,
            "EMAIL"          => $email,
            "REMEMBER_TOKEN" => $result["REMEMBER_TOKEN"]
        ]);
    }
}
