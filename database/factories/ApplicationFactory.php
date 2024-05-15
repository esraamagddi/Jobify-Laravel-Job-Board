<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usersIds = User::pluck('id');
        $jobsIds = Post::pluck('id');
        return [
            'post_id' => fake()->randomElement($jobsIds),
            'user_id' => fake()->randomElement($usersIds),
            'status' => 'pending', //fake()->randomElement(['pending', 'accepted', 'rejected']),
            'app_email' => fake()->email(),
            'app_phone' => fake()->phoneNumber()
        ];
    }
}
