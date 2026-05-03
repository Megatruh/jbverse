<?php

namespace Database\Seeders;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengusaha = User::query()->where('email', 'budi@jbverse.test')->first();
        if (!$pengusaha) {
            $this->command?->warn('UmkmSeeder: user pengusaha (budi@jbverse.test) belum ada. Jalankan UserSeeder dulu.');
            return;
        }

        $name = 'Kopi Kenangan Senja';
        $desiredSlug = Str::slug($name);

        $umkm = Umkm::firstOrNew(['user_id' => $pengusaha->id]);
        $umkm->name = $name;
        $umkm->contact_number = '081234567890';
        $umkm->description = 'Kopi mantap jiwa untuk menemani senja.';
        $umkm->is_open = true;

        $pengusaha = User::query()->where('email', 'owner@coffee.com')->first();

        if ($pengusaha) {
            Umkm::create([
                'user_id' => $pengusaha->id,
                'name' => 'JO.Coffee Roastery',
                'contact_number' => '081234567890',
                'description' => 'Menyediakan biji kopi pilihan dari seluruh nusantara dengan metode roasting terbaik.',
                'is_open' => true,
            ]);
        }

        // Pastikan slug konsisten (model hanya auto-slug saat creating).
        $slug = $desiredSlug;
        $count = 1;
        while (
            Umkm::query()
                ->where('slug', $slug)
                ->when($umkm->exists, fn ($q) => $q->where('id', '!=', $umkm->id))
                ->exists()
        ) {
            $slug = $desiredSlug . '-' . $count++;
        }
        $umkm->slug = $slug;

        $umkm->save();

        Umkm::factory(8)->create();

    }
}