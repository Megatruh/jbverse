<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menu>
 */

class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'umkm_id' => Umkm::factory(),
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['Makanan', 'Minuman', 'Camilan', 'Merchandise']),
            'description' => fake()->sentence(),
            'images' => [fake()->imageUrl(640, 480, 'food', true)], // Format array untuk JSON
        ];
    }
}
