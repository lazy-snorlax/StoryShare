<?php

namespace Tests\Unit\Models;

use App\Models\Bookmark;
use App\Models\Story;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanGetAuthorProfile() {
        $user = $this->createUser();
        $story1 = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'public',
        ]);
        $story2 = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'protected',
        ]);
        $story3 = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'private',
        ]);

        $user2 = $this->createUser();
        $story4 = Story::factory()->create([
            'user_id' => $user2->id,
            'visible' => 'public',
        ]);
        $story5 = Story::factory()->create([
            'user_id' => $user2->id,
            'visible' => 'protected',
        ]);
        
        Bookmark::factory()->create([
            'private' => 0,
            'notes' => 'test',
            'user_id' => $user->id,
            'story_id' => $story4->id,
        ]);
        
        Bookmark::factory()->create([
            'private' => 0,
            'notes' => 'test',
            'user_id' => $user->id,
            'story_id' => $story5->id,
        ]);

        $response = $this->getJson('api/profile/'.$user->id);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('user_id')
                ->has('name')
                ->has('joined')
                ->has('language')
                ->has('about_me')
                ->has('recent_stories')->count('recent_stories', 1)
                ->has('recent_bookmarks')->count('recent_bookmarks', 1)
        ));
    }

    public function testUserCanGetAuthorProfile() {
        $user = $this->createUser();
        $story1 = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'public',
        ]);
        $story2 = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'protected',
        ]);
        $story3 = Story::factory()->create([
            'user_id' => $user->id,
            'visible' => 'private',
        ]);

        $user2 = $this->createUser();
        $story4 = Story::factory()->create([
            'user_id' => $user2->id,
            'visible' => 'public',
        ]);
        $story5 = Story::factory()->create([
            'user_id' => $user2->id,
            'visible' => 'protected',
        ]);
        
        Bookmark::factory()->create([
            'private' => 0,
            'notes' => 'test',
            'user_id' => $user->id,
            'story_id' => $story4->id,
        ]);
        
        Bookmark::factory()->create([
            'private' => 0,
            'notes' => 'test',
            'user_id' => $user->id,
            'story_id' => $story5->id,
        ]);

        $testUser = $this->createUser();

        $response = $this->be($testUser)->getJson('api/profile/'.$user->id);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('user_id')
                ->has('name')
                ->has('joined')
                ->has('language')
                ->has('about_me')
                ->has('recent_stories')->count('recent_stories', 2)
                ->has('recent_bookmarks')->count('recent_bookmarks', 2)
        ));
    }

    public function testGuestCannotUpdateAnAuthorProfile() {
        $user = $this->createUser();

        $response = $this->putJson('api/profile/'.$user->id);
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    public function testUserCanUpdateTheirProfile() {
        $user = $this->createUser();

        $response = $this->be($user)->putJson('api/profile/'.$user->id, [
            'language' => 'english',
            'about_me' => 'This is a test'
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('user_id')
                ->has('name')
                ->has('joined')
                ->where('language', 'english')
                ->where('about_me', 'This is a test')
                ->has('recent_stories')->count('recent_stories', 0)
                ->has('recent_bookmarks')
        ));
    }

    public function testUserCannotUpdateAnothersProfile() {
        $user = $this->createUser();
        $testUser =$this->createUser();

        $response = $this->be($testUser)->putJson('api/profile/'.$user->id, [
            'language' => 'english',
            'about_me' => 'This is a test'
        ]);
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'You do not have access to this profile.']);
    }

    public function testGuestCanGetProfileImage() {
        $user = $this->createUser();
        $payload = [
            'file' => UploadedFile::fake()->image('photo.jpg')
        ];

        $response = $this->be($user)->postJson('api/profile-image/'.$user->id, $payload);
        $response->assertSuccessful();

        $response = $this->getJson('api/profile-image/'.$user->id);
        $response->assertSuccessful();
    }

    public function testUserCanUploadAProfileImage() {
        $user = $this->createUser();
        $payload = [
            'file' => UploadedFile::fake()->image('photo.jpg')
        ];

        $response = $this->be($user)->postJson('api/profile-image/'.$user->id, $payload);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->has('name')
                ->has('email')
                ->has('email_verified')
                ->has('avatar')
                ->has('imgSrc')
                ->has('joined')
                ->has('language')
                ->has('about_me')
                ->has('role')
                ->has('preferences')
        ));
    }
}