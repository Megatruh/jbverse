{{-- resources/views/admin/permintaan.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div>
        <h2 class="font-bold text-2xl text-gray-900">Permintaan Akun Pengusaha</h2>
        <p class="text-sm text-gray-500">Tinjau bukti evidence dan setujui pendaftaran baru.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-bold">
                <tr>
                    <th class="px-6 py-4">Nama Pendaftar</th>
                    <th class="px-6 py-4">Nama Toko</th>
                    <th class="px-6 py-4">Evidence</th>
                    <th class="px-6 py-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($pendingUmkms as $user)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->umkm->name }}</td>
                        <td class="px-6 py-4 text-indigo-600 font-bold">
                            {{-- Evidence link placeholder --}}
                            <a href="#" class="hover:underline">Lihat Bukti</a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition">
                                    Setujui (ACC)
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">Tidak ada permintaan pendaftaran baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection