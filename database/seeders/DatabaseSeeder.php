<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(NigeriaLocationSeeder::class);

        User::factory()->admin()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin',
            'email' => 'admin@example.com',
        ]);

        // Create test employer
        User::factory()->employer()->create([
            'first_name' => 'Test',
            'last_name' => 'Employer',
            'username' => 'test-employer',
            'email' => 'test@example.com',
        ]);

        // Create test applicant
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'Applicant',
            'username' => 'test-applicant',
            'email' => 'applicant@example.com',
        ]);

        // Run the job seeder
        $this->call(JobSeeder::class);
        $this->call(ApplicationForm::class);
    }
}
