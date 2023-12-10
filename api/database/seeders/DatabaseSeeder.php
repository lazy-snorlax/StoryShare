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
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.io',
        ]);
        
        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@test.io',
        ]);

        $users = \App\Models\User::factory(5)->create();

        \App\Models\Story::factory(3)->create([
            'user_id' => $user->id
        ]);

        foreach ($users as $user) {
            \App\Models\Story::factory(rand(1, 5))->create([
                'user_id' => $user->id
            ]);
        }
    }
}
