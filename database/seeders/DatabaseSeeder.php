<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan storage publik untuk dummy images setiap kali fresh seed.
        // Ini mencegah penumpukan file lama di storage/app/public.
        $disk = Storage::disk('public');
        foreach (['umkm_banners', 'umkm_logos', 'menu_images'] as $dir) {
            $disk->deleteDirectory($dir);
            $disk->makeDirectory($dir);
        }

        $this->call([
            UserSeeder::class,
            UmkmSeeder::class,
            MenuSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}