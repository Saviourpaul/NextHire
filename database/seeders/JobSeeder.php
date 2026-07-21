<?php

namespace Database\Seeders;

use App\Enums\JobStatus;
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
            // Create 8 approved jobs for the test user
            Job::factory(8)
                ->for($testUser, 'employer')
                ->approved()
                ->create();

            // Create 2 jobs awaiting or denied admin review
            Job::factory(2)
                ->for($testUser, 'employer')
                ->sequence(
                    ['status' => JobStatus::Pending],
                    ['status' => JobStatus::Rejected],
                )
                ->create([
                    'category' => 'General Recruitment',
                ]);
        }
    }
}
