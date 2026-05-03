<x-layouts.public>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Jelajahi Menu Pilihan</h1>
            <p class="mt-2 text-sm text-gray-600">Temukan makanan dan minuman terbaik dari berbagai toko di sekitar Anda.</p>
        </div>

        <!-- Grid Menu -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($menus as $menu)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300 flex flex-col relative {{ !$menu->umkm->is_open ? 'opacity-75 grayscale-[30%]' : '' }}">
                    
                    <!-- Kategori Badge -->
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-indigo-600 shadow-sm z-10">
                        {{ $menu->category }}
                    </div>

                    <!-- Badge Toko Tutup (Hanya Muncul Jika is_open = false) -->
                    @if(!$menu->umkm->is_open)
                        <div class="absolute top-3 left-3 bg-red-600/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm z-10">
                            Toko Tutup
                        </div>
                    @endif

                    <!-- Placeholder Gambar Menu -->
                    <div class="h-48 bg-gray-200 flex items-center justify-center shrink-0 relative">
                        <span class="text-gray-400 font-medium">Gambar Menu</span>
                        
                        <!-- Overlay Hitam Transparan jika toko tutup -->
                        @if(!$menu->umkm->is_open)
                            <div class="absolute inset-0 bg-black/10"></div>
                        @endif
                    </div>

                    <!-- Detail Menu -->
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex-1">
                            <!-- Link ke Detail Menu -->
                            <a href="{{ url('toko/' . $menu->umkm->slug . '/' . $menu->slug) }}" class="block">
                                <h3 class="font-bold text-gray-900 text-lg mb-1 hover:text-indigo-600 transition line-clamp-1" title="{{ $menu->name }}">
                                    {{ $menu->name }}
                                </h3>
                            </a>
                            
                            <!-- Nama Toko -->
                            <a href="{{ route('toko.detail', $menu->umkm->slug) }}" class="text-sm text-gray-500 hover:text-indigo-600 flex items-center gap-1 mb-3 line-clamp-1">
                                🏬 {{ $menu->umkm->name }}
                            </a>

                            <!-- Deskripsi Singkat -->
                            <p class="text-xs text-gray-600 line-clamp-2 mb-4">
                                {{ $menu->description }}
                            </p>
                        </div>

                        <!-- Footer Card (Harga & Rating) -->
                        <div class="flex justify-between items-end mt-auto pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Mulai dari</p>
                                <p class="font-bold text-gray-900">
                                    @php
                                        $hargaTermurah = $menu->menuCombinations->min('price');
                                    @endphp
                                    Rp {{ number_format($hargaTermurah ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <!-- Rating Bintang -->
                            <div class="flex items-center gap-1 bg-yellow-50 px-2 py-1 rounded-lg">
                                <span class="text-yellow-400 text-sm">★</span>
                                <span class="text-xs font-bold text-yellow-700">
                                    {{ number_format($menu->reviews->avg('rating') ?? 0, 1) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                    <span class="text-4xl mb-3">🍽️</span>
                    <h3 class="text-lg font-bold text-gray-900">Belum Ada Menu</h3>
                    <p class="text-sm text-gray-500 mt-1">Saat ini belum ada menu yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($menus->hasPages())
            <div class="mt-10">
                {{ $menus->links() }}
            </div>
        @endif
        
    </div>
</x-layouts.public>