<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PengusahaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    $role = Auth::user()->role;
    if($role === 'admin'){
        return redirect()->route('admin.dashboard');
    } elseif($role == 'pengusaha') {
        return redirect()->route('pengusaha.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//kerjaan Farhan : 
Route::middleware(['auth', 'pengusaha'])->group(function(){
    // atur routes ke dashboard pengusaha
    Route::get('/pengusaha/dashboard', [
        PengusahaController::class, 
        'dashboard'
    ])->name('pengusaha.dashboard');

    // Rute untuk submit pelengkapan profil
    Route::patch('/pengusaha/lengkapi-profil', [
        PengusahaController::class, 
        'simpanProfil'
    ])->name('pengusaha.simpan_profil');

    // Toggle status buka/tutup toko
    Route::patch('/pengusaha/toko/toggle-status', [
        PengusahaController::class,
        'toggleStatus'
    ])->name('pengusaha.toggle_status');
    
    // Tambahkan ini
    Route::get('/pengusaha/edit', [
        PengusahaController::class, 
        'edit'
    ])->name('pengusaha.edit');

    Route::patch('/pengusaha/update', [
        PengusahaController::class, 
        'update'
    ])->name('pengusaha.update');
});

Route::middleware(['auth','admin'])->group(function(){
    Route::get('/admin/dashboard', [
        AdminController::class,
        'dashboard',
    ])->name('admin.dashboard');
});
require __DIR__.'/auth.php';
