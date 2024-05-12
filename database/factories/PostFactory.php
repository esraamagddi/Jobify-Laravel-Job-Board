<?php

namespace Database\Factories;
use App\Models\Employer;
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
        // $employer = Employer::factory()->create();
        // $category = Category::factory()->create();
        $usersIds = User::pluck('id');
        $categoriesIds = Category::pluck('id');

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
            'employer_id' => fake()->randomElement($usersIds),
            'category_id' => fake()->randomElement($categoriesIds),
        ];
    }
}
