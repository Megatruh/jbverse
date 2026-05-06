<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Report;
use App\Models\Review;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function beranda()
    {
        $user = Auth::user();

        if ($user?->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user?->role === 'pengusaha') {
            return redirect()->route('pengusaha.dashboard');
        }
        // Ambil menus dari UMKM yang sedang buka
        $menus = Menu::query()
            ->whereHas('umkm', function ($query) {
                $query->where('is_open', true);
            })
            ->with('umkm')
            ->latest()
            ->paginate(12);

        return view('public.beranda', compact([
            'menus',
            'user'
        ]));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        // // 1. Pencarian UMKM (Hanya yang sedang buka)
        $umkms = Umkm::query()
            // ->where('is_open', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->take(5) // Batasi 5 untuk dropdown suggestion
            ->get();

        // // 2. Pencarian Menu (Hanya dari toko yang sedang buka)
        $menus = Menu::with('umkm')
            ->whereHas('umkm', function($q) {
                $q->where('is_open', true);
            })
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%{$query}%");
            })
            ->take(5) // Batasi 5 untuk dropdown suggestion
            ->get();

        // 3. Jika request datang dari JavaScript (saat user mengetik)
        if ($request->wantsJson() || $request->ajax() || $request->header('Accept') == 'application/json') {
            return response()->json([
                'umkms' => $umkms,
                // 'menus' => $menus
            ]);
        }

        // 4. Jika user menekan tombol "Enter" atau ikon kaca pembesar
        // Kita ambil data pagination-nya
        $menusPaginated = Menu::with('umkm')
            // ->whereHas('umkm', function($q) {
            //     $q->where('is_open', true);
            // })
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%{$query}%");
            })
            ->paginate(12)
            ->withQueryString(); // Mempertahankan parameter ?q= saat pindah halaman

        // Kembalikan ke halaman beranda dengan data menu hasil pencarian
        return view('public.beranda', [
            'menus' => $menusPaginated,
            'searchQuery' => $query
        ]);
    }

    public function detailToko(Umkm $umkm)
    {
        abort_if(!$umkm->is_open, 404, 'Toko sedang tutup.');
        $menus = $umkm->menus()->latest()->get();
        return view('public.detail-umkm', compact('umkm', 'menus'));
    }

    public function detailMenu(Umkm $umkm, Menu $menu)
    {
        abort_if($menu->umkm_id !== $umkm->id, 404);
        $menu->load(['reviews.user']);
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
            'status'   => 'diproses',
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

    // // Fungsi Pencarian Menu dan UMKM
    // public function search(Request $request)
    // {
    //     $query = $request->input('q', '');
    //     $menus = [];
    //     $umkms = [];

    //     if (strlen($query) >= 2) {
    //         // Cari Menu
    //         $menus = Menu::query()
    //             ->with('umkm:id,name,slug,description,price')
    //             ->where('name', 'like', '%' . $query . '%')
    //             ->whereHas('umkm', function ($q) {
    //                 $q->where('is_open', true);
    //             })
    //             ->select('id', 'umkm_id', 'name', 'slug', 'price')
    //             ->limit(10)
    //             ->get();

    //         // Cari UMKM
    //         $umkms = Umkm::query()
    //             ->where('name', 'like', '%' . $query . '%')
    //             ->where('is_open', true)
    //             ->select('id', 'name', 'slug', 'description')
    //             ->limit(10)
    //             ->get();
    //     }

    //     if ($request->wantsJson()) {
    //         return response()->json([
    //             'menus' => $menus->map(fn($menu) => [
    //                 'id' => $menu->id,
    //                 'name' => $menu->name,
    //                 'slug' => $menu->slug,
    //                 'price' => $menu->price,
    //                 'umkm' => [
    //                     'id' => $menu->umkm->id,
    //                     'name' => $menu->umkm->name,
    //                     'slug' => $menu->umkm->slug,
    //                 ]
    //             ]),
    //             'umkms' => $umkms->map(fn($umkm) => [
    //                 'id' => $umkm->id,
    //                 'name' => $umkm->name,
    //                 'slug' => $umkm->slug,
    //                 'description' => $umkm->description,
    //             ]),
    //         ]);
    //     }

    //     return view('public.search', compact('menus', 'umkms', 'query'));
    // }
}
