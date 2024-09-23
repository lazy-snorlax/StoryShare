<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource 
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'content' => $this->content,
            'created_at' => $this->created_at->format('H:i D, d M Y'),
            'updated_at' => $this->updated_at->format('H:i D, d M Y'),
            'replies' => CommentResource::collection($this->whenLoaded('replies'))
        ];
    }
}