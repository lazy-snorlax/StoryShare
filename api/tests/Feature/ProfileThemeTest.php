<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

use function PHPUnit\Framework\isNull;

class ProfileThemeTest extends TestCase
{
    use RefreshDatabase;

    public function testuserCanUploadANewTheme(): void {
        $user = $this->createUser();
        $response = $this->be($user)->postJson('api/profile/theme', [
            "theme" => [
                "black" => '#000000',
                "dark" => '#000000',
                "darkAlt" => '#FFFFFF',
                "grey" => '#000000',
                "light" => '#FFFFFF',
                "lightAlt" => '#000000',
                "primary" => '#FFFFFF',
                "primaryAlt" => '#000000',
                "white" => '#FFFFFF',
            ],
            "themeName" => "black/white theme",
        ]);

        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->where('email_verified', !!isNull($user->email_verified_at))
                ->has('abilities')
                ->where('avatar', !isNull($user->profile->avatar))
                ->has('imgSrc')
                ->has('joined')
                ->where('language', $user->profile->language)
                ->where('about_me', $user->profile->about_me)
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                    ->where('type', $user->role->type)
                    ->has('abilities')
                )
                ->has('preferences', fn (AssertableJson $json) => $json
                    ->has('themes', fn (AssertableJson $json) => $json
                        ->has('black/white theme', fn (AssertableJson $json) => $json
                            ->where("black", "#000000")
                            ->where("dark", "#000000")
                            ->where("darkAlt", "#FFFFFF")
                            ->where("grey", "#000000")
                            ->where("light", "#FFFFFF")
                            ->where("lightAlt", "#000000")
                            ->where("primary", "#FFFFFF")
                            ->where("primaryAlt", "#000000")
                            ->where("white", "#FFFFFF")
                        )
                    )
                )
        ));
    }

    public function testUserCanSetATheme(): void {
        $user = $this->createUser();
        $response = $this->be($user)->postJson('api/profile/theme', [
            "theme" => [
                "black" => '#000000',
                "dark" => '#000000',
                "darkAlt" => '#FFFFFF',
                "grey" => '#000000',
                "light" => '#FFFFFF',
                "lightAlt" => '#000000',
                "primary" => '#FFFFFF',
                "primaryAlt" => '#000000',
                "white" => '#FFFFFF',
            ],
            "themeName" => "black/white theme",
        ]);
        $response->assertSuccessful();

        $response = $this->be($user)->postJson('api/profile/dark', [
            "themeName" => "black/white theme",
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->where('email_verified', !!isNull($user->email_verified_at))
                ->has('abilities')
                ->where('avatar', !isNull($user->profile->avatar))
                ->has('imgSrc')
                ->has('joined')
                ->where('language', $user->profile->language)
                ->where('about_me', $user->profile->about_me)
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                    ->where('type', $user->role->type)
                    ->has('abilities')
                )
                ->has('preferences', fn (AssertableJson $json) => $json
                    ->where("defaultDark", "black/white theme")
                    ->has('themes', fn (AssertableJson $json) => $json
                        ->has('black/white theme', fn (AssertableJson $json) => $json
                            ->where("black", "#000000")
                            ->where("dark", "#000000")
                            ->where("darkAlt", "#FFFFFF")
                            ->where("grey", "#000000")
                            ->where("light", "#FFFFFF")
                            ->where("lightAlt", "#000000")
                            ->where("primary", "#FFFFFF")
                            ->where("primaryAlt", "#000000")
                            ->where("white", "#FFFFFF")
                        )
                    )
                )
        ));
    }

    public function testUserCanUnSetATheme(): void {
        $user = $this->createUser();
        $response = $this->be($user)->postJson('api/profile/theme', [
            "theme" => [
                "black" => '#000000',
                "dark" => '#000000',
                "darkAlt" => '#FFFFFF',
                "grey" => '#000000',
                "light" => '#FFFFFF',
                "lightAlt" => '#000000',
                "primary" => '#FFFFFF',
                "primaryAlt" => '#000000',
                "white" => '#FFFFFF',
            ],
            "themeName" => "black/white theme",
        ]);
        $response->assertSuccessful();

        $response = $this->be($user)->postJson('api/profile/dark', [
            "themeName" => null,
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->where('email_verified', !!isNull($user->email_verified_at))
                ->has('abilities')
                ->where('avatar', !isNull($user->profile->avatar))
                ->has('imgSrc')
                ->has('joined')
                ->where('language', $user->profile->language)
                ->where('about_me', $user->profile->about_me)
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                    ->where('type', $user->role->type)
                    ->has('abilities')
                )
                ->has('preferences', fn (AssertableJson $json) => $json
                    ->where("defaultDark", null)
                    ->has('themes', fn (AssertableJson $json) => $json
                        ->has('black/white theme', fn (AssertableJson $json) => $json
                            ->where("black", "#000000")
                            ->where("dark", "#000000")
                            ->where("darkAlt", "#FFFFFF")
                            ->where("grey", "#000000")
                            ->where("light", "#FFFFFF")
                            ->where("lightAlt", "#000000")
                            ->where("primary", "#FFFFFF")
                            ->where("primaryAlt", "#000000")
                            ->where("white", "#FFFFFF")
                        )
                    )
                )
        ));
    }

    public function testUserCanRemoveATheme(): void {
        $user = $this->createUser();
        $response = $this->be($user)->postJson('api/profile/theme', [
            "theme" => [
                "black" => '#000000',
                "dark" => '#000000',
                "darkAlt" => '#FFFFFF',
                "grey" => '#000000',
                "light" => '#FFFFFF',
                "lightAlt" => '#000000',
                "primary" => '#FFFFFF',
                "primaryAlt" => '#000000',
                "white" => '#FFFFFF',
            ],
            "themeName" => "black/white theme",
        ]);
        $response->assertSuccessful();

        $response = $this->be($user)->postJson('api/profile/remove-theme', [
            "themeName" => "black/white theme",
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->where('email_verified', !!isNull($user->email_verified_at))
                ->has('abilities')
                ->where('avatar', !isNull($user->profile->avatar))
                ->has('imgSrc')
                ->has('joined')
                ->where('language', $user->profile->language)
                ->where('about_me', $user->profile->about_me)
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                    ->where('type', $user->role->type)
                    ->has('abilities')
                )
                ->has('preferences', fn (AssertableJson $json) => $json
                    ->has('themes', fn (AssertableJson $json) => $json->count(0))
                )
        ));
    }


    public function testUserCanSetAndRemoveTheme(): void {
        $user = $this->createUser();
        $response = $this->be($user)->postJson('api/profile/theme', [
            "theme" => [
                "black" => '#000000',
                "dark" => '#000000',
                "darkAlt" => '#FFFFFF',
                "grey" => '#000000',
                "light" => '#FFFFFF',
                "lightAlt" => '#000000',
                "primary" => '#FFFFFF',
                "primaryAlt" => '#000000',
                "white" => '#FFFFFF',
            ],
            "themeName" => "black/white theme",
        ]);
        $response->assertSuccessful();

        $response = $this->be($user)->postJson('api/profile/dark', [
            "themeName" => "black/white theme",
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->where('email_verified', !!isNull($user->email_verified_at))
                ->has('abilities')
                ->where('avatar', !isNull($user->profile->avatar))
                ->has('imgSrc')
                ->has('joined')
                ->where('language', $user->profile->language)
                ->where('about_me', $user->profile->about_me)
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                    ->where('type', $user->role->type)
                    ->has('abilities')
                )
                ->has('preferences', fn (AssertableJson $json) => $json
                    ->where("defaultDark", "black/white theme")
                    ->has('themes', fn (AssertableJson $json) => $json
                        ->has('black/white theme', fn (AssertableJson $json) => $json
                            ->where("black", "#000000")
                            ->where("dark", "#000000")
                            ->where("darkAlt", "#FFFFFF")
                            ->where("grey", "#000000")
                            ->where("light", "#FFFFFF")
                            ->where("lightAlt", "#000000")
                            ->where("primary", "#FFFFFF")
                            ->where("primaryAlt", "#000000")
                            ->where("white", "#FFFFFF")
                        )
                    )
                )
        ));

        $response = $this->be($user)->postJson('api/profile/remove-theme', [
            "themeName" => "black/white theme",
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->where('email_verified', !!isNull($user->email_verified_at))
                ->has('abilities')
                ->where('avatar', !isNull($user->profile->avatar))
                ->has('imgSrc')
                ->has('joined')
                ->where('language', $user->profile->language)
                ->where('about_me', $user->profile->about_me)
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                    ->where('type', $user->role->type)
                    ->has('abilities')
                )
                ->has('preferences', fn (AssertableJson $json) => $json
                    ->where("defaultDark", null)
                    ->has('themes', fn (AssertableJson $json) => $json->count(0))
                )
        ));
    }
}