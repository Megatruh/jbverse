<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Umkm;
use App\Models\VariantCategory;
use App\Models\VariantOption;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    public function run(): void
    {
        $umkm = Umkm::query()->where('name', 'Kopi Kenangan Senja')->first();
        if (!$umkm) {
            $this->command?->warn('VariantSeeder: UMKM "Kopi Kenangan Senja" belum ada. Jalankan UmkmSeeder dulu.');
            return;
        }

        $menu = Menu::query()->where('umkm_id', $umkm->id)->where('name', 'Kopi Susu Gula Aren')->first();
        if (!$menu) {
            $this->command?->warn('VariantSeeder: Menu "Kopi Susu Gula Aren" belum ada. Jalankan MenuSeeder dulu.');
            return;
        }

        // Kategori: Ukuran
        $kategoriUkuran = VariantCategory::updateOrCreate(
            ['menu_id' => $menu->id, 'name' => 'Ukuran'],
            ['is_required' => true]
        );

        VariantOption::updateOrCreate(
            ['variant_category_id' => $kategoriUkuran->id, 'name' => 'Reguler'],
            []
        );
        VariantOption::updateOrCreate(
            ['variant_category_id' => $kategoriUkuran->id, 'name' => 'Large'],
            []
        );

        // Kategori: Penyajian
        $kategoriSuhu = VariantCategory::updateOrCreate(
            ['menu_id' => $menu->id, 'name' => 'Penyajian'],
            ['is_required' => true]
        );

        VariantOption::updateOrCreate(
            ['variant_category_id' => $kategoriSuhu->id, 'name' => 'Dingin'],
            []
        );
        VariantOption::updateOrCreate(
            ['variant_category_id' => $kategoriSuhu->id, 'name' => 'Panas'],
            []
        );
    }
}
