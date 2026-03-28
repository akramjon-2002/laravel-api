<?php

namespace App\Repositories;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function paginateForUser(User $user, array $filters = []): LengthAwarePaginator
    {
        $query = $user->tasks()
            ->with(['category', 'mentor', 'members'])
            ->when(
                $filters['search'] ?? null,
                fn (Builder $builder, string $search) => $builder->where('title', 'like', '%'.$search.'%')
            )
            ->when(
                $filters['category_id'] ?? null,
                fn (Builder $builder, int|string $categoryId) => $builder->where('category_id', $categoryId)
            );

        $sort = $filters['sort'] ?? 'deadline';

        $query = match ($sort) {
            'progress' => $query->orderByDesc('progress'),
            'latest' => $query->latest(),
            default => $query->orderBy('deadline_at'),
        };

        return $query->paginate((int) ($filters['per_page'] ?? 10));
    }

    public function findForUser(User $user, int $taskId): ?Task
    {
        return $user->tasks()
            ->with(['category', 'mentor', 'members', 'steps'])
            ->whereKey($taskId)
            ->first();
    }

    public function getSteps(Task $task): Collection
    {
        return $task->steps()->get();
    }
}
