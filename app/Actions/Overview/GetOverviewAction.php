<?php

namespace App\Actions\Overview;

use App\Contracts\Repositories\OverviewRepositoryInterface;
use App\Models\User;

class GetOverviewAction
{
    public function __construct(
        private readonly OverviewRepositoryInterface $overviewRepository,
    ) {
    }

    public function __invoke(User $user): array
    {
        return [
            'user' => $user->loadMissing('settings'),
            'summary_metrics' => $this->overviewRepository->getSummaryMetrics($user),
            'activity' => $this->overviewRepository->getActivitySnapshot($user),
            'upcoming_tasks' => $this->overviewRepository->getUpcomingTasks($user),
            'task_today' => $this->overviewRepository->getTaskToday($user),
            'monthly_mentors' => $this->overviewRepository->getMonthlyMentors($user),
        ];
    }
}
