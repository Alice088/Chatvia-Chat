<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use DB;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_login(): void
    {
        $username = "Dr. Test";
        $email    = fake()->unique()->safeEmail();
        $password = fake()->unique()->password(10, 40);
        $remember = app("RememberTokenManager")::createRememberToken();

        DB::beginTransaction();
        User::add([
            "USERNAME" => $username,
            "EMAIL"    => $email,
            "PASSWORD" => $password,
            "REMEMBER_TOKEN" => $remember
        ]);
        DB::commit();

        $this->postJson('/api/v1/Auth/login', [
            "USERNAME" => $username,
            "EMAIL"    => $email,
            "PASSWORD" => $password,
            "REMEMBER" => true
        ])->assertStatus(200)
            ->assertCookieNotExpired("REMEMBER_TOKEN")
            ->assertSimilarJson([
                "data" => [
                    "ERROR"    => false,
                    "ID"       => 1,
                    "USERNAME" => "Dr. Test",
                    "CHATS"    => null
                ]
            ])
        ;
    }

    public function test_quickLogin(): void
    {
        $cookies = $this->postJson("/api/v1/Auth/registration", [
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
            "REMEMBER" => true
        ])
            ->assertStatus(200)
            ->getCookie("REMEMBER_TOKEN", false)
        ;

        $this->call("GET", '/api/v1/Auth/quickLogin', [], ["REMEMBER_TOKEN" => $cookies->getValue()])
            ->assertStatus(200)
            ->assertSimilarJson([
                "data" => [
                    "ERROR"    => false,
                    "ID"       => 2,
                    "USERNAME" => "Dr. Test",
                    "CHATS"    => null
                ]
            ])
        ;
    }
}
