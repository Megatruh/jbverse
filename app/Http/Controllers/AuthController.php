<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    // Menampilkan halaman form
    public function showRegisterPengusahaForm()
    {
        return view('auth.register-pengusaha');
    }

    // Memproses data pendaftaran
    public function registerPengusaha(Request $request)
    {
        // 1. Validasi Inputan
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'umkm_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'description' => ['required', 'string'],
            'image_banner' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Maksimal 2MB
        ]);

        // 2. Proses Upload Foto Bukti Gerai
        // File akan disimpan di folder storage/app/public/umkm_banners
        $imagePath = null;
        if ($request->hasFile('image_banner')) {
            $imagePath = $request->file('image_banner')->store('umkm_banners', 'public');
        }

        // 3. Simpan Kredensial ke tabel `users`
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengusaha',
            'status' => 'pending', // PENTING: Kunci akun agar tidak bisa login langsung
        ]);

        // 4. Simpan Profil Toko ke tabel `umkms`
        Umkm::create([
            'user_id' => $user->id, // Hubungkan dengan user yang baru dibuat di atas
            'name' => $request->umkm_name,
            'contact_number' => $request->contact_number,
            'description' => $request->description,
            'image_banner' => $imagePath,
            'is_open' => false, // Toko baru belum boleh jualan
        ]);

        // 5. Arahkan pengguna (Redirect)
        // Karena statusnya masih 'pending', kita jangan panggil auth()->login($user).
        // Arahkan ke halaman login dengan pesan sukses.
        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Akun Anda sedang ditinjau oleh Admin. Silakan tunggu konfirmasi.');
    }
}