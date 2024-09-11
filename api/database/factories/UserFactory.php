<?php

namespace Database\Factories;

use App\Support\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'Secret*12345', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function enabled()
    {
        return $this->state(['status' => UserStatus::Enabled->value]);
    }

    public function archived()
    {
        return $this->state(['status' => UserStatus::Archived->value]);
    }

    public function pending()
    {
        return $this->state(['status' => UserStatus::Pending->value, 'email_verified_at' => null]);
    }

    public function user()
    {
        return $this;
    }
}
