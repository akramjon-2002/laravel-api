<?php

namespace App\Actions\Mentor;

use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ListMentorsAction
{
    public function __construct(
        private readonly MentorRepositoryInterface $mentorRepository,
    ) {
    }

    public function __invoke(array $filters = [], ?User $user = null): LengthAwarePaginator
    {
        $mentors = $this->mentorRepository->paginate($filters);
        $followedIds = $user ? $this->mentorRepository->getFollowedIds($user) : collect();

        $mentors->setCollection(
            $mentors->getCollection()->map(
                fn (Mentor $mentor) => $this->hydrateMentor($mentor, $followedIds)
            )
        );

        return $mentors;
    }

    private function hydrateMentor(Mentor $mentor, Collection $followedIds): Mentor
    {
        $mentor->setAttribute('tasks_count', (int) ($mentor->getAttribute('tasks_total') ?? $mentor->tasks_count ?? 0));
        $mentor->setAttribute('reviews_count', (int) ($mentor->getAttribute('reviews_total') ?? $mentor->reviews_count ?? 0));
        $mentor->setAttribute(
            'rating',
            round((float) ($mentor->getAttribute('average_rating') ?? $mentor->rating ?? 0), 2)
        );
        $mentor->setAttribute('is_followed', $followedIds->contains($mentor->id));

        return $mentor;
    }
}
