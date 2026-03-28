<?php

namespace App\Actions\Mentor;

use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class GetRecentMentorsAction
{
    public function __construct(
        private readonly MentorRepositoryInterface $mentorRepository,
    ) {
    }

    public function __invoke(?User $user = null, int $limit = 5): Collection
    {
        return $this->mentorRepository->getRecent($user, $limit);
    }
}
