<?php

namespace App\Repositories;

use App\Contracts\Repositories\MentorRepositoryInterface;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentMentorRepository implements MentorRepositoryInterface
{
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $query = $this->baseQuery()
            ->when(
                $filters['search'] ?? null,
                function (Builder $builder, string $search): void {
                    $builder->where(function (Builder $nested) use ($search): void {
                        $nested->where('name', 'like', '%'.$search.'%')
                            ->orWhere('role', 'like', '%'.$search.'%');
                    });
                }
            )
            ->when(
                $filters['category_id'] ?? null,
                fn (Builder $builder, int|string $categoryId) => $builder->where('category_id', $categoryId)
            );

        $sort = $filters['sort'] ?? 'rating';

        $query = match ($sort) {
            'reviews' => $query->orderByDesc('reviews_total'),
            'tasks' => $query->orderByDesc('tasks_total'),
            'latest' => $query->latest(),
            default => $query->orderByDesc('average_rating'),
        };

        return $query->paginate((int) ($filters['per_page'] ?? 10));
    }

    public function getRecent(int $limit = 5): Collection
    {
        return $this->baseQuery()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function find(int $mentorId): ?Mentor
    {
        return $this->baseQuery()
            ->with('reviews')
            ->find($mentorId);
    }

    public function getFollowedIds(User $user): Collection
    {
        return $user->followedMentors()->pluck('mentors.id');
    }

    public function isFollowedBy(User $user, Mentor $mentor): bool
    {
        return $user->followedMentors()->whereKey($mentor->id)->exists();
    }

    public function follow(User $user, Mentor $mentor): void
    {
        $user->followedMentors()->syncWithoutDetaching([$mentor->id]);
    }

    public function unfollow(User $user, Mentor $mentor): void
    {
        $user->followedMentors()->detach($mentor->id);
    }

    private function baseQuery(): Builder
    {
        return Mentor::query()
            ->with('category')
            ->withCount([
                'tasks as tasks_total',
                'reviews as reviews_total',
            ])
            ->withAvg('reviews as average_rating', 'rating');
    }
}
