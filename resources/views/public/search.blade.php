<x-layouts.public>
    <div class="-mx-4 sm:-mx-6 lg:-mx-8 xl:-mx-23 bg-header rounded-b-2xl sticky top-16 pb-8 z-10 shadow-sm">
        <h1 class="ml-4 py-4 text-xl font-bold text-gray-100 md:text-2xl lg:text-3xl xl:ml-6">Pilih Jajanan
            Favoritmu Hari Ini!</h1>
        <div class="max-w-4xl mx-auto px-4">
            <div class="block bg-gray-100 text-gray-800 relative rounded-lg">
                <input type="text" placeholder="Cari makanan atau minuman..."
                    class="w-full px-3 py-3 border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:outline-none rounded-lg">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-heroicon-o-magnifying-glass
                        class="w-4 h-4 lg:w-5 lg:h-5 text-indigo-900 stroke-3 stroke-indigo-900" />
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- <div class="mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">Cari Menu dan UMKM</h1>
            <p class="text-xl text-gray-500 mb-8">Cari menu lezat atau toko UMKM favorit di JBVerse.</p>

            <form method="GET" action="{{ route('cari.search') }}" class="flex gap-2">
                <input type="text" name="q" placeholder="Cari menu atau UMKM..." value="{{ $query }}"
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    minlength="2">
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 font-medium">
                    Cari
                </button>
            </form>
        </div> --}}

        @if ($query)
            <div class="mb-8">
                <p class="text-gray-600 text-lg">
                    @if (count($menus) > 0 || count($umkms) > 0)
                        Ditemukan <span class="font-bold">{{ count($menus) + count($umkms) }}</span> hasil untuk "<span
                            class="font-semibold">{{ $query }}</span>"
                    @else
                        Tidak ada hasil untuk "<span class="font-semibold">{{ $query }}</span>"
                    @endif
                </p>
            </div>

            @if (count($menus) > 0 || count($umkms) > 0)
                <!-- UMKM Section -->
                @if (count($umkms) > 0)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">🏪 UMKM ({{ count($umkms) }})</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($umkms as $toko)
                                <a href="{{ route('umkm.detail', $toko->slug) }}"
                                    class="block bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group">
                                    <div class="h-48 bg-gray-200">
                                        @if ($toko->image_banner)
                                            <img src="{{ asset('storage/' . $toko->image_banner) }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                                alt="{{ $toko->name }}">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300 text-4xl">
                                                🏪</div>
                                        @endif
                                    </div>
                                    <div class="p-5">
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">
                                            {{ $toko->name }}</h3>
                                        <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $toko->description }}</p>
                                        <div class="mt-4 flex justify-between items-center">
                                            <span
                                                class="text-xs font-semibold text-green-700 bg-green-100 px-2 py-1 rounded-full">Buka</span>
                                            <span
                                                class="text-sm font-medium text-indigo-600 group-hover:underline">Lihat
                                                Toko &rarr;</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Menu Section -->
                @if (count($menus) > 0)
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">🍽️ Menu ({{ count($menus) }})</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($menus as $menu)
                                <a href="{{ route('menu.detail', [$menu->umkm->slug, $menu->slug]) }}"
                                    class="block bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 overflow-hidden group">
                                    <div class="h-40 bg-gray-200 overflow-hidden">
                                        @if ($menu->image)
                                            <img src="{{ asset('storage/' . $menu->image) }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                                                alt="{{ $menu->name }}">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-orange-50 text-orange-300 text-3xl">
                                                🍽️</div>
                                        @endif
                                    </div>
                                    <div class="p-5">
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">
                                            {{ $menu->name }}</h3>
                                        <p class="text-sm text-indigo-600 font-semibold mt-1">dari
                                            {{ $menu->umkm->name }}</p>
                                        <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $menu->description }}</p>
                                        <div class="mt-4 flex justify-between items-center">
                                            <span class="text-lg font-bold text-indigo-600">Rp
                                                {{ number_format($menu->price, 0, ',', '.') }}</span>
                                            <span
                                                class="text-sm font-medium text-indigo-600 group-hover:underline">Lihat
                                                &rarr;</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-12 text-center">
                    <p class="text-yellow-800 text-lg mb-2">😅 Tidak ditemukan</p>
                    <p class="text-yellow-700">Coba gunakan kata kunci yang berbeda atau lebih spesifik.</p>
                </div>
            @endif
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-12 text-center">
                <p class="text-blue-800 text-lg">🔍 Mulai pencarian</p>
                <p class="text-blue-700 mt-2">Masukkan minimal 2 karakter untuk mencari menu atau UMKM.</p>
            </div>
        @endif
    </div>
</x-layouts.public>
