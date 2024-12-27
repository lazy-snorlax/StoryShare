<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'chapter_number' => $this->chapter_number,
            'story_id' => $this->story_id,
            'summary' => $this->summary,
            'content' => $this->content,
            'word_count' => number_format($this->word_count),
            'notes' => $this->notes,
            'updated_at' => $this->updated_at->format('d M Y'),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'story' => new StoryResource($this->whenLoaded('story')),
        ];
    }
}