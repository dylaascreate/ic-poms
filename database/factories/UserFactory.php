<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Shared password for all seeded users.
     */
    protected static ?string $password = null;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => self::$password ??= Hash::make('password'),
            'role' => 'user', // Default role
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Unverified user state.
     */
    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Admin role state.
     */
    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => 'admin',
        ]);
    }
}
