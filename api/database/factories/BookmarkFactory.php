<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookmarkFactory extends Factory
{
    public function definition()
    {
        return [
            'private' => 0,
            'notes' => $this->faker->sentence(),
        ];
    }
}