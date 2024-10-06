<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ratings = [
            'General',
            'Teen',
            'Young Adult',
            'Mature',
            'Explicit',
        ];

        foreach ($ratings as $g) {
            Rating::firstOrCreate(['name' => $g, 'active' => true]);
        }
    }
}
