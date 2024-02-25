<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "USERNAME"       => "Fake name",
            "EMAIL"          => fake()->unique()->safeEmail(),
            "PASSWORD"       => fake()->unique()->password(),
            "REMEMBER_TOKEN" => app("RememberTokenManager")::createRememberToken()
        ];
    }
}
