<?php

namespace App\Actions\Mentor;

use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Models\Mentor;
use App\Models\User;

class FollowMentorAction
{
    public function __construct(
        private readonly MentorRepositoryInterface $mentorRepository,
    ) {
    }

    public function __invoke(User $user, Mentor $mentor): void
    {
        $this->mentorRepository->follow($user, $mentor);
    }
}
