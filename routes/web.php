<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

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
