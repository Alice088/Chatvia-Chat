<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration(): void
    {
        $username = "Dr. Test";
        $email    = fake()->unique()->safeEmail();
        $password = fake()->unique()->password(10, 40);
        $remember = true;

        $responseTestStatus = $this->postJson("/api/v1/Auth/registration", [
            "USERNAME" => $username,
            "EMAIL"    => fake()->unique()->password(10, 40),
            "PASSWORD" => $password,
            "REMEMBER" => $remember
        ]);

        $responseTestBody = $this->postJson("/api/v1/Auth/registration", [
            "USERNAME" => $username,
            "EMAIL"    => $email,
            "PASSWORD" => $password,
            "REMEMBER" => $remember
        ])->decodeResponseJson();

        $resJsonExpect = json_encode([
            "ERROR"    => false,
            "ID"       => $responseTestBody["data"]["ID"],
            "USERNAME" => $username,
            "CHATS"    => null
        ]);
        $resJsonGot    = json_encode($responseTestBody["data"]);

        $responseTestStatus->assertStatus(200);
        $this->assertFalse($responseTestBody["data"]["ERROR"]);
        $this->assertTrue(strcmp($resJsonExpect, $resJsonGot) === 0);
    }
}
