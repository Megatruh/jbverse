<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Menu;
use App\Models\Review;
use App\Models\Report;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function beranda()
    {
        $menus = Menu::query()
            ->with(['umkm', 'menuCombinations', 'reviews'])
            ->latest()
            ->paginate(12);
        
        return view('public.beranda', compact('menus'));
    }

    public function detailToko(Umkm $umkm)
    {
        abort_if(!$umkm->is_open, 404, 'Toko sedang tutup.');
        $menus = $umkm->menus()->with('variantCategories')->latest()->get();
        return view('public.detail-umkm', compact('umkm', 'menus'));
    }

    public function detailMenu(Umkm $umkm, Menu $menu)
    {
        abort_if($menu->umkm_id !== $umkm->id, 404);
        $menu->load(['variantCategories.options', 'menuCombinations.options', 'reviews.user']);
        return view('public.detail-menu', compact('umkm', 'menu'));
    }

    public function kirimUlasan(Request $request, Umkm $umkm, Menu $menu)
    {
        abort_if($menu->umkm_id !== $umkm->id, 404);

        // Cek apakah user sudah pernah memberi ulasan (1 menu 1 ulasan)
        $sudahAdaUlasan = Review::query()
                                ->where('user_id', $request->user()->id)
                                ->where('menu_id', $menu->id)
                                ->exists();

        if ($sudahAdaUlasan) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk menu ini sebelumnya.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => $request->user()->id,
            'menu_id' => $menu->id,
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan! Terima kasih.');
    }

    public function laporUmkm(Request $request, Umkm $umkm)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        Report::create([
            'user_id'  => $request->user()->id,
            'umkm_id'  => $umkm->id,
            'reason'   => $request->reason,
            'status'   => 'pending',
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim ke Admin untuk ditindaklanjuti.');
    }

    // Fungsi Edit Ulasan
    public function updateUlasan(Request $request, Review $review)
    {
        abort_if($review->user_id !== $request->user()->id, 403, 'Akses ditolak.');

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->back()->with('success', 'Ulasan Anda berhasil diperbarui.');
    }

    // Fungsi Hapus Ulasan
    public function hapusUlasan(Request $request, Review $review)
    {
        abort_if($review->user_id !== $request->user()->id, 403, 'Akses ditolak.');
        Review::query()->where('id', $review->id)->delete();
        return redirect()->back()->with('success', 'Ulasan Anda berhasil dihapus.');
    }
}