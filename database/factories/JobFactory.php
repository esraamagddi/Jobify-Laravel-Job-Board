<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employer_id' => fake()->randomNumber(),
            'category_id' => fake()->randomNumber(),
            'title' => fake()->text(50),
            'description' => fake()->text(50),
            'responsibilities' => fake()->text(),
            'skills' => fake()->text(),
            'qualifications' => fake()->text(),
            'salary_range' => fake()->text(50),
            'work_type' => fake()->randomElement(['remote', 'offline', 'hybrid']),
            'location' => fake()->text(50),
            'deadline' => fake()->date(),
        ];
    }
}
