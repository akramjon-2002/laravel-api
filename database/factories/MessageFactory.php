<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sentAt = fake()->dateTimeBetween('-1 day', 'now');

        return [
            'conversation_id' => Conversation::factory(),
            'sender_id' => User::factory(),
            'body' => fake()->sentence(),
            'sent_at' => $sentAt,
            'read_at' => fake()->boolean(70) ? $sentAt : null,
        ];
    }
}
