<?php

namespace Tests\Unit\Models;

use App\Models\Story;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class SingleStoryAccessTest extends TestCase
{
    use RefreshDatabase;

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
    
    public function testGuestsCannotAccessAProtectedStory() {
        $user = User::factory()->user()->create();
        $userStory = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'protected',
            'posted' => false
        ]);
        
        $response = $this->getJson('api/stories/' . $userStory->id);
        $response->assertStatus(403);
        $response->assertJsonFragment(['message' => 'You must login to view this story']);
    }
    
    public function testGuestsCannotAccessAPrivateStory() {
        $user = User::factory()->user()->create();
        $userStory = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'private',
            'posted' => false
        ]);
        
        $response = $this->getJson('api/stories/' . $userStory->id);
        $response->assertStatus(403);
        $response->assertJsonFragment(['message' => 'You must login to view this story']);
    }
    
    public function testLoggedInUserCanAccessAProtectedStory() {
        $user = User::factory()->user()->create();
        $userStory = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'protected',
            'posted' => false
        ]);

        $test = $this->createUser();
        $response = $this->be($test)->getJson('api/stories/' . $userStory->id);
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
    
    public function testLoggedInUserCannotAccessAPrivateStory() {
        $user = User::factory()->user()->create();
        $userStory = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'private',
            'posted' => false
        ]);

        $test = $this->createUser();
        $response = $this->be($test)->getJson('api/stories/' . $userStory->id);
        $response->assertStatus(403);
        $response->assertJsonFragment(['message' => 'This story has been marked private by the author. You cannot access it.']);
    }
}