<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'username' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => UserRole::Applicant,
            'status' => UserStatus::Active,
            'approved_at' => now(),
            'suspended_at' => null,
            'last_login_at' => null,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Admin,
            'status' => UserStatus::Active,
            'approved_at' => now(),
            'suspended_at' => null,
        ]);
    }

    public function employer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Employer,
            'status' => UserStatus::Active,
            'approved_at' => now(),
            'suspended_at' => null,
        ]);
    }

    public function applicant(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Applicant,
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::Pending,
            'approved_at' => null,
            'suspended_at' => null,
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::Suspended,
            'suspended_at' => now(),
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
