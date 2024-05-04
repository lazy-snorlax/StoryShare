<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryListResource extends JsonResource
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
            'user' => $this->user->name,
            'title' => $this->title,
            'summary' => $this->summary,
            'notes' => $this->notes,
            'number_of_chapters' => $this->number_of_chapters,
            'posted' => $this->posted,
            'word_count' => $this->word_count,
            'visible' => $this->visible,
            'complete' => $this->complete,
            'created_at' => $this->created_at->format('d M Y'),
            'updated_at' => $this->updated_at->format('d M Y'),
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
        ];
    }
}
