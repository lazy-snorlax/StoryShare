<?php

namespace Tests\Unit\Models;

use Database\Seeders\RatingSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SingleStoryTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanUploadAStory() {
        $user = $this->createUser();

        $response = $this->be($user)->postJson('api/my-stories', [
            "title" => 'Test Story',
            "summary" => 'Test Summary',
            "rating" => 1,
            "notes" => 'Notes',
            "number_of_chapters" => 1,
        ]);

        $response->assertSuccessful();
    }
}