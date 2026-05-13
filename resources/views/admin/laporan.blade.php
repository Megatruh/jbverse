@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col gap-2">
            <h2 class="font-semibold text-3xl text-gray-900">Kelola Laporan UMKM</h2>
            <p class="text-gray-600">Tinjau dan tindak lanjuti laporan dari pengunjung terkait UMKM.</p>
        </div>

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm"
                role="alert">
                <span class="font-medium">✅ {{ session('success') }}</span>
            </div>
        @endif

        <!-- Kontainer Utama -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <div class="p-6 text-gray-900 border-b border-gray-200 mb-4 bg-gray-50">
                <p class="text-sm text-gray-600">Tinjau dan tindak lanjuti laporan dari pengunjung terkait UMKM di bawah ini.
                </p>
            </div>

            <div class="overflow-x-auto pb-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Pelapor</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Toko Terlapor</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Kontak Pengusaha</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Alasan Laporan</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Status Laporan</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-bold text-red-500 uppercase tracking-wider">
                                Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50 transition">
                                <!-- Info Pelapor -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ $laporan->user->name ?? 'Pengguna Dihapus' }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $laporan->created_at->format('d M Y, H:i') }}</div>
                                </td>

                                <!-- Info Toko -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($laporan->umkm)
                                        <a href="{{ route('umkm.detail', $laporan->umkm->slug) }}" target="_blank"
                                            class="text-sm font-bold text-indigo-600 hover:underline">
                                            {{ $laporan->umkm->name }}
                                        </a>
                                    @else
                                        <span class="text-sm font-bold text-gray-500">Toko Telah Dihapus</span>
                                    @endif
                                </td>

                                <!-- Kontak Pengusaha Terlapor -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $contactNumber = optional(optional($laporan->umkm)->user_id ? $laporan->umkm : null)
                                            ? optional($laporan->umkm)->contact_number
                                            : null;
                                        $waNumber = $contactNumber
                                            ? '62' . ltrim(preg_replace('/[^0-9]/', '', $contactNumber), '0')
                                            : '';
                                    @endphp
                                    @if ($contactNumber)
                                        <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                                            class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 font-medium hover:underline transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.117 1.528 5.845L.057 23.882a.75.75 0 00.918.943l6.188-1.462A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22.5c-1.948 0-3.772-.524-5.34-1.438l-.372-.215-3.886.918.952-3.777-.234-.385A10.46 10.46 0 011.5 12C1.5 6.21 6.21 1.5 12 1.5S22.5 6.21 22.5 12 17.79 22.5 12 22.5z"/>
                                            </svg>
                                            {{ $contactNumber }}
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Alasan -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-700 line-clamp-2 max-w-xs" title="{{ $laporan->reason }}">
                                        {{ $laporan->reason }}
                                    </p>
                                </td>

                                <!-- Badge & Ubah Status Laporan -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('admin.laporan.proses', $laporan->id) }}" method="POST"
                                        class="flex justify-center items-center gap-2">
                                        @csrf @method('PATCH')
                                        <select name="status"
                                            class="text-sm border-gray-300 rounded-lg py-1 pl-3 pr-8 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                            onchange="this.form.submit()">
                    
                                            <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>
                                                Diproses
                                            </option>
                                            <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>
                                                Selesai
                                            </option>
                                            <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>
                                                Tolak
                                            </option>
                                        </select>
                                    </form>
                                </td>

                                <!-- KOLOM: Tombol Suspend -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($laporan->umkm && $laporan->umkm->user)
                                        @if ($laporan->umkm->user->status !== 'suspended')
                                            <!-- Form Suspend -->
                                            <form action="{{ route('admin.suspend', $laporan->umkm->user_id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin membekukan akun pengusaha beserta tokonya?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transition">
                                                    Suspend Toko
                                                </button>
                                            </form>
                                        @else
                                            <!-- Jika Sudah Disuspend -->
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                Telah Disuspend
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 text-sm">
                                    Belum ada laporan dari pengunjung.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($laporans->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $laporans->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection