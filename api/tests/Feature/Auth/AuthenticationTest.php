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
        $this->createUser(['email' => 'john@email.com']);

        $response = $this->postJson('api/login', [
            'email' => 'john@email.com', 
            'password' => 'Secret*12345'
        ]);

        // dd($response);

        $response->assertSuccessful();
        // $response->assertSessionHas(RegistrationSession::Registration->value, false);
    }
}
