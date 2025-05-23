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
            'user_id' => $this->user->id,
            'imgSrc' => $this->when($this->user->profile->avatar != null, 'profile-image/' . $this->user->id, null),
            'title' => $this->title,
            'summary' => $this->summary,
            'notes' => $this->notes,
            'completed_number_of_chapters' => $this->chapters->count(),
            'total_number_of_chapters' => $this->number_of_chapters,
            'posted' => $this->posted,
            'word_count' => number_format($this->chapters->sum('word_count')),
            'visible' => $this->visible,
            'complete' => $this->complete,
            'applause_count' => number_format($this->applause_count),
            'view_count' => 0, // TODO
            'bookmark_count' => number_format($this->bookmarks_count),
            'comment_count' => 0, // TODO
            'created_at' => $this->created_at?->format('d M Y'),
            'updated_at' => $this->updated_at?->format('d M Y'),
            'rating' => $this->rating()->first()->name,
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
        ];
    }
}
