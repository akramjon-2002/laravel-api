<?php

namespace App\Actions\Mentor;

use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Models\Mentor;
use App\Models\User;

class UnfollowMentorAction
{
    public function __construct(
        private readonly MentorRepositoryInterface $mentorRepository,
        private readonly GetMentorDetailsAction $getMentorDetails,
    ) {
    }

    public function __invoke(User $user, Mentor $mentor): Mentor
    {
        $this->mentorRepository->unfollow($user, $mentor);

        return ($this->getMentorDetails)($mentor->id, $user);
    }
}
