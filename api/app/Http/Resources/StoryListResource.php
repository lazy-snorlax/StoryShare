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
            'user_id' => $this->user_id,
            'title' => $this->title,
            'summary' => $this->summary,
            'notes' => $this->notes,
            'number_of_chapters' => $this->number_of_chapters,
            'posted' => $this->posted,
            'word_count' => $this->word_count,
            'complete' => $this->complete,
        ];
    }
}
