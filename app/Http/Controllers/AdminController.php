<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function dashboard(){
        //ambil data dari pengusaha yang masih menunggu aprooval;
        $pendingUmkms = User::query()->with('umkm')
        ->where('role', 'pengusaha')
        ->where('status', 'pending')
        ->get();

        //ambil data pengusaha yang sudah aproov
        $approvedUmkms = User::query()->with('umkm')
        ->where('role','pengusaha')
        ->where('status','approved')
        ->get();

        return view('admin.dashboard', compact(
            'pendingUmkms', 
            'approvedUmkms',
        ));
    }

    // public function approve($id)
    // {
    //     $user = User::findOrFail($id);
    
    //     if ($user->role === 'pengusaha' && $user->status === 'pending') {
    //         $user->update(['status' => 'approved']);
    //         return back()->with('success', 'UMKM berhasil disetujui!');
    //     }
    
    //     return back()->with('error', 'Data tidak valid.');
    // }
    /**
     * Meng-ACC pendaftaran pengusaha
     */
    public function approve($id){
        $user = User::findOrFail($id);
        if($user->role === 'pengusaha' && $user->status === 'pending'){
            $user->update(['status' => 'approved']);
            return back()->with('success', 'UMKM berhasil disetujui!');
        }
        return back()->with('error', 'Data tidak valid.');
    }

    // /**
    //  * Membekukan (Suspend) atau Menghapus Usaha jika ada laporan
    //  */
    public function suspend($id){
        $user = User::findOrFail($id);
        if($user->role === 'pengusaha'){
            $user->update(['status' => 'suspended']);

            // Pastikan toko tidak tampil di katalog publik saat akun dibekukan.
            if ($user->umkm) {
                $user->umkm->update(['is_open' => false]);
            }

            return back()->with('success', 'Usaha berhasil dibekukan.');
        }
        return back()->with('error', 'Gagal membekukan umkm');
    }
    // public function suspend($id)
    // {
    //     $user = User::findOrFail($id);

    //     if ($user->role === 'pengusaha') {
    //         // Mengubah status menjadi suspended agar tidak bisa login/jualan
    //         $user->update(['status' => 'suspended']);
            
    //         // Opsional: Otomatis tutup tokonya di tabel umkms
    //         if ($user->umkm) {
    //             $user->umkm->update(['is_open' => false]);
    //         }

    //         return back()->with('success', 'Usaha berhasil dibekukan.');
    //     }

    //     return back()->with('error', 'Gagal membekukan usaha.');
    // }
}
