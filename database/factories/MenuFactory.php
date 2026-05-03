<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory{
    public function definition(): array
    {
        return [
            'umkm_id' => Umkm::factory(),
            'name' => fake()->words(3, true),
            'category' => fake()->randomElement(['Makanan Utama', 'Minuman', 'Camilan', 'Dessert']),
            'description' => fake()->sentence(),
        ];
    }
}
