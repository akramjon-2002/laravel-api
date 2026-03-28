<?php

namespace App\Http\Controllers\Api;

use App\Actions\Task\GetTaskDetailsAction;
use App\Actions\Task\GetTaskStepsAction;
use App\Actions\Task\ListTasksAction;
use App\Actions\User\ResolveCurrentUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListTasksRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskStepResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    public function __construct(
        private readonly ResolveCurrentUserAction $resolveCurrentUser,
        private readonly ListTasksAction $listTasks,
        private readonly GetTaskDetailsAction $getTaskDetails,
        private readonly GetTaskStepsAction $getTaskSteps,
    ) {
    }

    public function index(ListTasksRequest $request): AnonymousResourceCollection
    {
        $user = ($this->resolveCurrentUser)($request->user());
        $tasks = ($this->listTasks)($user, $request->validated());

        return TaskResource::collection($tasks);
    }

    public function show(ListTasksRequest $request, int $task): TaskResource
    {
        $user = ($this->resolveCurrentUser)($request->user());
        $taskModel = ($this->getTaskDetails)($user, $task);

        return new TaskResource($taskModel);
    }

    public function steps(ListTasksRequest $request, int $task): AnonymousResourceCollection
    {
        $user = ($this->resolveCurrentUser)($request->user());
        $taskModel = ($this->getTaskDetails)($user, $task);

        return TaskStepResource::collection(($this->getTaskSteps)($user, $task));
    }
}
