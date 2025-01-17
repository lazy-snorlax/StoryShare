<?php

namespace Tests\Unit\Models;

use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Story;
use App\Models\User;
use Database\Factories\ChapterFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class ApplauseTest extends TestCase
{
    use RefreshDatabase;

    public function testAGuestCanApplaudeAStory() {
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

        $response = $this->postJson('api/applause', [
            'ip_address' => '127.0.0.1',
            'story_id' => $story->id,
        ]);
        $response->assertSuccessful();
        $response->assertJsonFragment(['You applauded this story']);
    }

    public function testAUserCanApplaudeAStory() {
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
        $response = $this->be($testUser)->postJson('api/applause', [
            // 'ip_address' => '127.0.0.1',
            'story_id' => $story->id,
        ]);
        $response->assertSuccessful();
        $response->assertJsonFragment(['You applauded this story']);
    }

    public function testAUserCannotApplaudeOwnStory() {
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
        
        $response = $this->be($user)->postJson('api/applause', [
            'story_id' => $story->id,
        ]);
        $response->assertStatus(504);
        $response->assertJsonFragment(['You cannot applaude your own story!']);
    }

    public function testAGuestCanApplaudeAStoryOnce() {
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
        $response = $this->postJson('api/applause', [
            'ip_address' => '127.0.0.1',
            'story_id' => $story->id,
        ]);
        $response->assertSuccessful();
        $response->assertJsonFragment(['You applauded this story']);
        
        $response = $this->postJson('api/applause', [
            'ip_address' => '127.0.0.1',
            'story_id' => $story->id,
        ]);
        $response->assertStatus(504);
        $response->assertJsonFragment(['You have already applauded this story']);
    }

    public function testAUserCanApplaudeAStoryOnce() {
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
        $response = $this->be($testUser)->postJson('api/applause', [
            // 'ip_address' => '127.0.0.1',
            'story_id' => $story->id,
        ]);
        $response->assertSuccessful();
        $response->assertJsonFragment(['You applauded this story']);
        
        $response = $this->be($testUser)->postJson('api/applause', [
            // 'ip_address' => '127.0.0.1',
            'story_id' => $story->id,
        ]);
        $response->assertStatus(504);
        $response->assertJsonFragment(['You have already applauded this story']);
    }
}
