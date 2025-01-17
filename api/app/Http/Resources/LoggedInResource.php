<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoggedInResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'email_verified' => $this->when($request->user()?->id === $this->id, fn () => $this->email_verified_at !== null),
            'role' => new RoleResource($this->role),
            'abilities' => $this->whenLoaded('abilities', function () {
                return AbilityResource::collection($this->abilities->where('name', '<>', '*'));
            }),
        ];
    }
}
