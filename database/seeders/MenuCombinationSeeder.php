<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuCombination;
use App\Models\Umkm;
use App\Models\VariantCategory;
use App\Models\VariantOption;
use Illuminate\Database\Seeder;

class MenuCombinationSeeder extends Seeder
{
    public function run(): void
    {
        $umkm = Umkm::query()->where('name', 'Kopi Kenangan Senja')->first();
        if (!$umkm) {
            $this->command?->warn('MenuCombinationSeeder: UMKM "Kopi Kenangan Senja" belum ada. Jalankan UmkmSeeder dulu.');
            return;
        }

        $menu = Menu::query()->where('umkm_id', $umkm->id)->where('name', 'Kopi Susu Gula Aren')->first();
        if (!$menu) {
            $this->command?->warn('MenuCombinationSeeder: Menu "Kopi Susu Gula Aren" belum ada. Jalankan MenuSeeder dulu.');
            return;
        }

        $kategoriUkuran = VariantCategory::query()->where('menu_id', $menu->id)->where('name', 'Ukuran')->first();
        $kategoriSuhu = VariantCategory::query()->where('menu_id', $menu->id)->where('name', 'Penyajian')->first();

        if (!$kategoriUkuran || !$kategoriSuhu) {
            $this->command?->warn('MenuCombinationSeeder: Variant category belum lengkap. Jalankan VariantSeeder dulu.');
            return;
        }

        $opsiReguler = VariantOption::query()->where('variant_category_id', $kategoriUkuran->id)->where('name', 'Reguler')->first();
        $opsiLarge = VariantOption::query()->where('variant_category_id', $kategoriUkuran->id)->where('name', 'Large')->first();
        $opsiDingin = VariantOption::query()->where('variant_category_id', $kategoriSuhu->id)->where('name', 'Dingin')->first();

        if (!$opsiReguler || !$opsiLarge || !$opsiDingin) {
            $this->command?->warn('MenuCombinationSeeder: Variant option belum lengkap. Jalankan VariantSeeder dulu.');
            return;
        }

        // Kombinasi 1: Reguler + Dingin = Rp 15.000
        $kombinasi1 = MenuCombination::updateOrCreate(
            ['menu_id' => $menu->id, 'price' => '15000.00'],
            []
        );
        $kombinasi1->options()->sync([$opsiReguler->id, $opsiDingin->id]);

        // Kombinasi 2: Large + Dingin = Rp 20.000
        $kombinasi2 = MenuCombination::updateOrCreate(
            ['menu_id' => $menu->id, 'price' => '20000.00'],
            []
        );
        $kombinasi2->options()->sync([$opsiLarge->id, $opsiDingin->id]);
    }
}
