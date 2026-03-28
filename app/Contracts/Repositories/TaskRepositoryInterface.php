<?php

namespace App\Contracts\Repositories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function paginateForUser(User $user, array $filters = []): LengthAwarePaginator;

    public function findForUser(User $user, int $taskId): ?Task;

    public function getSteps(Task $task): Collection;
}
