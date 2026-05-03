<x-layouts.public>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('public.beranda') }}" class="hover:text-indigo-600 transition">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('toko.detail', $umkm->slug) }}" class="hover:text-indigo-600 transition">{{ $umkm->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-gray-800 font-medium line-clamp-1">{{ $menu->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Main Product Section -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                
                <!-- BAGIAN KIRI: Gambar Produk -->
                <div class="bg-gray-50 p-6 md:p-10 flex items-center justify-center relative md:border-r border-gray-100">
                    <span class="absolute top-6 left-6 bg-indigo-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm z-10">
                        {{ $menu->category }}
                    </span>
                    <div class="w-full aspect-square bg-gray-200 rounded-2xl flex flex-col items-center justify-center text-gray-400 shadow-inner overflow-hidden relative">
                        <svg class="w-20 h-20 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Foto Produk</span>
                    </div>
                </div>

                <!-- BAGIAN KANAN: Detail & Aksi -->
                <div class="p-6 md:p-10 flex flex-col">
                    <div class="mb-4">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $menu->name }}</h1>
                        <div class="flex items-center gap-4 text-sm">
                            <div class="flex items-center text-yellow-400">
                                <span class="text-lg mr-1">★</span>
                                <span class="font-bold text-gray-900">{{ number_format($menu->reviews->avg('rating') ?? 0, 1) }}</span>
                                <span class="text-gray-500 ml-1">({{ $menu->reviews->count() }} Ulasan)</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 pb-6 border-b border-gray-100">
                        @php
                            $prices = $menu->menuCombinations->pluck('price');
                            $minPrice = $prices->min();
                            $maxPrice = $prices->max();
                        @endphp
                        <span class="text-3xl font-extrabold text-indigo-600">
                            Rp {{ number_format($minPrice ?? 0, 0, ',', '.') }}
                            @if($minPrice !== $maxPrice)
                                <span class="text-xl text-gray-400 font-medium"> - Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                            @endif
                        </span>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-2 uppercase tracking-wider">Deskripsi Menu</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">{{ $menu->description }}</p>
                    </div>

                    @if($menu->variantCategories->count() > 0)
                        <div class="mb-8 space-y-4">
                            @foreach($menu->variantCategories as $category)
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-2">{{ $category->name }} <span class="text-xs text-gray-400 font-normal">({{ $category->is_required ? 'Wajib' : 'Opsional' }})</span></h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($category->options as $option)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="variant_{{ $category->id }}" value="{{ $option->id }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                                <div class="px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 peer-checked:border-indigo-600 hover:border-gray-300 transition">
                                                    {{ $option->name }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-auto pt-6 flex gap-3">
                        @if($umkm->is_open)
                            <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-sm transition flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Masukkan Keranjang
                            </button>
                        @else
                            <button disabled class="flex-1 bg-gray-300 text-gray-500 font-bold py-3 px-6 rounded-xl cursor-not-allowed text-center">
                                Toko Sedang Tutup
                            </button>
                        @endif
                    </div>

                    <div class="mt-8 bg-indigo-50 rounded-xl p-4 flex items-center justify-between border border-indigo-100">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-indigo-200 rounded-full flex justify-center items-center text-indigo-700 font-black text-xl shrink-0">
                                {{ strtoupper(substr($umkm->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $umkm->name }}</h4>
                                <p class="text-xs text-indigo-600 font-medium">Mitra UMKM Terverifikasi</p>
                            </div>
                        </div>
                        <a href="{{ route('toko.detail', $umkm->slug) }}" class="text-sm font-bold text-indigo-600 bg-white border border-indigo-200 px-4 py-2 rounded-lg hover:bg-indigo-600 hover:text-white transition">
                            Kunjungi Toko
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Ulasan Pembeli -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-10">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center gap-2">
                Ulasan Pembeli 
                <span class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full">{{ $menu->reviews->count() }}</span>
            </h2>

            @auth
                @php
                    $sudahMengulas = $menu->reviews->where('user_id', auth()->id())->count() > 0;
                    $isPengusahaMilikMenu = auth()->user()->role === 'pengusaha' && auth()->user()->umkm && auth()->user()->umkm->id === $menu->umkm_id;
                @endphp

                @if(!$sudahMengulas && !$isPengusahaMilikMenu)
                    <!-- FORM TAMBAH ULASAN -->
                    <div x-data="{ rating: 5, hoverRating: 0 }" class="bg-gray-50 rounded-2xl p-6 border border-gray-200 mb-8">
                        <h3 class="font-bold text-gray-900 mb-4">Berikan penilaian Anda untuk menu ini</h3>
                        <form action="{{ route('ulasan.store', ['umkm' => $umkm->slug, 'menu' => $menu->slug]) }}" method="POST">
                            @csrf
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex gap-1">
                                    <template x-for="i in 5">
                                        <button type="button" 
                                                @mouseenter="hoverRating = i" 
                                                @mouseleave="hoverRating = 0" 
                                                @click="rating = i"
                                                class="focus:outline-none transition transform hover:scale-110">
                                            <svg class="w-8 h-8 transition-colors duration-150" 
                                                 :class="(hoverRating >= i || rating >= i) ? 'text-yellow-400' : 'text-gray-300'" 
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                                <span class="text-sm font-bold text-gray-500 ml-2" x-text="
                                    rating == 5 ? 'Sangat Bagus' : 
                                    (rating == 4 ? 'Bagus' : 
                                    (rating == 3 ? 'Biasa' : 
                                    (rating == 2 ? 'Kurang' : 'Buruk')))
                                "></span>
                            </div>
                            <input type="hidden" name="rating" x-model="rating" required>
                            <textarea name="comment" rows="3" class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 mb-3 text-sm placeholder-gray-400" placeholder="Ceritakan pengalaman Anda menikmati hidangan ini..." required></textarea>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition">Kirim Ulasan</button>
                        </form>
                    </div>
                @endif
            @endauth

            @if(session('success'))
                <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                    <span class="font-bold">Sukses!</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                    <span class="font-bold">Oops!</span> {{ session('error') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse($menu->reviews as $review)
                    <div x-data="{ modeEditUlasan: false, modeEditBalasan: false, ratingEdit: {{ $review->rating }}, hoverRatingEdit: 0 }" class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm relative hover:border-gray-200 transition">
                        
                        <div class="flex gap-4">
                            <!-- Avatar -->
                            <div class="h-12 w-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex justify-center items-center shrink-0 shadow-md">
                                <span class="text-white font-extrabold text-lg">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="font-bold text-gray-900">{{ $review->user->name }}</h4>
                                    <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-md">{{ $review->updated_at->diffForHumans() }}</span>
                                </div>
                                
                                <div class="text-yellow-400 text-sm tracking-widest mb-2">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </div>

                                <div x-show="!modeEditUlasan">
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                </div>

                                @if(auth()->check() && auth()->id() === $review->user_id)
                                    <div x-show="!modeEditUlasan" class="mt-3 flex gap-3 border-t border-gray-50 pt-3">
                                        <button @click="modeEditUlasan = true" class="text-xs font-bold text-blue-600 hover:text-blue-800">Edit Ulasan</button>
                                        <form action="{{ route('ulasan.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800">Hapus</button>
                                        </form>
                                    </div>
                                    
                                    <!-- FORM EDIT ULASAN -->
                                    <form x-show="modeEditUlasan" style="display: none;" action="{{ route('ulasan.update', $review->id) }}" method="POST" class="mt-4 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                                        @csrf @method('PUT')
                                        <div class="flex items-center gap-1 mb-3">
                                            <template x-for="i in 5">
                                                <button type="button" 
                                                        @mouseenter="hoverRatingEdit = i" 
                                                        @mouseleave="hoverRatingEdit = 0" 
                                                        @click="ratingEdit = i"
                                                        class="focus:outline-none transition">
                                                    <svg class="w-6 h-6 transition-colors duration-150" 
                                                         :class="(hoverRatingEdit >= i || ratingEdit >= i) ? 'text-yellow-400' : 'text-gray-300'" 
                                                         fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            </template>
                                            <input type="hidden" name="rating" x-model="ratingEdit" required>
                                        </div>
                                        <textarea name="comment" rows="2" class="mb-3 text-sm border-gray-300 rounded-lg w-full" required>{{ $review->comment }}</textarea>
                                        <div class="flex gap-2">
                                            <button type="submit" class="bg-indigo-600 text-white px-4 py-1.5 text-xs font-bold rounded-lg hover:bg-indigo-700">Simpan</button>
                                            <button type="button" @click="modeEditUlasan = false" class="bg-white border border-gray-300 text-gray-700 px-4 py-1.5 text-xs font-bold rounded-lg hover:bg-gray-50">Batal</button>
                                        </div>
                                    </form>
                                @endif
                                
                                <div class="mt-4">
                                    @if($review->reply)
                                        <div x-show="!modeEditBalasan" class="p-4 bg-gray-50 rounded-xl border border-gray-200 relative ml-4 md:ml-8 mt-2">
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path></svg>
                                                <span class="text-xs font-bold text-gray-900 uppercase">Respon Penjual</span>
                                            </div>
                                            <p class="text-sm text-gray-700 italic">"{{ $review->reply }}"</p>
                                            
                                            <!-- REVISI PADA 2 ROUTE INI -->
                                            @if(auth()->check() && auth()->user()->role === 'pengusaha' && auth()->user()->umkm->id === $menu->umkm_id)
                                                <div class="flex gap-3 mt-3 pt-3 border-t border-gray-200">
                                                    <button @click="modeEditBalasan = true" class="text-xs font-bold text-blue-600">Edit Balasan</button>
                                                    <form action="{{ route('pengusaha.ulasan.hapus-balasan', $review->id) }}" method="POST" onsubmit="return confirm('Hapus balasan ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-xs font-bold text-red-600">Hapus</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        @if(auth()->check() && auth()->user()->role === 'pengusaha' && auth()->user()->umkm->id === $menu->umkm_id)
                                            <button x-show="!modeEditBalasan" @click="modeEditBalasan = true" class="text-xs font-bold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-lg border border-indigo-100 hover:bg-indigo-100 transition mt-2">
                                                ↪ Berikan Balasan
                                            </button>
                                        @endif
                                    @endif

                                    @if(auth()->check() && auth()->user()->role === 'pengusaha' && auth()->user()->umkm->id === $menu->umkm_id)
                                        <form x-show="modeEditBalasan" style="display: none;" action="{{ route('pengusaha.ulasan.balas', $review->id) }}" method="POST" class="mt-3 bg-gray-50 p-4 rounded-xl border border-gray-200 ml-4 md:ml-8">
                                            @csrf
                                            <label class="block text-xs font-bold text-gray-700 mb-2">Respon Anda:</label>
                                            <textarea name="reply" rows="2" class="text-sm border-gray-300 rounded-lg w-full mb-3" required>{{ $review->reply }}</textarea>
                                            <div class="flex gap-2">
                                                <button type="submit" class="bg-indigo-600 text-white px-4 py-1.5 text-xs font-bold rounded-lg hover:bg-indigo-700">Simpan Balasan</button>
                                                <button type="button" @click="modeEditBalasan = false" class="bg-white border border-gray-300 text-gray-700 px-4 py-1.5 text-xs font-bold rounded-lg hover:bg-gray-50">Batal</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <h3 class="text-sm font-bold text-gray-900">Belum ada ulasan</h3>
                        <p class="text-xs text-gray-500 mt-1">Jadilah yang pertama mencoba dan memberikan ulasan!</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts.public>