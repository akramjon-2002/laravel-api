<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mentor>
 */
class MentorFactory extends Factory
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
            'name' => fake()->name(),
            'role' => fake()->jobTitle(),
            'bio' => fake()->paragraph(),
            'avatar_seed' => fake()->firstName(),
            'avatar_url' => sprintf(
                'https://api.dicebear.com/7.x/avataaars/svg?seed=%s',
                urlencode(fake()->firstName())
            ),
            'tasks_count' => fake()->numberBetween(10, 40),
            'rating' => fake()->randomFloat(2, 4.2, 5.0),
            'reviews_count' => fake()->numberBetween(20, 180),
            'is_featured' => fake()->boolean(30),
        ];
    }
}
