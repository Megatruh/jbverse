<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\MenuCombination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MenuCombination>
 */
class MenuCombinationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'menu_id' => Menu::factory(),
            // Menghasilkan harga acak antara 10.000 hingga 100.000 dengan kelipatan 500
            'price' => fake()->numberBetween(20, 200) * 500, 
        ];
    }
}
