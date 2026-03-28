<?php

namespace App\Actions\Task;

use App\Models\Task;
use Illuminate\Support\Collection;

class GetTaskStepsAction
{
    public function __invoke(Task $task): Collection
    {
        return $task->relationLoaded('steps')
            ? $task->steps
            : $task->steps()->orderBy('sort_order')->get();
    }
}
