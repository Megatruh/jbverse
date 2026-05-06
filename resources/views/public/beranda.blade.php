<x-layouts.public>
    {{-- <x-app-layout> --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 relative">
        <div class="-mx-4 sm:-mx-6 lg:-mx-8 xl:-mx-23 bg-header rounded-b-2xl sticky top-16 pb-8 z-10 shadow-sm">
            <h1 class="ml-4 py-4 text-xl font-bold text-gray-100 md:text-2xl lg:text-3xl xl:ml-6">Pilih Jajanan
                Favoritmu Hari Ini!</h1>
            <div class="max-w-4xl mx-auto px-4">
                <div class="block bg-gray-100 text-gray-800 relative rounded-lg">
                    <input type="text" placeholder="Cari makanan atau minuman..."
                        class="w-full px-3 py-3 border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:outline-none rounded-lg">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <x-heroicon-o-magnifying-glass class="w-4 h-4 lg:w-5 lg:h-5 text-indigo-900 stroke-3 stroke-indigo-900" />
                    </div>
                </div>
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
