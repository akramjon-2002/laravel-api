<?php

namespace App\Actions\Task;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class GetTaskStepsAction
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function __invoke(User $user, int $taskId): Collection
    {
        $task = $this->taskRepository->findForUser($user, $taskId);

        if (! $task) {
            return collect();
        }

        return $this->taskRepository->getSteps($task);
    }
}
