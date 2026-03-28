<?php

namespace App\Actions\Mentor;

use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class GetMonthlyMentorsAction
{
    public function __construct(
        private readonly MentorRepositoryInterface $mentorRepository,
        private readonly HydrateMentorSummaryAction $hydrateMentorSummary,
    ) {
    }

    public function __invoke(User $user, int $limit = 5): Collection
    {
        $followedIds = $this->mentorRepository->getFollowedIds($user);

        return $this->hydrateMentorSummary->collection(
            $this->mentorRepository->getMonthly($limit),
            $followedIds,
        );
    }
}
