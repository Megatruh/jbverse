<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Review;
use App\Models\Umkm;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    // ... (fungsi lainnya)

    // PERUBAHAN: Target sekarang adalah $menu_id
    public function kirimUlasan(Request $request, $menu_id)
    {
        // 1. Validasi input
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        // 2. Simpan ulasan ke tabel reviews
        Review::create([
            // 'user_id' => auth()->id(), // Ambil ID pengunjung yang sedang login
            'menu_id' => $menu_id,     // Tautkan ke Menu
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan!');
    }

    public function detailMenu(Umkm $umkm, Menu $menu)
    {
        // Laravel otomatis memastikan $menu adalah milik $umkm
        // Jika pengunjung mencoba jbverse.test/toko-a/menu-punya-toko-b, 
        // Laravel akan otomatis memberikan error 404.

        return view('public.menu-detail', compact('umkm', 'menu'));
    }
}
