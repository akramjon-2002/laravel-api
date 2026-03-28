<?php

namespace App\Actions\Task;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Exceptions\ApiResourceNotFoundException;
use App\Models\Task;
use App\Models\User;

class GetTaskDetailsAction
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function __invoke(User $user, int $taskId): Task
    {
        $task = $this->taskRepository->findForUser($user, $taskId);

        if (! $task) {
            throw new ApiResourceNotFoundException('Task');
        }

        return $task;
    }
}
