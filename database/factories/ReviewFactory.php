<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'menu_id' => Menu::factory(),
            'rating' => fake()->numberBetween(3, 5), // Rating antara 3-5 agar toko terlihat bagus
            'comment' => fake()->sentence(),
            'reply' => fake()->boolean(30) ? fake()->sentence() : null, // 30% kemungkinan dibalas toko
        ];
    }
}