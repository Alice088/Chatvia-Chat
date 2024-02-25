<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use DB;

class ResetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset(): void
    {
        $username = "Dr. Test";
        $email    = fake()->unique()->safeEmail();
        $password = fake()->unique()->password(10, 40);
        $remember = app("RememberTokenManager")::createRememberToken();

        DB::beginTransaction();
        User::add([
            "USERNAME"       => $username,
            "EMAIL"          => $email,
            "PASSWORD"       => $password,
            "REMEMBER_TOKEN" => $remember
        ]);
        DB::commit();

        DB::beginTransaction();
        $this->patch("/api/v1/Auth/reset?EMAIL=" . $email)
            ->assertStatus(200)
            ->assertSimilarJson([
                "data" => [
                    "ERROR"    => false,
                ]
            ])
        ;
        DB::commit();
    }
}
