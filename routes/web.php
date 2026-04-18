<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengunjungController;

// Rute Halaman Utama (Katalog UMKM)
Route::get('/', [PengunjungController::class, 'beranda'])->name('beranda');

// Rute Detail Toko
Route::get('/toko/{umkm:slug}', [PengunjungController::class, 'detailToko'])->name('toko.detail');

// Rute Detail Menu (Scoped Binding)
Route::get('/toko/{umkm:slug}/{menu:slug}', [PengunjungController::class, 'detailMenu'])->name('menu.detail');

// ... (Rute bawaan Breeze)

Route::get('/register-mitra', [AuthController::class, 'showRegisterPengusahaForm'])
    ->middleware('guest')
    ->name('register.pengusaha');

Route::post('/register-mitra', [AuthController::class, 'registerPengusaha'])
    ->middleware('guest')
    ->name('register.pengusaha.store');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
