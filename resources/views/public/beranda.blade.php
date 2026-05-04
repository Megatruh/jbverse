<x-layouts.public>
    {{-- <x-app-layout> --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">Eksplorasi Menu di JBVerse</h1>
            <p class="mt-4 text-xl text-gray-500">Temukan berbagai menu lezat dari UMKM favorit yang sedang buka saat
                ini.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($menus as $menu)
                <a href="{{ route('menu.detail', [$menu->umkm->slug, $menu->slug]) }}"
                    class="block bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group">
                    <div class="h-48 bg-gray-200">
                        @if ($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                alt="{{ $menu->name }}">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300 text-4xl">
                                🍽️</div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">{{ $menu->name }}</h3>
                        <p class="mt-1 text-xs text-gray-400">dari {{ $menu->umkm->name }}</p>
                        <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $menu->description }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm font-bold text-indigo-600">Rp
                                {{ number_format($menu->price, 0, ',', '.') }}</span>
                            <span class="text-sm font-medium text-indigo-600 group-hover:underline">Lihat Detail
                                &rarr;</span>
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
