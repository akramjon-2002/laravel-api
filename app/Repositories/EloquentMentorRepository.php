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
    public function paginate(array $filters = [], ?User $user = null): LengthAwarePaginator
    {
        $query = Mentor::query()
            ->with('category')
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
            'reviews' => $query->orderByDesc('reviews_count'),
            'tasks' => $query->orderByDesc('tasks_count'),
            'latest' => $query->latest(),
            default => $query->orderByDesc('rating'),
        };

        $paginator = $query->paginate((int) ($filters['per_page'] ?? 10));

        $followedIds = $user?->followedMentors()->pluck('mentors.id') ?? collect();

        $paginator->getCollection()->each(function (Mentor $mentor) use ($followedIds): void {
            $mentor->setAttribute('is_followed', $followedIds->contains($mentor->id));
        });

        return $paginator;
    }

    public function getRecent(?User $user = null, int $limit = 5): Collection
    {
        $followedIds = $user?->followedMentors()->pluck('mentors.id') ?? collect();

        return Mentor::query()
            ->with('category')
            ->latest()
            ->limit($limit)
            ->get()
            ->each(function (Mentor $mentor) use ($followedIds): void {
                $mentor->setAttribute('is_followed', $followedIds->contains($mentor->id));
            });
    }

    public function find(int $mentorId, ?User $user = null): ?Mentor
    {
        $mentor = Mentor::query()
            ->with(['category', 'reviews'])
            ->find($mentorId);

        if (! $mentor) {
            return null;
        }

        $mentor->setAttribute(
            'is_followed',
            $user?->followedMentors()->whereKey($mentorId)->exists() ?? false
        );

        return $mentor;
    }

    public function follow(User $user, Mentor $mentor): void
    {
        $user->followedMentors()->syncWithoutDetaching([$mentor->id]);
    }

    public function unfollow(User $user, Mentor $mentor): void
    {
        $user->followedMentors()->detach($mentor->id);
    }
}
