<?php

namespace App\Repositories;

use App\Contracts\Repositories\OverviewRepositoryInterface;
use App\Enums\TaskStatus;
use App\Models\Mentor;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;

class EloquentOverviewRepository implements OverviewRepositoryInterface
{
    public function getSummaryMetrics(User $user): array
    {
        $taskQuery = $user->tasks();

        $totalTasks = (clone $taskQuery)->count();
        $runningTasks = (clone $taskQuery)->where('status', TaskStatus::InProgress->value)->count();
        $completedTasks = (clone $taskQuery)->where('status', TaskStatus::Completed->value)->count();

        return [
            'running_tasks' => $runningTasks,
            'completed_tasks' => $completedTasks,
            'total_tasks' => $totalTasks,
            'completion_rate' => $totalTasks > 0
                ? (int) round(($completedTasks / $totalTasks) * 100)
                : 0,
        ];
    }

    public function getActivitySnapshot(User $user): array
    {
        return [
            'labels' => ['New', 'In Progress', 'Completed'],
            'series' => [
                $user->tasks()->where('status', TaskStatus::New->value)->count(),
                $user->tasks()->where('status', TaskStatus::InProgress->value)->count(),
                $user->tasks()->where('status', TaskStatus::Completed->value)->count(),
            ],
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

    public function getMonthlyMentors(User $user, int $limit = 5): Collection
    {
        $followedMentorIds = $user->followedMentors()->pluck('mentors.id');

        return Mentor::query()
            ->with('category')
            ->withCount([
                'tasks as tasks_total',
                'reviews as reviews_total',
            ])
            ->withAvg('reviews as average_rating', 'rating')
            ->orderByDesc('is_featured')
            ->orderByDesc('average_rating')
            ->orderByDesc('reviews_total')
            ->limit($limit)
            ->get()
            ->each(function (Mentor $mentor) use ($followedMentorIds): void {
                $mentor->setAttribute('tasks_count', (int) ($mentor->getAttribute('tasks_total') ?? 0));
                $mentor->setAttribute('reviews_count', (int) ($mentor->getAttribute('reviews_total') ?? 0));
                $mentor->setAttribute(
                    'rating',
                    round((float) ($mentor->getAttribute('average_rating') ?? $mentor->rating ?? 0), 2)
                );
                $mentor->setAttribute('is_followed', $followedMentorIds->contains($mentor->id));
            });
    }
}
