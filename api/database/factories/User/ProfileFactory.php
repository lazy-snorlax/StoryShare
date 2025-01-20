<?php

namespace Database\Factories\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'about_me' => $this->faker->paragraph(3),
            'language' => $this->faker->languageCode(),
        ];
    }
}