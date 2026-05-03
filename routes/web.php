<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PengusahaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rute Halaman Utama (Katalog UMKM)
Route::get('/', [UserController::class, 'beranda'])->name('public.beranda');

// Rute Detail Toko
Route::get('/toko/{umkm:slug}', [UserController::class, 'detailToko'])->name('toko.detail');

// Rute Detail Menu (Scoped Binding)
Route::get('/toko/{umkm:slug}/{menu:slug}', [UserController::class, 'detailMenu'])->name('menu.detail');

//rute user
// Route::middleware(['auth', 'user'])->group(function () {
Route::middleware('auth')->group(function () {
    Route::post('/toko/{umkm:slug}/{menu:slug}/ulasan', [UserController::class, 'kirimUlasan'])->name('ulasan.store');
    Route::post('/toko/{umkm:slug}/lapor', [UserController::class, 'laporUmkm'])->name('lapor.store');
    Route::put('/ulasan/{review}', [UserController::class, 'updateUlasan'])->name('ulasan.update');
    Route::delete('/ulasan/{review}', [UserController::class, 'hapusUlasan'])->name('ulasan.destroy');
});

// ... (Rute bawaan Breeze)

Route::get('/register-mitra', [AuthController::class, 'showRegisterPengusahaForm'])
    ->middleware('guest')
    ->name('register.pengusaha');

Route::post('/register-mitra', [AuthController::class, 'registerPengusaha'])
    ->middleware('guest')
    ->name('register.pengusaha.store');

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user?->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->role === 'pengusaha') {
        return redirect()->route('pengusaha.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'pengusaha'])->prefix('pengusaha')->name('pengusaha.')->group(function(){
    // atur routes ke dashboard pengusaha
    Route::get('/dashboard', [
        PengusahaController::class, 
        'dashboard'
    ])->name('dashboard');

    // Rute untuk submit pelengkapan profil
    Route::patch('/lengkapi-profil', [
        PengusahaController::class, 
        'simpanProfil'
    ])->name('simpan_profil');

    // Toggle status buka/tutup toko
    Route::patch('/toko/toggle-status', [
        PengusahaController::class,
        'toggleStatus'
    ])->name('toggle_status');

    // Tambahkan ini
    Route::get('/edit', [
        PengusahaController::class, 
        'edit'
    ])->name('edit');

    Route::patch('/update', [
        PengusahaController::class, 
        'update'
    ])->name('update');

    // pengusaha yang mau aktivasi kembali akun yang tersuspend
    Route::post('/request-reactivate', [
        PengusahaController::class, 
        'requestReactivate'
    ])->name('request_reactivate');

    // Rute CRUD Menu Pengusaha
    Route::get('/menu/tambah', [
        PengusahaController::class, 
        'createMenu'
        ])->name('menu.create');

    Route::post('/menu/simpan', [
        PengusahaController::class, 
        'storeMenu'])->name('menu.store');    
    
    Route::get('/menu', [
        PengusahaController::class, 
        'indexMenu'])->name('menu.index');
        
    Route::delete('/menu/{menu}', [
        PengusahaController::class, 
<<<<<<< HEAD
        'destroyMenu'])->name('menu.destroy');  
    
    Route::post('/ulasan/{review}/balas', [PengusahaController::class, 'balasUlasan'])->name('ulasan.balas');
    Route::delete('/ulasan/{review}/balas', [PengusahaController::class, 'hapusBalasan'])->name('ulasan.hapus-balasan');
=======
        'destroyMenu'])->name('menu.destroy');        
>>>>>>> 040fe2fea0b18762f497142140af0480122196ca
});

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [
        AdminController::class,
        'dashboard',
    ])->name('dashboard');
    // Aksi ACC dan Suspend
    //aksi aprrove umkm
    Route::patch('approve/{id}', [
        AdminController::class, 
        'approve'
    ])->name('approve');
    //aksi suspend umkm
    Route::patch('suspend/{id}', [
        AdminController::class, 
        'suspend'
    ])->name('suspend');
    Route::get('/laporan', [AdminController::class, 'kelolaLaporan'])->name('laporan.index');
    Route::patch('/laporan/{report}', [AdminController::class, 'prosesLaporan'])->name('laporan.proses');
});
require __DIR__.'/auth.php';