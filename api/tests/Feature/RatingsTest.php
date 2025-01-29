<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class RatingsTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCannotSeeExplicitRating(): void {
        $response = $this->getJson('api/ratings');

        $response->assertSuccessful();
        $response->assertJson(['data' => [
            [
                "id" => 1,
                "name" => "General",
                "description" => "For general audiences"
            ],
            [
                "id" => 2,
                "name" => "Teen",
                "description" => "Teens"
            ],
            [
                "id" => 3,
                "name" => "Young Adult",
                "description" => "Aimed for young adults"
            ],
            [
                "id" => 4,
                "name" => "Mature",
                "description" => "For mature theme"
            ]
        ]]);
    }

    public function testUserCanSeeExplicitRating(): void {
        $user = $this->createUser();
        $response = $this->be($user)->getJson('api/ratings');

        $response->assertSuccessful();
        $response->assertJson(['data' => [
            [
                "id" => 1,
                "name" => "General",
                "description" => "For general audiences"
            ],
            [
                "id" => 2,
                "name" => "Teen",
                "description" => "Teens"
            ],
            [
                "id" => 3,
                "name" => "Young Adult",
                "description" => "Aimed for young adults"
            ],
            [
                "id" => 4,
                "name" => "Mature",
                "description" => "For mature theme"
            ],
            [
                "id" => 5,
                "name" => "Explicit",
                "description" => "Graphic Violence or Sex scences should go here"
            ],
        ]]);
    }
}