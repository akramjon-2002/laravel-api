<?php

namespace App\Actions\Mentor;

use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Exceptions\ApiResourceNotFoundException;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Support\Collection;

class GetMentorDetailsAction
{
    public function __construct(
        private readonly MentorRepositoryInterface $mentorRepository,
    ) {
    }

    public function __invoke(int $mentorId, ?User $user = null): Mentor
    {
        $mentor = $this->mentorRepository->find($mentorId);

        if (! $mentor) {
            throw new ApiResourceNotFoundException('Mentor');
        }

        $followedIds = $user ? $this->mentorRepository->getFollowedIds($user) : collect();

        return $this->hydrateMentor($mentor, $followedIds);
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
