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
        $statusBreakdown = $this->overviewRepository->getStatusBreakdown($user);
        $totalTasks = array_sum($statusBreakdown);
        $completedTasks = $statusBreakdown['completed'] ?? 0;

        return [
            'user' => $user,
            'summary_metrics' => [
                'running_tasks' => $statusBreakdown['in_progress'] ?? 0,
                'completed_tasks' => $completedTasks,
                'total_tasks' => $totalTasks,
                'completion_rate' => $totalTasks > 0
                    ? (int) round(($completedTasks / $totalTasks) * 100)
                    : 0,
            ],
            'activity' => [
                'labels' => ['New', 'In Progress', 'Completed'],
                'series' => [
                    $statusBreakdown['new'] ?? 0,
                    $statusBreakdown['in_progress'] ?? 0,
                    $statusBreakdown['completed'] ?? 0,
                ],
            ],
            'upcoming_tasks' => $this->overviewRepository->getUpcomingTasks($user),
            'task_today' => $this->overviewRepository->getTaskToday($user),
            'monthly_mentors' => $this->overviewRepository->getMonthlyMentors($user),
        ];
    }
}
