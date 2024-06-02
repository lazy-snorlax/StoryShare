<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookmarkListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'private' => $this->private,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->format('d M Y'),
            'updated_at' => $this->updated_at?->format('d M Y'),
            'user' => $this->user->id,
            'story' => $this->story ? new StoryResource($this->story->load('genres')) : null
        ];
    }
}
