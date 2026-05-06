<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $activeUmkmCount = Umkm::query()
            ->where('is_open', true)
            ->whereHas('user', function ($query) {
                $query->where('status', 'approved');
            })
            ->count('*');

        //ambil data dari pengusaha yang masih menunggu aprooval;
        $pendingUmkms = User::query()->with('umkm')
            ->where('role', 'pengusaha')
            ->where('status', 'pending')
            ->get();

        $pendingCount = $pendingUmkms->count();

        //ambil data pengusaha yang sudah aproov
        $approvedUmkms = User::query()->with('umkm')
            ->where('role', 'pengusaha')
            ->where('status', 'approved')
            ->latest()
            ->paginate(10);

        $approvedCount = User::query()
            ->where('role', 'pengusaha')
            ->where('status', 'approved')
            ->count('*');

        $suspendedUmkms = User::query()
            ->with('umkm')
            ->where('role', 'pengusaha')
            ->where('status', 'suspended')
            ->latest()
            ->paginate(5);

        //ambil data laporan user
        $laporans = Report::query()
            ->with(['user', 'umkm'])
            ->latest() // Urutkan dari yang terbaru
            ->paginate(5);

        $reportCount = Report::query()->count('*');

        return view('admin.dashboard', compact(
            'activeUmkmCount',
            'pendingCount',
            'approvedCount',
            'reportCount',
            'pendingUmkms',
            'approvedUmkms',
            'laporans',
            'suspendedUmkms'
        ));
    }

    /**
     * Meng-ACC pendaftaran pengusaha
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'pengusaha' && $user->status === 'pending') {
            $user->update(['status' => 'approved']);
            return back()->with('success', 'UMKM berhasil disetujui!');
        }
        return back()->with('error', 'Data tidak valid.');
    }

    // /**
    //  * Membekukan (Suspend) atau Menghapus Usaha jika ada laporan
    //  */
    public function suspend($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'pengusaha') {
            $user->update(['status' => 'suspended']);

            // Pastikan toko tidak tampil di katalog publik saat akun dibekukan.
            if ($user->umkm) {
                $user->umkm->update(['is_open' => false]);
            }

            return back()->with('success', 'Usaha berhasil dibekukan.');
        }
        return back()->with('error', 'Gagal membekukan umkm');
    }

    public function kelolaLaporan()
    {
        $laporans = Report::query()
            ->with(['user', 'umkm'])
            ->latest() // Urutkan dari yang terbaru
            ->paginate(15);

        return view('admin.laporan', compact('laporans'));
    }

    public function prosesLaporan(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,ditolak,selesai',
        ]);

        $report->status = $request->status;
        $report->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function indexUmkm(Request $request)
    {
        $keyword = $request->input('keyword');

        // Mengambil UMKM yang sudah aktif (approved) atau yang sedang disuspend
        $approvedUmkms = User::query()
            ->with('umkm')
            ->where('role', 'pengusaha')
            ->whereIn('status', ['approved', 'suspended'])
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%") // Cari nama pemilik
                        ->orWhereHas('umkm', function ($qu) use ($keyword) {
                            $qu->where('name', 'like', "%{$keyword}%"); // Cari nama toko
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.umkm', compact('approvedUmkms'));
    }

    public function permintaan()
    {
        // Mengambil data pengusaha yang masih menunggu approval
        $pendingUmkms = User::query()
            ->with('umkm')
            ->where('role', 'pengusaha')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.permintaan', compact('pendingUmkms'));
    }
}
