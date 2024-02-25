<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DB;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration(): void
    {
        DB::beginTransaction();
        $this->postJson("/api/v1/Auth/registration", [
            "USERNAME" => "Dr. Test",
            "EMAIL"    => fake()->unique()->password(10, 40),
            "PASSWORD" => fake()->unique()->password(10, 40),
            "REMEMBER" => true
        ])
            ->assertSimilarJson([
                "data" => [
                    "ERROR"    => false,
                    "ID"       => 3,
                    "USERNAME" => "Dr. Test",
                    "CHATS"    => null
                ]
            ])
            ->assertStatus(200)
            ->assertCookieNotExpired("REMEMBER_TOKEN")
        ;
        DB::commit();
    }
}
