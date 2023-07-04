<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'boardgame_id' => 25,
            'user_id' => rand(1, 9),
            'title' => $this->faker->text(20),
            'body' => $this->faker->text(50),
            'score' => rand(1, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
