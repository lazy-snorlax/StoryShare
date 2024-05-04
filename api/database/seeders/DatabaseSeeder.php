<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.io',
        ]);
        
        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@test.io',
        ]);
        $users = \App\Models\User::factory(5)->create();

        // Genres
        $this->call(GenreSeeder::class);

        // Stories
        $userStories = \App\Models\Story::factory(3)->create([
            'user_id' => $user->id
        ]);

        foreach ($userStories as $story) {
            // Seed genres to stories
            $story->genres()->attach(rand(1, 15));
            
            // Seed chapters to stories
            $i = 1;
            while ($i <= $story->number_of_chapters) {
                $chapter = \App\Models\Chapter::factory()->create([
                    'story_id' => $story->id,
                    'chapter_number' => $i,
                    'title' => 'Chapter ' . $i,
                    'summary' => 'This is chapter ' . $i . ' in story ' . $story->title,
                    'notes' => 'This is a section for any author notes on this chapter.',
                ]);
                $i++;
            }
        }

        // foreach ($users as $user) {
        //     \App\Models\Story::factory(rand(1, 5))->create([
        //         'user_id' => $user->id
        //     ]);
        // }
    }
}
