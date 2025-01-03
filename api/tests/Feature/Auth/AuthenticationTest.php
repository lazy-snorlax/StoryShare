<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\isNull;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testCanLoginWithCorrectEmailAndPassword()
    {
        $this->createUser(['email' => 'john@email.com']);
        $response = $this->postJson('api/login', [
            'email' => 'john@email.com', 
            'password' => 'Secret*12345',
        ]);

        $response->assertSuccessful();
    }

    // public function testCanSeeUserIsLockedOutAfterTooManyLoginAttemptsWithIncorrectDetails() {
    //     $this->createAdmin(['email' => 'admin@email.com']);

    //     $attempts = config('auth.limiters.login.max_attempts');

    //     while ($attempts > 0) {
    //         $this->postJson('login', ['email' => 'john@email.com', 'password' => 'Incorrect*12345'])->assertStatus(422);
    //         $attempts--;
    //     }

    //     // 6th time is with correct information but denied due to already being locked out.
    //     $response = $this->postJson('login', [
    //         'email' => 'john@email.com', 
    //         'password' => 'Secret*12345'
    //     ]);
    //     $response->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
    //     $response->assertJsonFragment([
    //         'email' => [
    //         'Due to 5 failed login attempts your IP and email address has been locked out for 30 minutes'
    //     ]]);
    // }

    public function testCanGetLoggedInUser() {        
        $response = $this->be($user = $this->createAdmin())->getJson('api/user');
        $response->assertSuccessful();
        
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $user->id)
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->where('email_verified', !!isNull($user->email_verified_at))
                ->has('abilities')
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                    ->where('type', $user->role->type)
                    ->has('abilities')
                )
        ));
    }

    public function testCannotLoginWithInvalidEmail() {
        $response = $this->postJson('api/login', ['email' => 'john@email.com', 'password' => 'Secret*12345']);
        $response->assertStatus(422);
        $response->assertJsonFragment(['email' => ['These credentials do not match our records.']]);
    }

    public function testCannotLoginWithInvalidPassword()
    {
        $this->createAdmin(['email' => 'john@email.com']);

        $response = $this->postJson('api/login', ['email' => 'john@email.com', 'password' => 'Secret*32145']);
        $response->assertStatus(422);
        $response->assertJsonFragment(['email' => ['These credentials do not match our records.']]);
    }
}
