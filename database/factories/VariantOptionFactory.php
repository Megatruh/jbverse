<?php

namespace Database\Factories;

use App\Models\VariantCategory;
use App\Models\VariantOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VariantOption>
 */
class VariantOptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'variant_category_id' => VariantCategory::factory(),
            'name' => fake()->word(),
        ];
    }
}
