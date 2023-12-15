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
            'notes' => $this->notes,
            'updated_at' => $this->updated_at->format('d M Y'),
        ];
    }
}