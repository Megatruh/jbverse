@php
    $logoUrl = !empty($umkm->logo)
        ? asset('storage/' . ltrim($umkm->logo, '/'))
        : 'https://ui-avatars.com/api/?name=' . urlencode($umkm->name) . '&color=1F2937&background=F3F4F6&size=80';
@endphp

<x-layouts.public>
    <div class="min-h-screen bg-white">
        <!-- Header -->
        <div class="sticky top-0 z-20 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between px-4 py-4">
                <h1 class="text-lg font-bold text-gray-900">Dashboard Usaha</h1>
                <button class="p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
            </div>

            <!-- Tabs -->
            <div class="flex border-b border-gray-200">
                <a href="{{ route('pengusaha.dashboard') }}"
                    class="flex-1 px-4 py-3 text-center font-medium text-gray-900 border-b-2 border-indigo-600">
                    Dashboard
                </a>
                <a href="{{ route('pengusaha.menu.index') }}"
                    class="flex-1 px-4 py-3 text-center font-medium text-gray-600 border-b-2 border-transparent hover:text-gray-900">
                    Menu
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 py-4 space-y-4">
            <!-- Status Usaha -->
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <div class="flex items-start justify-between mb-4">
                    <h2 class="text-base font-bold text-gray-900">Status Usaha</h2>
                    <form method="POST" action="{{ route('pengusaha.toggle_status') }}"
                        class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" {{ $umkm->is_open ? 'checked' : '' }} onclick="this.form.submit()"
                                class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                            </div>
                        </label>
                        <span class="text-sm font-medium text-green-600">{{ $umkm->is_open ? 'Buka' : 'Tutup' }}</span>
                    </form>
                </div>

                <div class="flex items-center gap-4 mb-3">
                    <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden">
                        <img src="{{ $logoUrl }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">{{ $umkm->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $user->name ?? 'Pemilik' }}</p>
                    </div>
                </div>

                <div class="grid gap-3">
                    <div class="bg-gray-50 rounded p-3">
                        <p class="text-2xl font-bold text-gray-900">{{ (int) ($menusCount ?? 0) }}</p>
                        <p class="text-xs text-gray-600 mt-1">Total Menu Aktif</p>
                    </div>
                    {{-- <div class="bg-yellow-50 rounded p-3">
                        <p class="text-2xl font-bold text-yellow-600">{{ (int) ($verification_count ?? 0) }}</p>
                        <p class="text-xs text-yellow-700 mt-1">Menunggu Verifikasi</p>
                    </div> --}}
                </div>
            </div>

            <!-- Profil Usaha -->
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <h2 class="text-base font-bold text-gray-900 mb-4">Profil Usaha</h2>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha</label>
                        <div class="bg-gray-50 rounded px-3 py-2">
                            <p class="text-sm text-gray-900">{{ $umkm->name }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Usaha</label>
                        <div class="bg-gray-50 rounded px-3 py-2">
                            <p class="text-sm text-gray-700 leading-relaxed line-clamp-3">{{ $umkm->description }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Operasional</label>
                        <div class="bg-gray-50 rounded px-3 py-2">
                            <p class="text-sm text-gray-900">{{ $umkm->operating_hours ?? 'Belum diatur' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lokasi -->
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <h2 class="text-base font-bold text-gray-900 mb-3">Lokasi</h2>
                <div class="bg-gray-100 rounded-lg h-40 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <button class="mt-2 w-full text-center text-sm font-medium text-gray-600 hover:text-gray-900">
                    Pilih Titik Lokasi Baru
                </button>
            </div>

            <!-- Alamat Lengkap -->
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                <div class="bg-gray-50 rounded px-3 py-2">
                    <p class="text-sm text-gray-900">{{ $umkm->address ?? 'Belum diatur' }}</p>
                </div>
            </div>

            <!-- Edit Button -->
            <div class="pb-6">
                <a href="{{ route('pengusaha.edit') }}"
                    class="w-full block text-center bg-gray-800 text-white font-semibold py-3 rounded-lg hover:bg-gray-900 transition">
                    edit profil usaha
                </a>
            </div>
        </div>
    </div>
</x-layouts.public>
