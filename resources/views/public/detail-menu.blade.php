<x-layouts.public>
    {{-- <x-app-layout> --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        
        <a href="{{ route('toko.detail', $umkm->slug) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium inline-flex items-center mb-6 transition">
            &larr; Kembali ke {{ $umkm->name }}
        </a>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative shadow-sm" role="alert">
                <span class="block sm:inline font-medium">✅ {{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative shadow-sm" role="alert">
                <span class="block sm:inline font-medium">⚠️ {{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-8 border-b border-gray-100">
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $menu->name }}</h1>
                <p class="mt-3 text-gray-600 leading-relaxed">{{ $menu->description }}</p>
                <div class="mt-4">
                    <span class="inline-block bg-indigo-50 text-indigo-700 text-xs px-3 py-1 rounded-full font-semibold border border-indigo-100">{{ $menu->category }}</span>
                </div>
            </div>

            <div class="p-8 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Detail Menu</h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Ukuran</p>
                        <p class="mt-1 text-sm font-bold text-gray-900">
                            {{ $menu->ukuran ?: '-' }}
                        </p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Varian</p>
                        <p class="mt-1 text-sm font-bold text-gray-900">
                            {{ $menu->variant ?: '-' }}
                        </p>
                    </div>
                    <div class="bg-white rounded-xl border border-indigo-100 p-4 shadow-sm">
                        <p class="text-xs font-semibold text-indigo-700 uppercase tracking-wider">Harga</p>
                        <p class="mt-1 text-xl font-extrabold text-indigo-600">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                @if($menu->image)
                    <div class="mt-6">
                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full max-h-80 object-cover rounded-xl border border-gray-200 shadow-sm" />
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                Ulasan Pelanggan 
                <span class="text-sm font-normal text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $menu->reviews->count() }}</span>
            </h2>

            @auth
                @if(auth()->user()->role === 'user' || auth()->user()->role === 'pengusaha')
                    @php
                        // Cek apakah user yang login sudah pernah mereview menu ini
                        $sudahReview = $menu->reviews->contains('user_id', auth()->user()->id);
                    @endphp

                    @if($sudahReview)
                        <div class="mb-8 p-5 bg-green-50 rounded-xl border border-green-200 text-center">
                            <p class="text-green-700 font-medium">Terima kasih! Anda sudah memberikan ulasan untuk menu ini.</p>
                        </div>
                    @else
                        <form action="{{ route('ulasan.store', ['umkm' => $umkm->slug, 'menu' => $menu->slug]) }}" method="POST" class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Beri Rating</label>
                                <select name="rating" class="border-gray-300 rounded-lg shadow-sm w-full sm:w-48 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                    <option value="4">⭐⭐⭐⭐ Baik</option>
                                    <option value="3">⭐⭐⭐ Cukup</option>
                                    <option value="2">⭐⭐ Kurang</option>
                                    <option value="1">⭐ Sangat Kurang</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tulis Pengalaman Anda</label>
                                <textarea name="comment" rows="3" class="border-gray-300 rounded-lg shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500" placeholder="Bagaimana rasa, porsi, atau penyajiannya?" required></textarea>
                            </div>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition shadow-sm">Kirim Ulasan</button>
                        </form>
                    @endif
                @endif
            @else
                <div class="bg-indigo-50 rounded-xl p-5 mb-8 text-sm text-indigo-800 text-center border border-indigo-100">
                    Pernah mencoba menu ini? <a href="{{ route('login') }}" class="font-bold underline hover:text-indigo-900">Masuk</a> atau <a href="{{ route('register') }}" class="font-bold underline hover:text-indigo-900">Daftar</a> untuk membagikan pengalaman Anda.
                </div>
            @endauth

            <div class="space-y-6">
                @forelse($menu->reviews as $review)
                    <div x-data="{ modeEditUlasan: false, modeEditBalasan: false }" class="p-4 bg-white hover:bg-gray-50 rounded-xl transition border border-gray-100 shadow-sm relative">
                        
                        <div class="flex gap-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-full flex justify-center items-center shrink-0 border border-indigo-100">
                                <span class="text-indigo-700 font-extrabold text-lg">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center gap-3">
                                        <h4 class="text-sm font-bold text-gray-900">{{ $review->user->name }}</h4>
                                        <span class="text-xs text-gray-400">{{ $review->updated_at->diffForHumans() }}</span>
                                    </div>

                                    @if(auth()->check() && auth()->id() === $review->user_id)
                                        <div class="flex gap-2">
                                            <button @click="modeEditUlasan = !modeEditUlasan" class="text-xs text-blue-500 hover:underline">Edit</button>
                                            <form action="{{ route('ulasan.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                <div x-show="!modeEditUlasan">
                                    <div class="text-yellow-400 text-sm mt-1 tracking-widest">
                                        {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                    </div>
                                    <p class="mt-2 text-sm text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                </div>

                                @if(auth()->check() && auth()->id() === $review->user_id)
                                    <form x-show="modeEditUlasan" style="display: none;" action="{{ route('ulasan.update', $review->id) }}" method="POST" class="mt-3 bg-indigo-50 p-4 rounded-lg">
                                        @csrf @method('PUT')
                                        <select name="rating" class="mb-2 text-sm border-gray-300 rounded-lg w-full sm:w-48" required>
                                            <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐</option>
                                            <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐</option>
                                            <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>⭐⭐⭐</option>
                                            <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>⭐⭐</option>
                                            <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>⭐</option>
                                        </select>
                                        <textarea name="comment" rows="2" class="mb-2 text-sm border-gray-300 rounded-lg w-full" required>{{ $review->comment }}</textarea>
                                        <div class="flex gap-2">
                                            <button type="submit" class="bg-indigo-600 text-white px-3 py-1 text-xs rounded hover:bg-indigo-700">Simpan Perubahan</button>
                                            <button type="button" @click="modeEditUlasan = false" class="bg-gray-300 text-gray-700 px-3 py-1 text-xs rounded hover:bg-gray-400">Batal</button>
                                        </div>
                                    </form>
                                @endif
                                
                                <div class="mt-4">
                                    @if($review->reply)
                                        <div x-show="!modeEditBalasan" class="p-4 bg-indigo-50 rounded-lg border-l-4 border-indigo-500 relative">
                                            <div class="flex justify-between items-center mb-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-bold text-indigo-800 uppercase tracking-wider">Balasan dari {{ $umkm->name }}</span>
                                                </div>
                                                
                                                @if(auth()->check() && auth()->user()->role === 'pengusaha' && auth()->user()->umkm->id === $menu->umkm_id)
                                                    <div class="flex gap-2">
                                                        <button @click="modeEditBalasan = true" class="text-xs text-blue-600 hover:underline">Edit Balasan</button>
                                                        <form action="{{ route('mitra.ulasan.hapus-balasan', $review->id) }}" method="POST" onsubmit="return confirm('Hapus balasan ini?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-xs text-red-600 hover:underline">Hapus</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-800 italic">"{{ $review->reply }}"</p>
                                        </div>
                                    @else
                                        @if(auth()->check() && auth()->user()->role === 'pengusaha' && auth()->user()->umkm->id === $menu->umkm_id)
                                            <button x-show="!modeEditBalasan" @click="modeEditBalasan = true" class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-200 hover:bg-indigo-100">
                                                ↪ Balas Ulasan Ini
                                            </button>
                                        @endif
                                    @endif

                                    @if(auth()->check() && auth()->user()->role === 'pengusaha' && auth()->user()->umkm->id === $menu->umkm_id)
                                        <form x-show="modeEditBalasan" style="display: none;" action="{{ route('mitra.ulasan.balas', $review->id) }}" method="POST" class="mt-2 bg-gray-100 p-4 rounded-lg border border-gray-200">
                                            @csrf
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Tulis Balasan Anda:</label>
                                            <textarea name="reply" rows="2" class="text-sm border-gray-300 rounded-lg w-full mb-2" required>{{ $review->reply }}</textarea>
                                            <div class="flex gap-2">
                                                <button type="submit" class="bg-indigo-600 text-white px-3 py-1 text-xs rounded hover:bg-indigo-700">Kirim Balasan</button>
                                                <button type="button" @click="modeEditBalasan = false" class="bg-gray-300 text-gray-700 px-3 py-1 text-xs rounded hover:bg-gray-400">Batal</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                                </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-sm">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</x-layouts.public>
{{-- </x-app-layout> --}}
