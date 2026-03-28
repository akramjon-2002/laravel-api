<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'UI/UX Design',
            'Frontend Development',
            'Backend Development',
            'Product Design',
            'Mobile Development',
            'Research',
            'Full Stack Development',
            'Design Systems',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
