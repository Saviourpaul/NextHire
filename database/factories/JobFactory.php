<?php

namespace Database\Factories;

use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');

        return [
            'employer_id' => User::factory(),
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'company' => fake()->company(),
            'category' => fake()->randomElement([
                'Government',
                'Healthcare',
                'Education',
                'Finance',
                'Engineering',
                'Technology',
                'Administration',
            ]),
            'logo' => null,
            'start_date' => $startDate,
            'due_date' => fake()->dateTimeBetween($startDate, '+3 months'),
            'status' => JobStatus::Pending,
        ];
    }

    /**
     * Indicate that the job should be approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => JobStatus::Approved,
        ]);
    }

    /**
     * Indicate that the job should be rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => JobStatus::Rejected,
        ]);
    }

    /**
     * @deprecated Use rejected() for admin-reviewed job workflows.
     */
    public function inactive(): static
    {
        return $this->rejected();
    }
}
