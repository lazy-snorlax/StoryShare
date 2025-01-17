<?php

namespace Tests\Unit\Models;

use App\Models\Chapter;
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

    public function testUserCanAddAChapter() {
        $user = $this->createUser();

        $story = Story::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->be($user)->postJson('api/my-chapters', [
            'story_id' => $story->id,
            'title' => 'Test Chapter',
        ]);

        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('title', 'Test Chapter')
                ->where('chapter_number', 0)
                ->where('story_id', $story->id)
                ->where('summary', null)
                ->where('content', null)
                ->where('word_count', '0')
                ->where('notes', null)
                ->where('updated_at', now()->format('d M Y'))
        ));
    }

    public function testUserCanAddAndModifyAChapter() {
        $user = $this->createUser();
        $story = Story::factory()->create([
            'user_id' => $user->id
        ]);

        $chapter = Chapter::factory()->create([
            'story_id' => $story->id,
            'chapter_number' => 1,
            'title' => 'Chapter ' . 1,
            'summary' => 'This is chapter ' . 1 . ' in story ' . $story->title,
            'notes' => 'This is a section for any author notes on this chapter.',
        ]);

        $response = $this->be($user)->putJson('api/my-chapters/'. $chapter->id, [
            'chapter_number' => 1,
            'title' => 'Chapter ' . 1,
            'summary' => 'This is a chapter in the story ' . $story->title,
            'content' => 'This is where chapter content goes.',
            'word_count' => 6,
            'notes' => 'Author notes for the chapter go here.',
        ]);
        // dd($response);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('title', 'Chapter 1')
                ->where('chapter_number', 1)
                ->where('story_id', $story->id)
                ->where('summary', 'This is a chapter in the story ' . $story->title)
                ->where('content', 'This is where chapter content goes.')
                ->where('word_count', '6')
                ->where('notes', 'Author notes for the chapter go here.')
                ->where('updated_at', now()->format('d M Y'))
        ));
    }

    public function testGuestCannotUploadAChapterToStory() {
        $user = $this->createUser();
        $story = Story::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->postJson('api/my-chapters', [
            'story_id' => $story->id,
            'title' => 'Test Chapter',
        ]);
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    public function testAnotherUserCannotUploadAChapterToStoryTheyDontOwn() {
        $user = $this->createUser();
        $story = Story::factory()->create([
            'user_id' => $user->id
        ]);
        
        $testUser = $this->createUser();
        $response = $this->be($testUser)->postJson('api/my-chapters', [
            'story_id' => $story->id,
            'title' => 'Test Chapter',
        ]);
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'You are not authorized for this action']);
    }

    public function testAnotherUserCannotModifyAChapterToStoryTheyDontOwn() {
        $user = $this->createUser();
        $story = Story::factory()->create([
            'user_id' => $user->id
        ]);
        $chapter = Chapter::factory()->create([
            'story_id' => $story->id,
            'chapter_number' => 1,
            'title' => 'Chapter ' . 1,
            'summary' => 'This is chapter ' . 1 . ' in story ' . $story->title,
            'notes' => 'This is a section for any author notes on this chapter.',
        ]);
        
        $testUser = $this->createUser();
        $response = $this->be($testUser)->putJson('api/my-chapters/'. $chapter->id, [
            'chapter_number' => 1,
            'title' => 'Chapter ' . 1,
            'summary' => 'This is a chapter in the story ' . $story->title,
            'content' => 'This is where chapter content goes.',
            'word_count' => 6,
            'notes' => 'Author notes for the chapter go here.',
        ]);
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'You are not authorized for this action']);
    }
}