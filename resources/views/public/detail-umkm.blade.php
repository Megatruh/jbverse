<x-layouts.public>
    {{-- <x-app-layout> --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        {{-- Banner --}}
        <div class="-mx-4 sm:mx-0">
            <div class="w-full h-48 md:h-64 overflow-hidden sm:rounded-b-xl">
                @if ($umkm->image_banner)
                    <img src="{{ asset('storage/' . $umkm->image_banner) }}" class="w-full h-full object-cover"
                        alt="{{ $umkm->name }}">
                @else
                    <div
                        class="w-full h-full flex items-center justify-center bg-linear-to-r from-indigo-500 to-indigo-700 text-white text-4xl">
                        🏪 {{ strtoupper(substr($umkm->name, 0, 2)) }}
                    </div>
                @endif
            </div>
        </div>


        {{-- Header Profil UMKM --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-10 mt-4">
            <div class="flex flex-col md:flex-row gap-6 p-6 md:p-8">
                {{-- Informasi UMKM --}}
                <div class="flex-1">
                    {{-- Baris Nama + Status Buka/Tutup --}}
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $umkm->name }}</h1>
                        <span
                            class="text-sm font-semibold px-3 py-1 rounded-full {{ $umkm->is_open ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $umkm->is_open ? '● Buka' : '● Tutup' }}
                        </span>
                    </div>

                    {{-- Deskripsi --}}
                    <p class="mt-3 text-gray-600 leading-relaxed">{{ $umkm->description }}</p>

                    {{-- Info tambahan: Lokasi, Jam Operasional, Google Maps --}}
                    <div class="mt-5 block gap-x-6 gap-y-3 text-sm">
                        {{-- Lokasi / Alamat --}}
                        <div class="my-1 flex items-center gap-1 text-gray-600">
                            <a href="https://www.google.com/maps?q={{ $umkm->latitude }},{{ $umkm->longitude }}" target="_blank" class="gap-1 flex items-center text-gray-600 hover:text-indigo-800">
                                <x-heroicon-o-map-pin class="w-4 h-4 text-gray-600" />

                            @if (!$umkm->latitude && !$umkm->longitude)
                                <span>Alamat tidak tersedia</span>
                            @endif
                                <span>JB Lanud</span>
                            </a>
                        </div>
                    </div>

                    {{-- Tombol Laporan (hanya untuk user yang login) --}}
                    @auth
                        @if (in_array(auth()->user()->role, ['user', 'pengusaha']))
                            <div x-data="{ open: false }" class="mt-6 pt-4 border-t border-gray-100">
                                <button @click="open = !open"
                                    class="w-full sm:w-auto px-4 py-2 border border-red-300 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium text-sm flex items-center justify-center gap-1 transition">
                                    <x-heroicon-o-flag class="w-4 h-4" />
                                    Laporkan Usaha Ini
                                </button>
                                <form x-show="open" action="{{ route('lapor.store', $umkm->slug) }}" method="POST"
                                    class="mt-3 space-y-2" style="display: none;">
                                    @csrf
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Pelaporan</label>
                                    <input type="text" name="reason"
                                        placeholder="Contoh: Toko palsu, penipuan, atau melanggar aturan..."
                                        class="w-full py-2 pl-2 text-xs sm:text-sm rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500"
                                        required>
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition flex items-center gap-2">
                                        <x-heroicon-o-paper-airplane class="w-4 h-4" />
                                        Kirim Laporan
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        {{-- Menu Pilihan --}}
        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            Menu Pilihan
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-2.5 justify-center">
            @forelse($menus as $menu)
                <a href="{{ route('menu.detail', [$umkm->slug, $menu->slug]) }}"
                    class="w-45 block h-75 sm:w-50 sm:max-w-55 md:w-55 md:max-w-60 lg:w-60 lg:max-w-75 xl:w-70 m-1 bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group relative">
                    <div class="h-45 xl:h-50 bg-gray-200 relative">
                        @if ($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                alt="{{ $menu->name }}">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300 text-4xl">
                                🍽️
                            </div>
                        @endif
                        {{-- Rating menu di kanan atas --}}
                        <div class="absolute right-2 top-2 flex items-center gap-1 px-2 bg-gray-300/30 rounded-full">
                            <x-heroicon-s-star class="w-2 h-2 text-yellow-500" />
                            <span class="text-tiny">3.0</span>
                        </div>
                    </div>
                    <div class="p-2 ml-1">
                        <h3
                            class="text-md font-semibold md:font-bold text-gray-900 group-hover:text-indigo-600 line-clamp-1">
                            {{ $menu->name }}</h3>
                        <p class="mt-1 text-tiny sm:text-xs text-gray-400 line-clamp-1">{{ $umkm->name }}</p>
                        <div class="absolute left-0 bottom-0 pb-2 pl-3">
                            <span class="text-sm font-bold text-indigo-600">Rp
                                {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Toko ini belum menambahkan menu.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.public>
{{-- </x-app-layout> --}}
