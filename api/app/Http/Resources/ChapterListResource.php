<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterListResource extends JsonResource
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
            'chapter_number' => $this->chapter_number,
            'title' => $this->title,
            'summary' => $this->summary,
            'updated_at' => $this->updated_at->format('d M Y'),
        ];
    }
}
