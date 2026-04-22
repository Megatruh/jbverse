<?php

namespace Database\Factories;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Umkm>
 */
class UmkmFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Jika tidak di-supply saat seeding, buat User baru dengan role pengusaha
            'user_id' => User::factory()->pengusaha(), 
            'name' => fake()->company(),
            // Kolom 'slug' tidak perlu ditulis karena sudah ditangani otomatis oleh Model (booted event)
            'contact_number' => fake()->phoneNumber(),
            'description' => fake()->paragraph(),
            'is_open' => fake()->boolean(80), // 80% kemungkinan buka
            'image_banner' => null, // Biarkan kosong atau isi dengan URL gambar placeholder
        ];
    }
}
