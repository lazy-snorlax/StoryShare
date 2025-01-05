<?php

namespace Tests\Unit\Models;

use App\Models\Story;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class SingleStoryTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanUploadAStory() {
        $user = $this->createUser();

        $response = $this->be($user)->postJson('api/my-stories', [
            "title" => 'Test Story',
        ]);

        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('title', 'Test Story')
                ->where('summary', null)
                ->where('notes', null)
                ->where('number_of_chapters', 0)
                ->where('posted', false)
                ->where('word_count', '0')
                ->where('complete', false)
                ->where('visible', 'private')
                ->where('created_at', now()->format('d M Y'))
                ->where('updated_at', now()->format('d M Y'))
                ->where('bookmark', null)
                ->where('applauded', null)
                ->where('applause', 0)
                ->where('rating', 1)
                ->has('chapters')
        ));
    }

    public function testGuestCannotUploadAStory() {
        $response = $this->postJson('api/my-stories', [
            "title" => 'Test Story',
            "summary" => 'Test Summary',
            "rating" => 1,
            "notes" => 'Notes',
            "number_of_chapters" => 1,
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }
}