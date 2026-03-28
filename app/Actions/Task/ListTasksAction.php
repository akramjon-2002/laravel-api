<?php

namespace App\Actions\Task;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListTasksAction
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function __invoke(User $user, array $filters = []): LengthAwarePaginator
    {
        return $this->taskRepository->paginateForUser($user, $filters);
    }
}
