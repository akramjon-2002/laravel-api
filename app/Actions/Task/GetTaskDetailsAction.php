<?php

namespace App\Actions\Task;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use App\Models\User;

class GetTaskDetailsAction
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function __invoke(User $user, int $taskId): ?Task
    {
        return $this->taskRepository->findForUser($user, $taskId);
    }
}
