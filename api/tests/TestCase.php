<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\GenreSeeder;
use Database\Seeders\RatingSeeder;
use Silber\Bouncer\BouncerFacade;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup test case
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->setUpParallel();

        parent::setUp();

        $this->withoutMiddleware([ThrottleRequests::class]);
        $this->withHeaders(['referer' => env('APP_URL')]);

        // If method doesn't exist automatically verify two factor, otherwise check result of
        // method to determine if it should be verified or not.
        // phpcs:ignore
        if (!method_exists($this, 'shouldTwoFactorBeVerified') || $this->shouldTwoFactorBeVerified()) {
            $this->withTwoFactorVerified();
        }

        // Disable bouncer caching
        BouncerFacade::dontCache();

        if (in_array(RefreshDatabase::class, class_uses_recursive($this))) {
            Artisan::call('abilities:refresh');
            $this->seed(GenreSeeder::class);
            $this->seed(RatingSeeder::class);
        }

        // Reset model results per page to 50.
        // Model::resultsPerPage(50);

        Storage::fake();
    }

    /**
     * With two factor verification.
     */
    protected function withTwoFactorVerified(): self
    {
        return $this->withSession(['two_factor_verified' => true]);
    }

    /**
     * Without two factor verification.
     */
    protected function withoutTwoFactorVerified(): self
    {
        return $this->withSession(['two_factor_verified' => false]);
    }

    /**
     * Setup tests to run in parallel.
     *
     * @return void
     */
    protected function setUpParallel()
    {
        if (($parallel = getenv('TEST_TOKEN')) !== false) {
            putenv("DB_TESTING_DATABASE=testing_{$parallel}");
        }
    }

    /**
     * Create a user.
     */
    public function createUser(array $attributes = []): User
    {
        return User::factory()->user()->enabled()->create($attributes);
    }

    /**
     * Create an admin.
     */
    public function createAdmin(array $attributes = []): User
    {
        return User::factory()->admin()->enabled()->create($attributes);
    }
}
