<?php

namespace Tests\Unit\Models;

use App\Models\Chapter;
use App\Models\Story;
use App\Models\User;
use Database\Factories\ChapterFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanCommentOnAStoryChapter() {
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

        $response = $this->be($user)->postJson('api/comment', [
            'chapter_id' => $chapter->id,
            'content' => 'Test Comment',
            'parent_id' => $chapter->id,
        ]);

        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('user_id', $user->id)
                ->where('user_name', $user->name)
                ->where('content', 'Test Comment')
                ->where('created_at', now()->format('H:i D, d M Y'))
                ->where('updated_at', now()->format('H:i D, d M Y'))
        ));
    }

    public function testAUserCanReplyToAnotherComment() {
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

        $response = $this->be($user)->postJson('api/comment', [
            'chapter_id' => $chapter->id,
            'content' => 'Test Comment 1',
            'parent_id' => $chapter->id,
        ]);
        $response->assertSuccessful();
        
        $testUser = $this->createUser();
        $response = $this->be($testUser)->postJson('api/comment', [
            'chapter_id' => $chapter->id,
            'content' => 'Test Comment 2',
            'parent_id' => $response->json('data.id'),
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('user_id', $testUser->id)
                ->where('user_name', $testUser->name)
                ->where('content', 'Test Comment 2')
                ->where('created_at', now()->format('H:i D, d M Y'))
                ->where('updated_at', now()->format('H:i D, d M Y'))
        ));
    }
}
