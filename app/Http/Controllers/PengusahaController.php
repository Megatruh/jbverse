<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Umkm;
use App\Models\Menu; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PengusahaController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Pengusaha
     */

    public function balasUlasan(Request $request, Review $review)
    {
        // 1. Pastikan ulasan ini adalah milik menu dari UMKM pengusaha tersebut
        abort_if($review->menu->umkm_id !== $request->user()->umkm->id, 403);

        // 2. REVISI: Cek apakah sudah pernah dibalas sebelumnya
        if ($review->reply !== null) {
            return redirect()->back()->with('error', 'Anda sudah membalas ulasan ini sebelumnya.');
        }

        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        // 3. Simpan balasan
        $review->update([
            'reply' => $request->reply,
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $umkm = Umkm::query()->where('user_id', $user->id)->first();

        if (!$umkm) {
            abort(404, 'Data UMKM tidak ditemukan untuk akun ini.');
        }

        // KONDISI 1: Jika status Suspended
        if ($user->status === 'suspended') {
            return view('pengusaha.suspended', compact('user', 'umkm'));
        }

        // KONDISI 2: Cek apakah data krusial belum diisi
        if (empty($umkm->contact_number) || empty($umkm->description) || empty($umkm->image_banner)) {
            return view('pengusaha.lengkapi_profil', compact('umkm'));
        }

        // KONDISI 3: Menunggu approval dari admin
        if ($user->status === 'pending') {
            return view('pengusaha.waiting_approval');
        }

        $menusCount = $umkm->menus()->count();
        $reviewsCount = $umkm->reviews()->count();
        $avgRating = $umkm->reviews()->avg('rating');

        $latestMenus = $umkm->menus()->latest()->take(5)->get();
        $latestReviews = $umkm->reviews()
            ->with(['user', 'menu'])
            ->latest()
            ->take(5)
            ->get();

        return view('pengusaha.dashboard', compact(
            'user',
            'umkm',
            'menusCount',
            'reviewsCount',
            'avgRating',
            'latestMenus',
            'latestReviews'
        ));
    }

    public function simpanProfil(Request $request)
    {
        $request->validate([
            'contact_number' => ['required', 'string', 'max:20'],
            'description' => ['required', 'string', 'max:2000'],
            'image_banner' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Maks 2MB
        ]);

        $user = Auth::user();
        $umkm = Umkm::query()->where('user_id', $user->id)->first();

        // Simpan foto di lokal (folder: storage/app/public/umkm_logos)
        // dan masukkan nama filenya ke database
        if ($request->hasFile('logo')) {
            $pathLogo = $request->file('logo')->store('umkm_logos', 'public');
            $umkm->logo = $pathLogo;
        }

        if ($request->hasFile('image_banner')) {
            $pathBanner = $request->file('image_banner')->store('umkm_banners', 'public');
            $umkm->image_banner = $pathBanner;
        }

        // Simpan data
        $umkm->contact_number = $request->contact_number;
        $umkm->description = $request->description;
        $umkm->save();

        // Redirect kembali ke dashboard (sekarang akan masuk ke halaman Waiting Approval)
        return redirect()->route('pengusaha.dashboard')->with('status', 'Profil berhasil dilengkapi! Menunggu verifikasi admin.');
    }

    /**
     * Toggle status buka/tutup toko (is_open)
     */
    public function toggleStatus()
    {
        $user = Auth::user();
        $umkm = Umkm::query()->where('user_id', $user->id)->first();

        if (!$umkm) {
            abort(404, 'Data UMKM tidak ditemukan untuk akun ini.');
        }

        $umkm->is_open = !$umkm->is_open;
        $umkm->save();

        $label = $umkm->is_open ? 'buka' : 'tutup';

        return back()->with('status', "Status toko berhasil diubah: sekarang $label.");
    }


    public function edit()
    {
        $user = Auth::user();
        $umkm = Umkm::query()->where('user_id', $user->id)->first();

        return view('pengusaha.edit', compact('umkm'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $umkm = Umkm::query()->where('user_id', $user->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update data teks
        $umkm->name = $request->name;
        $umkm->contact_number = $request->contact_number;
        $umkm->description = $request->description;

        // Handle Upload Logo (Foto Profil Toko)
        if ($request->hasFile('logo')) {
            // Hapus foto lama jika ada untuk menghemat ruang
            if ($umkm->logo) {
                Storage::disk('public')->delete($umkm->logo);
            }
            $umkm->logo = $request->file('logo')->store('umkm_logos', 'public');
        }

        // Handle Upload Banner
        if ($request->hasFile('image_banner')) {
            // Hapus banner lama jika ada
            if ($umkm->image_banner) {
                Storage::disk('public')->delete($umkm->image_banner);
            }
            $umkm->image_banner = $request->file('image_banner')->store('umkm_banners', 'public');
        }

        $umkm->save();

        return redirect()->route('pengusaha.dashboard')->with('status', 'Profil UMKM berhasil diperbarui!');
    }

    /**
     * Mengajukan pengaktifan kembali
     */
    public function requestReactivate()
    {
        $user = Auth::user();

        // Kita ubah statusnya kembali ke 'pending' agar muncul di daftar verifikasi Admin
        // Tapi kamu bisa tambahkan kolom 'pesan_banding' di database jika perlu
        $user->update(['status' => 'pending']);

        return redirect()
            ->route('pengusaha.dashboard')
            ->with(
                'status',
                'Permintaan aktivasi ulang telah dikirim ke Admin.'
            );
    }
    /**
     * Menampilkan form tambah menu
     */
    public function createMenu()
    {
        $user = Auth::user();
        
        // Pastikan akun tidak disuspend
        if ($user->status === 'suspended') {
            return redirect()->route('pengusaha.dashboard')->with('error', 'Akun ditangguhkan. Tidak bisa menambah menu.');
        }

        return view('pengusaha.menu.create');
    }

    /**
     * Menyimpan data menu baru ke database
     */
/**
     * Menyimpan data menu baru ke database
     */
    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ukuran' => 'required|string|max:100',
            'variant' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $umkm = Auth::user()->umkm;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
        }

        // Simpan langsung ke tabel menus secara simpel
        Menu::create([
            'umkm_id' => $umkm->id,
            'name' => $request->name,
            'category' => $request->category,
            // Kolom description di DB tidak nullable, jadi pastikan string.
            'description' => $request->description ?? '',
            'image' => $imagePath,
            'ukuran' => $request->ukuran,
            'variant' => $request->variant,
            'price' => $request->price, 
        ]);

        return redirect()->route('pengusaha.dashboard')->with('status', 'Menu berhasil ditambahkan!');
    }

    /**
     * Menampilkan daftar semua menu
     */
    public function indexMenu()
    {
        $umkm = Auth::user()->umkm;
        
        // Ambil semua menu milik UMKM ini, urutkan dari yang terbaru
        $menus = Menu::query()->where('umkm_id', $umkm->id)->latest()->paginate(10);
        
        return view('pengusaha.menu.index', compact('menus'));
    }
    /**
     * Menghapus menu
     */
    public function destroyMenu(Menu $menu)
    {
        // Keamanan: Pastikan menu yang dihapus benar-benar milik pengusaha yang login
        if ($menu->umkm_id !== Auth::user()->umkm->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus menu ini.');
        }

        // Hapus foto fisik dari folder storage jika ada
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        Menu::destroy($menu->id);

        return redirect()->route('pengusaha.menu.index')->with('status', 'Menu berhasil dihapus!');
    }        
}
