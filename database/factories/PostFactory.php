<?php

namespace Database\Factories;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        return [
            'title' => fake()->sentence,
            'description' => fake()->sentence,
            'responsibilities' => fake()->text,
            'skills' => fake()->text,
            'qualifications' => fake()->text,
            'salary_range' => fake()->randomNumber(4),
            'work_type' => fake()->randomElement(['offline', 'remote', 'hybrid']),
            'location' => fake()->address,
            'deadline' => fake()->date(),
            'employer_id' => $user->id,
            'category_id' => $category->id,
        ];
    }
}
