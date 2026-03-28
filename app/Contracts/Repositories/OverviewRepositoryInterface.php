<?php

namespace App\Contracts\Repositories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;

interface OverviewRepositoryInterface
{
    public function getSummaryMetrics(User $user): array;

    public function getActivitySnapshot(User $user): array;

    public function getUpcomingTasks(User $user, int $limit = 5): Collection;

    public function getTaskToday(User $user): ?Task;

    public function getMonthlyMentors(User $user, int $limit = 5): Collection;
}
