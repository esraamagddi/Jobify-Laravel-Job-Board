<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::create([
            'title' => 'Software Engineer',
            'description' => 'Lorem ipsum dolor sit amet...',
            'location' => 'New York',
            // 'type' => 'remote',
            'salary_min' => 50000,
            'salary_max' => 80000,
            'application_deadline' => now()->addWeek(),
        ]);
    }
}
