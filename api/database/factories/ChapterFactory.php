<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
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
            'summary' => $this->faker->paragraph(3),
            'content' => $this->faker->paragraphs(rand(20,100), true),
            'word_count' => rand(100, 50000),
            'notes' => $this->faker->paragraph(2),
        ];
    }
}
