<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ChapterListResource;

class StoryResource extends JsonResource
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
            'author' => $this->whenLoaded($this->user->name),
            'title' => $this->title,
            'summary' => $this->summary,
            'notes' => $this->notes,
            'number_of_chapters' => $this->number_of_chapters,
            'posted' => $this->posted,
            'word_count' => $this->word_count,
            'complete' => $this->complete,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
            'chapters' => ChapterListResource::collection($this->whenLoaded('chapters')),
        ];
    }
}