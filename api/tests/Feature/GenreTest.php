<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsCanSeeGenres(): void {
        $response = $this->getJson('api/genres');
        $response->assertSuccessful();
        // $response->assertJson(fn (AssertableJson $json) => $json
        //     ->has('data', fn (AssertableJson $json) => $json)
        // );
    }
}