<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentor extends Model
{
    /** @use HasFactory<\Database\Factories\MentorFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'role',
        'bio',
        'avatar_seed',
        'avatar_url',
        'tasks_count',
        'rating',
        'reviews_count',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:2',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'mentor_followers')
            ->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
