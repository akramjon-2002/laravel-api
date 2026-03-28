<?php

namespace App\Actions\Mentor;

use App\Models\Mentor;
use Illuminate\Support\Collection;

class HydrateMentorSummaryAction
{
    public function __invoke(Mentor $mentor, Collection $followedIds): Mentor
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

    public function collection(Collection $mentors, Collection $followedIds): Collection
    {
        return $mentors->map(
            fn (Mentor $mentor) => $this($mentor, $followedIds)
        );
    }
}
