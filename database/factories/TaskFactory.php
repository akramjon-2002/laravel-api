<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Category;
use App\Models\Mentor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'mentor_id' => Mentor::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(TaskStatus::cases())->value,
            'progress' => fake()->numberBetween(0, 100),
            'deadline_at' => fake()->dateTimeBetween('now', '+10 days'),
            'started_at' => now()->subDays(fake()->numberBetween(1, 7)),
            'completed_at' => null,
            'is_featured' => fake()->boolean(30),
        ];
    }
}
