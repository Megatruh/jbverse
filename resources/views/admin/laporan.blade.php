<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Laporan UMKM') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm"
                    role="alert">
                    <span class="font-medium">✅ {{ session('success') }}</span>
                </div>
            @endif

            <!-- Kontainer Utama bergaya Breeze -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900 border-b border-gray-200 mb-4 bg-gray-50">
                    <p class="text-sm text-gray-600">Tinjau dan tindak lanjuti laporan dari pengunjung terkait UMKM di
                        bawah ini.</p>
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
                                    Alasan Laporan</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Status Laporan</th>

                                <!-- KOLOM BARU: Aksi Suspend -->
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
                                            <a href="{{ route('toko.detail', $laporan->umkm->slug) }}" target="_blank"
                                                class="text-sm font-bold text-indigo-600 hover:underline">
                                                {{ $laporan->umkm->name }}
                                            </a>
                                        @else
                                            <span class="text-sm font-bold text-gray-500">Toko Telah Dihapus</span>
                                        @endif
                                    </td>

                                    <!-- Alasan -->
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-700 line-clamp-2 max-w-xs"
                                            title="{{ $laporan->reason }}">
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
                                                <option value="pending"
                                                    {{ $laporan->status == 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="diproses"
                                                    {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Diproses
                                                </option>
                                                <option value="selesai"
                                                    {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai
                                                </option>
                                                <option value="ditolak"
                                                    {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Tolak
                                                </option>
                                            </select>
                                        </form>
                                    </td>

                                    <!-- KOLOM BARU: Tombol Suspend -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($laporan->umkm && $laporan->umkm->user)
                                            @if ($laporan->umkm->user->status !== 'suspended')
                                                <!-- Form Suspend -->
                                                <!-- CATATAN: Pastikan nama route() di bawah ini sesuai dengan yang ada di web.php Anda -->
                                                <form action="{{ route('admin.suspend', $laporan->umkm->user_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin membekukan akun pengusaha beserta tokonya?');">
                                                    @csrf
                                                    <!-- Jika route Anda pakai method POST/PUT/PATCH, atur di sini. Contoh default pakai PATCH: -->
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
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 text-sm">
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
    </div>
</x-app-layout>
