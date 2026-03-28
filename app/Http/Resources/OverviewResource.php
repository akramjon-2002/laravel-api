<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OverviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserSummaryResource($this['user']),
            'summary_metrics' => $this['summary_metrics'],
            'activity' => $this['activity'],
            'upcoming_tasks' => TaskResource::collection($this['upcoming_tasks']),
            'task_today' => $this['task_today'] ? new TaskResource($this['task_today']) : null,
            'monthly_mentors' => MentorResource::collection($this['monthly_mentors']),
        ];
    }
}
