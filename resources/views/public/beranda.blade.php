<x-layouts.public>
    {{-- <x-app-layout> --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 relative">
        <div class="-mx-4 sm:-mx-6 lg:-mx-8 xl:-mx-23 bg-header rounded-b-2xl sticky top-16 pb-8 z-10 shadow-sm">
            <h1 class="ml-4 py-4 text-xl font-bold text-gray-100 md:text-2xl lg:text-3xl xl:ml-6">Pilih Jajanan
                Favoritmu Hari Ini!</h1>
            <div class="max-w-4xl mx-auto px-4">
                <form method="GET" action="{{ route('cari.search') }}" class="relative">
                    <div class="block bg-gray-100 text-gray-800 relative rounded-lg">
                        <input type="text" name="q" placeholder="Cari makanan atau minuman..." minlength="2"
                            id="searchInput"
                            class="w-full px-3 py-3 pr-10 border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:outline-none rounded-lg">
                        <button type="submit"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 hover:text-indigo-700">
                            <x-heroicon-o-magnifying-glass
                                class="w-4 h-4 lg:w-5 lg:h-5 text-indigo-900 stroke-3 stroke-indigo-900" />
                        </button>
                    </div>
                    <!-- Search Suggestions -->
                    <div id="searchSuggestions"
                        class="hidden absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-h-96 overflow-y-auto">
                    </div>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-2.5 justify-center">
            @forelse($menus as $menu)
                <a href="{{ route('menu.detail', [$menu->umkm->slug, $menu->slug]) }}"
                    class="w-45 block h-75 sm:w-50 sm:max-w-55 md:w-55 md:max-w-60 lg:w-60 lg:max-w-75 xl:w-70 m-1 bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group relative">
                    <div class="h-45 xl:h-50 bg-gray-200 relative">
                        @if ($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                alt="{{ $menu->name }}">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300 text-4xl">
                                🍽️</div>
                        @endif
                        <div
                            class="w-auto h-auto absolute right-2 top-2 flex items-center gap-1 px-2 bg-gray-300/30 rounded-full overflow-hidden">
                            <x-heroicon-s-star class="w-2 h-2 text-yellow-500" />
                            <span class="text-tiny">5.0</span>
                        </div>
                    </div>
                    <div class="p-2 ml-1">
                        <h3 class="text-md font-semibold md:font-bold text-gray-900 group-hover:text-indigo-600">{{ $menu->name }}</h3>
                        <p class="mt-1 text-tiny sm:text-xs text-gray-400">{{ $menu->umkm->name }}</p>
                        <div class="absolute left-0 bottom-0 pb-2 pl-3">
                            <span class="text-sm font-bold text-indigo-600">Rp
                                {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Wah, belum ada menu yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $menus->links() }}
        </div>
    </div>
    {{-- <x-app-layout> --}}
</x-layouts.public>

<script>
    const searchInput = document.getElementById('searchInput');
    const searchSuggestions = document.getElementById('searchSuggestions');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            searchSuggestions.classList.add('hidden');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('cari.search') }}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.menus.length === 0 && data.umkms.length === 0) {
                        searchSuggestions.innerHTML =
                            '<div class="p-4 text-center text-gray-500">Tidak ada hasil ditemukan</div>';
                        searchSuggestions.classList.remove('hidden');
                        return;
                    }

                    let html = '';

                    // UMKM Section
                    if (data.umkms.length > 0) {
                        html +=
                            '<div class="border-b border-gray-100"><div class="px-4 py-2 font-semibold text-gray-700 text-sm bg-gray-50">🏪 UMKM</div>';
                        data.umkms.forEach(umkm => {
                            html += `
                            <a href="{{ url('/umkm') }}/${umkm.slug}" class="block px-4 py-3 hover:bg-indigo-50 transition border-b border-gray-100 last:border-b-0">
                                <div class="font-medium text-gray-900">${umkm.name}</div>
                                <div class="text-xs text-gray-500 line-clamp-1">${umkm.description || 'Toko UMKM'}</div>
                            </a>
                        `;
                        });
                        html += '</div>';
                    }

                    // Menu Section
                    if (data.menus.length > 0) {
                        html +=
                            '<div><div class="px-4 py-2 font-semibold text-gray-700 text-sm bg-gray-50">🍽️ Menu</div>';
                        data.menus.forEach(menu => {
                            html += `
                            <a href="{{ url('/umkm') }}/${menu.umkm.slug}/${menu.slug}" class="block px-4 py-3 hover:bg-indigo-50 transition border-b border-gray-100 last:border-b-0">
                                <div class="font-medium text-gray-900">${menu.name}</div>
                                <div class="text-xs text-gray-500">${menu.umkm.name} • Rp ${Number(menu.price).toLocaleString('id-ID')}</div>
                            </a>
                        `;
                        });
                        html += '</div>';
                    }

                    searchSuggestions.innerHTML = html;
                    searchSuggestions.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }, 300);
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('form') && !e.target.closest('#searchSuggestions')) {
            searchSuggestions.classList.add('hidden');
        }
    });

    // Show suggestions on focus if there's text
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2 && !searchSuggestions.classList.contains('hidden')) {
            searchSuggestions.classList.remove('hidden');
        }
    });
</script>
