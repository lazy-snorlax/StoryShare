<?php

namespace Database\Seeders\Required;

use App\Models\Role;
use App\Support\Enums\RoleType;
use App\Support\Enums\UserRole;
use Illuminate\Database\Seeder;
use App\Support\Enums\UserAbility;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::factory()->create([
            'title' => UserRole::Admin->title(),
            'name' => UserRole::Admin->value,
            'restricted' => true,
            'type' => RoleType::Admin->value
        ]);

        foreach (UserAbility::cases() as $ability) {
            $admin->allow($ability->value);
        }

        Role::create(
            ['title' => UserRole::User->title(), 'name' => UserRole::User->value, 'restricted' => true, 'type' => RoleType::User]
        );
    }
}
