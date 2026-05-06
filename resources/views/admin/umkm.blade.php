{{-- resources/views/admin/umkm.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-bold text-2xl text-gray-900">Kelola Seluruh UMKM</h2>
            <p class="text-sm text-gray-500">Pantau gerai aktif dan berikan tindakan jika perlu.</p>
        </div>

        {{-- FITUR SEARCHING --}}
        <form action="{{ route('admin.umkm.index') }}" method="GET" class="w-full md:w-80">
            <div class="relative">
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                    placeholder="Cari toko atau pemilik..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabel UMKM (Potongan dari Dashboard) --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-bold">
                    <tr>
                        <th class="px-6 py-4">Toko / Gerai</th>
                        <th class="px-6 py-4">Pemilik</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($approvedUmkms as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $user->umkm->name ?? 'Tanpa Nama' }}</div>
                                <div class="text-xs text-gray-400">{{ $user->umkm->location ?? 'Lokasi belum diset' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $user->name }}</td>
                            <td class="px-6 py-4">
                                @if ($user->status === 'approved')
                                    <span class="px-2 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">Suspended</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{-- Fitur Suspend --}}
                                @if($user->status === 'approved')
                                    <form action="{{ route('admin.suspend', $user->id) }}" method="POST" onsubmit="return confirm('Bekukan usaha ini?')">
                                        @csrf
                                        <button type="submit" class="text-sm font-bold text-red-600 hover:text-red-800 transition">
                                            Suspend
                                        </button>
                                    </form>
                                @else
                                    <button class="text-xs font-bold text-gray-400 cursor-not-allowed" disabled>Telah Dibekukan</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">Tidak ada data UMKM ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $approvedUmkms->links() }}
        </div>
    </div>
</div>
@endsection