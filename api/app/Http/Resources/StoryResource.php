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
            'word_count' => number_format($this->chapters->sum('word_count')),
            'complete' => $this->complete,
            'visible' => $this->visible,
            'created_at' => $this->created_at->format('d M Y'),
            'updated_at' => $this->updated_at->format('d M Y'),
            'bookmark' => $request->user() ? $request->user()->bookmarks()->where('story_id', $this->id)->first() : null,
            'applauded' => $request->user() ? $request->user()->applause()->where('story_id', $this->id)->first() : null,
            'applause' => $this->applause()->count(),
            'rating' => $this->rating()->first()->id,
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
            'chapters' => ChapterListResource::collection($this->whenLoaded('chapters')),
        ];
    }
}