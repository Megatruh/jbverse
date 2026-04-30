<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola pendaftaran UMKM baru dan pantau aktivitas pengusaha.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4 border border-green-200">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-md bg-red-50 p-4 border border-red-200">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                <div class="bg-amber-50 border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-amber-900">Menunggu Persetujuan</h3>
                        <p class="text-sm text-amber-700">Pendaftaran UMKM baru yang butuh verifikasi admin.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-sm font-bold text-amber-800">
                        {{ $pendingUmkms->count() }} Antrean
                    </span>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @forelse ($pendingUmkms as $user)
                        <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-gray-50 transition">
                            <div class="flex items-start gap-4">
                                <div class="h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                                    <span class="text-amber-800 font-bold text-lg">{{ substr(optional($user->umkm)->name ?? 'U', 0, 1) }}</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ optional($user->umkm)->name ?? 'Data UMKM Belum Lengkap' }}</h4>
                                    <p class="text-sm text-gray-500 font-medium">Pemilik: {{ $user->name }} ({{ $user->email }})</p>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <p><span class="font-medium">Kontak:</span> {{ optional($user->umkm)->contact_number ?? 'Belum diisi' }}</p>
                                        <p class="mt-1 line-clamp-2"><span class="font-medium">Deskripsi:</span> {{ optional($user->umkm)->description ?? 'Belum diisi' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="shrink-0 flex items-center gap-2">
                                <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Yakin ingin menyetujui UMKM ini?')" class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition">
                                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                        Setujui (ACC)
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada antrean</h3>
                            <p class="mt-1 text-sm text-gray-500">Semua pendaftaran pengusaha sudah diproses.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                <div class="bg-white border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-bold text-gray-900">UMKM Terdaftar & Aktif</h3>
                    <p class="text-sm text-gray-500">Daftar pengusaha yang sudah disetujui dan beroperasi di JBVerse.</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900">Nama Toko & Pemilik</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Kontak</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status Operasional</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-6 sm:pr-6 text-right text-sm font-semibold text-gray-900">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($approvedUmkms as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm">
                                        <div class="font-bold text-gray-900">{{ optional($user->umkm)->name ?? 'N/A' }}</div>
                                        <div class="text-gray-500">{{ $user->name }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ optional($user->umkm)->contact_number ?? '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if(optional($user->umkm)->is_open)
                                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Sedang Buka</span>
                                        @else
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Tutup</span>
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                        <form action="{{ route('admin.suspend', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" onclick="return confirm('Tindakan ini akan membekukan akun pengusaha. Lanjutkan?')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded transition">
                                                Bekukan (Suspend)
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-sm text-gray-500">
                                        Belum ada UMKM yang disetujui.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>