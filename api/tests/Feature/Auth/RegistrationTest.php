<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->postJson('api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Secret*123',
            'password_confirmation' => 'Secret*123',
        ]);
        $response->assertSuccessful();
    }
}
