<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    // Menampilkan halaman utama (Daftar semua UMKM)
    public function beranda()
    {
        // Ambil UMKM yang statusnya buka, urutkan dari yang terbaru, batasi 12 per halaman
        $umkms = Umkm::where('is_open', true)->latest()->paginate(12);
        
        return view('public.beranda', compact('umkms'));
    }

    // Menampilkan profil toko beserta daftar menunya
    public function detailToko(Umkm $umkm)
    {
        // Jika ada pengunjung iseng mengetik URL toko yang sedang tutup, tampilkan error 404
        abort_if(!$umkm->is_open, 404);

        // Ambil semua menu milik UMKM ini
        $menus = $umkm->menus()->latest()->get();

        return view('public.detail-umkm', compact('umkm', 'menus'));
    }

    // (Ini yang sudah kita bahas sebelumnya untuk fitur Scoped Binding)
    public function detailMenu(Umkm $umkm, Menu $menu)
    {
        return view('public.detail-menu', compact('umkm', 'menu'));
    }
}
