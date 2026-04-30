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

        $name = 'Kopi Susu Gula Aren';
        $desiredSlug = Str::slug($name);

        $menu = Menu::firstOrNew(['umkm_id' => $umkm->id, 'name' => $name]);
        $menu->category = 'Minuman';
        $menu->description = 'Perpaduan espresso dan gula aren asli.';

        // Pastikan slug unik per UMKM (ada unique index [umkm_id, slug]).
        $slug = $desiredSlug;
        $count = 1;
        while (
            Menu::query()
                ->where('umkm_id', $umkm->id)
                ->where('slug', $slug)
                ->when($menu->exists, fn ($q) => $q->where('id', '!=', $menu->id))
                ->exists()
        ) {
            $slug = $desiredSlug . '-' . $count++;
        }
        $menu->slug = $slug;

        $menu->save();
    }
}
