<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Menu;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $userBiasa = User::query()->where('email', 'user@jbverse.com')->first();
        $menuTarget = Menu::query()->where('name', 'Bali Kintamani V60')->first();

        if ($userBiasa && $menuTarget) {
            Review::updateOrCreate(
                [
                    'user_id' => $userBiasa->id,
                    'menu_id' => $menuTarget->id,
                ],
                [
                    'rating' => 5,
                    'comment' => 'Kopinya sangat enak, acidity-nya pas banget!',
                    'reply' => 'Terima kasih atas ulasannya kak! Ditunggu kedatangannya kembali.',
                ]
            );
        }
    }
}
