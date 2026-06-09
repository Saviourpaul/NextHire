<?php

namespace Database\Factories;

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
            'logo' => null,
            'start_date' => $startDate,
            'due_date' => fake()->dateTimeBetween($startDate, '+3 months'),
            'status' => 'active',
        ];
    }

    /**
     * Indicate that the job should be inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}