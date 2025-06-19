<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User\Profile;
use App\Support\Enums\UserStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Nette\Utils\Random;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Genres
        $this->call(GenreSeeder::class);
        $this->call(RatingSeeder::class);
        $this->callWith(Required\RoleSeeder::class);

        // Artisan::call('abilities:refresh');

        // Admin User
        $admin = \App\Models\User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.io',
            'status' => UserStatus::Enabled->value,
        ]);
        Profile::factory()->for($admin)->create();
        
        // User
        $user = \App\Models\User::factory()->user()->create([
            'name' => 'User',
            'email' => 'user@test.io',
            'status' => UserStatus::Enabled->value,
        ]);
        Profile::factory()->for($user)->create();
        
        // Generate Data for local dev use
        if (app()->environment('local')) {
            $users = \App\Models\User::factory(5)->user()->create();
            foreach ($users as $u) {
                Profile::factory()->for($u)->create();
                $u->status = UserStatus::Enabled->value;
            }

            // Stories for primary user
            $userStories = \App\Models\Story::factory(3)->create([
                'user_id' => $user->id
            ]);
            
            // Stories for other users
            $visible = ['protected', 'public'];
            $stories = \App\Models\Story::factory(50)->create([
                'user_id' => $user->id,
                'visible' => $visible[array_rand($visible)]
            ]);
            
            foreach ($stories as $story) {
                $story->user_id = $users->random(1)->first()->id;
                $story->save();
    
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
        }
    }
}
