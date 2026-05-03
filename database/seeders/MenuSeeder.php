<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $umkm = Umkm::query()->where('name', 'Kopi Kenangan Senja')->first();
        if (!$umkm) {
            $this->command?->warn('MenuSeeder: UMKM "Kopi Kenangan Senja" belum ada. Jalankan UmkmSeeder dulu.');
            return;
        }

        $menus = [
            [
                'name' => 'Kopi Susu Gula Aren',
                'category' => 'Minuman',
                'description' => 'Perpaduan espresso dan gula aren asli.',
            ],
            [
                'name' => 'Bali Kintamani V60',
                'category' => 'Minuman',
                'description' => 'Single origin kopi dari Bali dengan metode V60.',
            ],
            [
                'name' => 'Croissant Coklat',
                'category' => 'Camilan',
                'description' => 'Croissant lembut dengan coklat premium.',
            ],
        ];

        foreach ($menus as $menuData) {
            $name = $menuData['name'];
            $desiredSlug = Str::slug($name);

<<<<<<< HEAD
            $menu = Menu::firstOrNew(['umkm_id' => $umkm->id, 'name' => $name]);
            $menu->category = $menuData['category'];
            $menu->description = $menuData['description'];

            // --- TAMBAHAN BARU: Isi field yang sebelumnya kosong ---
            $menu->ukuran = 'Reguler';
            $menu->variant = 'Dingin';
            $menu->price = 18000;
            // -------------------------------------------------------

            // Pastikan slug unik per UMKM (ada unique index [umkm_id, slug]).
            $slug = $desiredSlug;
            $count = 1;
            while (
                Menu::query()
=======
        // --- TAMBAHAN BARU: Isi field yang sebelumnya kosong ---
        $menu->ukuran = 'Reguler';
        $menu->variant = 'Dingin';
        $menu->price = 18000;
        // -------------------------------------------------------

        // Pastikan slug unik per UMKM (ada unique index [umkm_id, slug]).
        $slug = $desiredSlug;
        $count = 1;
        while (
            Menu::query()
>>>>>>> 040fe2fea0b18762f497142140af0480122196ca
                ->where('umkm_id', $umkm->id)
                ->where('slug', $slug)
                ->when($menu->exists, fn($q) => $q->where('id', '!=', $menu->id))
                ->exists()
            ) {
                $slug = $desiredSlug . '-' . $count++;
            }
            $menu->slug = $slug;

            $menu->save();
        }
    }
}