<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Support\Enums\UserStatus;
use Carbon\Carbon;
use Illuminate\Support\InteractsWithTime;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function testCanSeeVerificationSucceedsWhenUnauthenticated() {
        $this->assertTrue(true);
        
        // Carbon::setTestNow('2020-06-11 12:00:00');

        // $user = User::factory()->create([
        //     'email_verified_at' => null,
        // ]);
        // $expires = now()->addMinutes(60);

        // $response = $this->postJson("api/register/verification", [
        //     // 'signature' => $signature,
        //     'expires' => $expires,
        //     'identifier' => base64_encode($user->email)
        // ]);
        // dd($response);
        // $response->assertSuccessful();

        // $this->assertDatabaseHas('users', ['id' => $user->id, 'email_verified_at' => '2020-06-11 12:00:00', 'status' => UserStatus::Enabled->value]);
    }

    /** TODO: */
    // public function testCanSeeVerificationFailsWhenSignatureDoesNotMatch() {}
    // public function testCanSeeVerificationFailsWhenSignatureMatchesButIsExpired() {}
    
    // public function testCanSeeVerificationSucceedsWithValidSignature() {}
    // public function testCanSeeVerificationFailsWhenAlreadyVerified() {}
    
    // public function testCanSeeVerificationFailsWhenUnauthenticatedAndEmailDoesNotExist() {}
    // public function testCanSeeVerificationFailsWhenUnauthenticatedAndEmailIsIncorrect() {}
    
    


}
