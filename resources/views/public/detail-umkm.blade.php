<x-layouts.public>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8 md:flex relative">
            <div class="md:w-1/3 h-48 md:h-auto bg-gray-200">
                @if($umkm->image_banner)
                    <img src="{{ asset('storage/' . $umkm->image_banner) }}" class="w-full h-full object-cover" alt="{{ $umkm->name }}">
                @else
                    <div class="w-full h-full flex justify-center items-center text-4xl bg-indigo-100">🏪</div>
                @endif
            </div>
            <div class="p-8 md:w-2/3">
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $umkm->name }}</h1>
                <p class="mt-4 text-gray-600">{{ $umkm->description }}</p>
                <div class="mt-6 flex items-center gap-6 text-sm font-medium text-gray-500">
                    <span>📞 {{ $umkm->contact_number }}</span>
                    <span class="text-yellow-500 flex items-center">⭐ {{ number_format($umkm->average_rating, 1) }}</span>
                </div>
                
                @auth
                    @if(auth()->user()->role === 'user')
                        <div x-data="{ open: false }" class="mt-6 pt-4 border-t border-gray-100">
                            <button @click="open = !open" class="text-sm text-red-500 hover:text-red-700 font-medium">Ada masalah dengan toko ini? Lapor Admin</button>
                            
                            <form x-show="open" action="{{ route('lapor.store', $umkm->slug) }}" method="POST" class="mt-3 flex gap-2" style="display: none;">
                                @csrf
                                <input type="text" name="reason" placeholder="Contoh: Toko palsu, atau penipuan..." class="text-sm rounded-lg border-gray-300 w-full focus:ring-red-500 focus:border-red-500" required>
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition">Kirim</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilihan Menu</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($menus as $menu)
                <a href="{{ route('menu.detail', ['umkm' => $umkm->slug, 'menu' => $menu->slug]) }}" class="flex bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md hover:border-indigo-200 transition p-4 group">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600">{{ $menu->name }}</h3>
                        <span class="inline-block bg-indigo-50 text-indigo-700 text-xs px-2.5 py-1 rounded-full mt-2 font-medium">{{ $menu->category }}</span>
                        <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $menu->description }}</p>
                    </div>
                    <div class="ml-4 shrink-0 w-24 h-24 bg-gray-50 border border-gray-100 rounded-lg overflow-hidden flex items-center justify-center text-2xl">
                        🍽️
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white p-8 rounded-xl text-center border border-gray-100 shadow-sm">
                    <p class="text-gray-500 text-lg">Toko ini belum menambahkan menu.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.public>