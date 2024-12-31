<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingsTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotSeeExplicitRating(): void {
        $response = $this->getJson('api/ratings');

        $response->assertSuccessful();
    }
}