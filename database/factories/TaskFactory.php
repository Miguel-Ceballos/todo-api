<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
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
        #C: completed, I: In Progress, D: Done, T: To do
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->words(2, true),
            'description' => fake()->paragraph(1),
            'status' => fake()->randomElement([ 'C', 'I', 'D', 'T' ])
        ];
    }
}
