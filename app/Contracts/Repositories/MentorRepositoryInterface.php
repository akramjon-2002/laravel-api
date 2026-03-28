<?php

namespace App\Contracts\Repositories;

use App\Models\Mentor;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface MentorRepositoryInterface
{
    public function paginate(array $filters = []): LengthAwarePaginator;

    public function getRecent(int $limit = 5): Collection;

    public function getMonthly(int $limit = 5): Collection;

    public function find(int $mentorId): ?Mentor;

    public function getFollowedIds(User $user): Collection;

    public function isFollowedBy(User $user, Mentor $mentor): bool;

    public function follow(User $user, Mentor $mentor): void;

    public function unfollow(User $user, Mentor $mentor): void;
}
