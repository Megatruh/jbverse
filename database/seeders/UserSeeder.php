<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@jbverse.test'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'approved',
            ]
        );

        // Pengusaha
        User::updateOrCreate(
            ['email' => 'budi@jbverse.test'],
            [
                'name' => 'Budi Pengusaha',
                'password' => Hash::make('password123'),
                'role' => 'pengusaha',
                'status' => 'approved',
            ]
        );

        User::create([
            'name' => 'Pengunjung Setia',
            'slug' => 'pengunjung-setia',
            'email' => 'user@jbverse.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'status' => 'approved',
        ]);
    }
}
