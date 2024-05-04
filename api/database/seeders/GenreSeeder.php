<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Fantasy',
            'Science Fiction',
            'Action',
            'Adventure',
            'Romance',
            'Comedy',
            'Drama',
            'Thriller',
            'Horror',
            'Superhero',
            'Supernatural',
            'Crime',
            'Mystery',
            'Historical',
            'Satire',
        ];

        foreach ($genres as $g) {
            Genre::firstOrCreate(['name' => $g, 'active' => true]);
        }
    }
}
