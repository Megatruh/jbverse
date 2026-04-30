<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;

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
        // 1. Validasi Inputan (Foto dan Kontak dihilangkan dari kewajiban awal)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Password::defaults()],
            'umkm_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        // 2. Simpan Kredensial ke tabel `users`
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengusaha',
            'status' => 'pending', 
        ]);

        // 3. Simpan Profil Toko (Data awal) ke tabel `umkms`
        Umkm::create([
            'user_id' => $user->id, 
            'name' => $request->umkm_name,
            'contact_number' => '', // Dikosongkan dulu, diisi setelah login
            'description' => $request->description,
            'is_open' => false, 
        ]);

        // 4. Langsung Login agar bisa melengkapi data
        Auth::login($user);

        // 5. Arahkan ke dashboard pengusaha
        return redirect()->route('pengusaha.dashboard');
    }
}