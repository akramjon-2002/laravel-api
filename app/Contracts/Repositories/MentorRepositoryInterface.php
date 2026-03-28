<?php

namespace App\Contracts\Repositories;

use App\Models\Mentor;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface MentorRepositoryInterface
{
    public function paginate(array $filters = [], ?User $user = null): LengthAwarePaginator;

    public function getRecent(?User $user = null, int $limit = 5): Collection;

    public function find(int $mentorId, ?User $user = null): ?Mentor;

    public function follow(User $user, Mentor $mentor): void;

    public function unfollow(User $user, Mentor $mentor): void;
}
