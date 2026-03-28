<?php

namespace App\Actions\Mentor;

use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListMentorsAction
{
    public function __construct(
        private readonly MentorRepositoryInterface $mentorRepository,
        private readonly HydrateMentorSummaryAction $hydrateMentorSummary,
    ) {
    }

    public function __invoke(array $filters = [], ?User $user = null): LengthAwarePaginator
    {
        $mentors = $this->mentorRepository->paginate($filters);
        $followedIds = $user ? $this->mentorRepository->getFollowedIds($user) : collect();

        $mentors->setCollection(
            $this->hydrateMentorSummary->collection($mentors->getCollection(), $followedIds)
        );

        return $mentors;
    }
}
