<?php

namespace App\Http\Resources;

use App\Enums\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $status = $this->status instanceof TaskStatus
            ? $this->status->value
            : $this->status;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $status,
            'progress' => $this->progress,
            'deadline_at' => optional($this->deadline_at)?->toIso8601String(),
            'started_at' => optional($this->started_at)?->toIso8601String(),
            'completed_at' => optional($this->completed_at)?->toIso8601String(),
            'is_featured' => $this->is_featured,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'mentor' => new MentorResource($this->whenLoaded('mentor')),
            'members' => UserSummaryResource::collection($this->whenLoaded('members')),
            'steps' => TaskStepResource::collection($this->whenLoaded('steps')),
        ];
    }
}
