<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testCanLoginWithCorrectEmailAndPassword()
    {
        $this->createAdmin(['email' => 'john@email.com']);

        $response = $this->postJson('login', [
            'email' => 'john@email.com', 
            'password' => 'Secret*12345'
        ]);
        $response->assertSuccessful();
        // $response->assertSessionHas(RegistrationSession::Registration->value, false);
    }
}
