<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the test user
        $testUser = User::where('email', 'test@example.com')->first();

        if ($testUser) {
            // Create 8 active jobs for the test user
            Job::factory(8)
                ->for($testUser, 'employer')
                ->create();

            // Create 2 inactive jobs
            Job::factory(2)
                ->for($testUser, 'employer')
                ->inactive()
                ->create();
        }
    }
}
