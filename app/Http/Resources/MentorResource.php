<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'bio' => $this->bio,
            'avatar_seed' => $this->avatar_seed,
            'avatar_url' => $this->avatar_url,
            'tasks_count' => $this->tasks_count,
            'rating' => (float) $this->rating,
            'reviews_count' => $this->reviews_count,
            'is_featured' => $this->is_featured,
            'is_followed' => (bool) ($this->is_followed ?? false),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
