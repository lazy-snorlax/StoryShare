<?php

namespace Tests\Unit\Models;

use App\Models\Story;
use App\Models\User;
use Database\Seeders\RatingSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

use function PHPUnit\Framework\isNull;

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
    
    public function testGuestsCanAccessAPublicStory() {
        $user = User::factory()->user()->create();
        $userStory = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'public',
            'posted' => false
        ]);
        
        $response = $this->getJson('api/stories/' . $userStory->id);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $userStory->id)
                ->where('title', $userStory->title)
                ->where('summary', $userStory->summary)
                ->where('notes', $userStory->notes)
                ->where('number_of_chapters', $userStory->number_of_chapters)
                ->has('posted')
                ->has('word_count')
                ->has('complete')
                ->where('visible', $userStory->visible)
                ->where('created_at', $userStory->created_at->format('d M Y'))
                ->where('updated_at', $userStory->updated_at->format('d M Y'))
                ->where('bookmark', $userStory->bookmark)
                ->where('applauded', $userStory->applauded)
                ->has('applause')
                ->has('rating')
                ->has('genres')
                ->has('chapters')
            ));
    }
}