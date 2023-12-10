<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'summary' => $this->faker->paragraph(5),
            'notes' => $this->faker->paragraph(2),
            'number_of_chapters' => rand(1,5),
            'posted' => fake()->randomElement([ true, false ]),
            'word_count' => rand(100, 50000),
            'complete' => fake()->randomElement([ true, false ]),
        ];
    }
}
