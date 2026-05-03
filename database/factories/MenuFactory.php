<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MenuFactory extends Factory{
    protected $model = Menu::class;

    public function definition(): array
    {
        $name = fake()->words(3, true);
        return [
            'umkm_id' => Umkm::factory(),
            'name' => $name,
            'slug' => Str::slug($name . '-' . fake()->unique()->numerify('####')),
            'category' => fake()->randomElement(['Makanan Utama', 'Minuman', 'Camilan', 'Dessert']),
            'description' => fake()->sentence(),
            'image' => null,
            'ukuran' => fake()->randomElement(['Kecil', 'Sedang', 'Besar', 'Reguler', 'Large']),
            'variant' => fake()->randomElement(['Original', 'Pedas', 'Manis', 'Asin', 'Dingin', 'Panas']),
            'price' => fake()->numberBetween(5000, 75000),
        ];
    }
}
