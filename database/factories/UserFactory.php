<?php

namespace Database\Factories;

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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'slug' => fake()->unique()->slug(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'user', 
            'status' => 'approved',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // State khusus untuk membuat Pengusaha
    public function pengusaha(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'pengusaha',
            'status' => 'approved',
        ]);
    }

    // State khusus untuk membuat Admin
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin',
            'status' => 'approved',
        ]);
    }
}
