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
        Schema::connection('mysql_test');

        $responseTestStatus = $this->postJson("/api/v1/Auth/registration", [
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
            "REMEMBER" => true
        ]);

        $responseTestBody = $this->postJson("/api/v1/Auth/registration", [
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->safeEmail(),
            "PASSWORD" => fake()->unique()->password(10, 40),
            "REMEMBER" => true
        ])->decodeResponseJson();

        $responseTestStatus->assertStatus(200);
        $this->assertFalse($responseTestBody["data"]["ERROR"]);
    }
}
