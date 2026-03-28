<?php

it('returns the overview payload for the dashboard', function (): void {
    $this->getJson('/api/overview')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'user' => ['id', 'name', 'email', 'avatar_url'],
                'summary_metrics' => ['running_tasks', 'completed_tasks', 'total_tasks', 'completion_rate'],
                'activity' => ['labels', 'series'],
                'upcoming_tasks' => [
                    '*' => ['id', 'title', 'status', 'progress', 'category', 'mentor', 'members'],
                ],
                'task_today' => ['id', 'title', 'steps'],
                'monthly_mentors' => [
                    '*' => ['id', 'name', 'role', 'is_followed'],
                ],
            ],
        ]);
});
