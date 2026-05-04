<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use App\Models\Umkm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'umkm_id' => Umkm::factory(),
            'reason' => fake()->randomElement([
                'Menu tidak sesuai dengan deskripsi',
                'Penjual tidak responsif',
                'Kualitas produk buruk',
                'Harga tidak sesuai',
                'Pengemasan rusak',
            ]) . '. ' . fake()->sentence(),
            'status' => fake()->randomElement(['pending', 'diproses', 'selesai', 'ditolak']),
        ];
    }
}
