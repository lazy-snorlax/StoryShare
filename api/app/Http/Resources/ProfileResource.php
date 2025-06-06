<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'name' => $this->user->name,
            'joined' => $this->user->created_at->format('d M Y'),
            'about_me' => $this->about_me,
            'language' => $this->language,
            'imgSrc' => $this->when($this->avatar != null, 'profile-image/' . $this->id, null),
            'recent_stories' => StoryListResource::collection($this->recent_stories),
            'recent_bookmarks' => BookmarkListResource::collection($this->recent_bookmarks),
        ];
    }
}