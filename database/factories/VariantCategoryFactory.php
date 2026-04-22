<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\VariantCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VariantCategory>
 */
class VariantCategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'menu_id' => Menu::factory(),
            'name' => fake()->randomElement(['Ukuran', 'Tingkat Kepedasan', 'Pilihan Rasa', 'Topping']),
            'is_required' => fake()->boolean(70), // 70% wajib dipilih
        ];
    }
}
