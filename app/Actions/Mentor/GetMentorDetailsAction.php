<?php

namespace App\Actions\Mentor;

use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Models\Mentor;
use App\Models\User;

class GetMentorDetailsAction
{
    public function __construct(
        private readonly MentorRepositoryInterface $mentorRepository,
    ) {
    }

    public function __invoke(int $mentorId, ?User $user = null): ?Mentor
    {
        return $this->mentorRepository->find($mentorId, $user);
    }
}
