<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Umkm;
use App\Models\Menu;
use App\Models\VariantCategory;
use App\Models\VariantOption;
use App\Models\MenuCombination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@jbverse.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'approved',
        ]);

        // 2. Buat Akun Pengusaha
        $pengusaha = User::create([
            'name' => 'Budi Pengusaha',
            'email' => 'budi@jbverse.test',
            'password' => Hash::make('password123'),
            'role' => 'pengusaha',
            'status' => 'approved',
        ]);

        // 3. Buat UMKM untuk Budi
        $umkm = Umkm::create([
            'user_id' => $pengusaha->id,
            'name' => 'Kopi Kenangan Senja',
            'contact_number' => '081234567890',
            'description' => 'Kopi mantap jiwa untuk menemani senja.',
            'is_open' => true,
        ]);

        // 4. Buat Menu
        $menu = Menu::create([
            'umkm_id' => $umkm->id,
            'name' => 'Kopi Susu Gula Aren',
            'category' => 'Minuman',
            'description' => 'Perpaduan espresso dan gula aren asli.',
        ]);

        // 5. Buat Kategori Varian & Opsi
        $kategoriUkuran = VariantCategory::create(['menu_id' => $menu->id, 'name' => 'Ukuran']);
        $opsiReguler = VariantOption::create(['variant_category_id' => $kategoriUkuran->id, 'name' => 'Reguler']);
        $opsiLarge = VariantOption::create(['variant_category_id' => $kategoriUkuran->id, 'name' => 'Large']);

        $kategoriSuhu = VariantCategory::create(['menu_id' => $menu->id, 'name' => 'Penyajian']);
        $opsiDingin = VariantOption::create(['variant_category_id' => $kategoriSuhu->id, 'name' => 'Dingin']);
        $opsiPanas = VariantOption::create(['variant_category_id' => $kategoriSuhu->id, 'name' => 'Panas']);

        // 6. Buat Kombinasi Harga & Hubungkan ke Opsi (Pivot)
        
        // Kombinasi 1: Reguler + Dingin = Rp 15.000
        $kombinasi1 = MenuCombination::create(['menu_id' => $menu->id, 'price' => 15000]);
        $kombinasi1->options()->attach([$opsiReguler->id, $opsiDingin->id]);

        // Kombinasi 2: Large + Dingin = Rp 20.000
        $kombinasi2 = MenuCombination::create(['menu_id' => $menu->id, 'price' => 20000]);
        $kombinasi2->options()->attach([$opsiLarge->id, $opsiDingin->id]);
    }
}