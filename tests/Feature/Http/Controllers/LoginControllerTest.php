<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_login(): void
    {
        $username = "Dr. Test";
        $email    = fake()->unique()->safeEmail();
        $password = fake()->unique()->password(10, 40);
        $remember = true;

        $responseRegistration = $this->post("/api/v1/Auth/registration", [
            "USERNAME" => $username,
            "EMAIL"    => $email,
            "PASSWORD" => $password,
            "REMEMBER" => $remember
        ])->decodeResponseJson();

        $responseLoginTestStatus = $this->post('/api/v1/Auth/login');
        $responseLoginTestBody   = $this->post('/api/v1/Auth/login', [
            "USERNAME" => $username,
            "EMAIL"    => $email,
            "PASSWORD" => $password,
            "REMEMBER" => $remember
        ])->decodeResponseJson();

        $resJsonExpect = json_encode([
            "ERROR"    => false,
            "ID"       => $responseRegistration["data"]["ID"],
            "USERNAME" => $username,
            "CHATS"    => null
        ]);
        $resJsonGot    = json_encode($responseLoginTestBody["data"]);

        $responseLoginTestStatus->assertStatus(200);
        $this->assertTrue(strcmp($resJsonExpect, $resJsonGot) === 0);
        $this->assertFalse($responseRegistration["data"]["ERROR"]);
        $this->assertFalse($responseLoginTestBody["data"]["ERROR"]);

    }
}
