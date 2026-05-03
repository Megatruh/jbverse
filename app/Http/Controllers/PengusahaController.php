<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Umkm;
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
}
