<?php

namespace App\Repositories;

use App\Contracts\Repositories\OverviewRepositoryInterface;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;

class EloquentOverviewRepository implements OverviewRepositoryInterface
{
    public function getStatusBreakdown(User $user): array
    {
        $rawCounts = $user->tasks()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return [
            TaskStatus::New->value => (int) ($rawCounts[TaskStatus::New->value] ?? 0),
            TaskStatus::InProgress->value => (int) ($rawCounts[TaskStatus::InProgress->value] ?? 0),
            TaskStatus::Completed->value => (int) ($rawCounts[TaskStatus::Completed->value] ?? 0),
        ];
    }

    public function getUpcomingTasks(User $user, int $limit = 5): Collection
    {
        return $user->tasks()
            ->with(['category', 'mentor', 'members'])
            ->whereIn('status', TaskStatus::activeValues())
            ->orderBy('deadline_at')
            ->limit($limit)
            ->get();
    }

    public function getTaskToday(User $user): ?Task
    {
        return $user->tasks()
            ->with(['category', 'mentor', 'members', 'steps'])
            ->whereIn('status', TaskStatus::activeValues())
            ->orderBy('deadline_at')
            ->first();
    }
}
