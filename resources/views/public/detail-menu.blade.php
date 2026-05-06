<x-layouts.public>
    {{-- <x-app-layout> --}}
    <div class="h-90 max-w-4xl mx-auto sm:px-6 md:rounded-b-2xl relative">
        @if ($menu->image)
            <img src="{{ asset('storage/' . $menu->image) }}"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                alt="{{ $menu->name }}">
        @else
            <div class="w-full h-full flex items-center justify-center bg-pink-50 text-indigo-300 text-4xl">
                🍽️</div>
        @endif
        <div class="w-auto h-auto absolute left-2 md:left-6 bottom-0 -mb-3 flex items-center gap-1 px-2 overflow-hidden">
            <span
                class="inline-block bg-indigo-900 text-gray-100 text-xs px-3 py-1 rounded-full font-semibold border border-indigo-100">{{ $menu->category }}</span>
        </div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative shadow-sm"
                role="alert">
                <span class="block sm:inline font-medium">✅ {{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative shadow-sm"
                role="alert">
                <span class="block sm:inline font-medium">⚠️ {{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-5 relative">
                <h1 class="text-xl font-bold text-gray-900">{{ $menu->name }}</h1>
                <p class="mt-1 mb-8 text-lg font-bold text-indigo-950">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </p>


                <div
                    class="w-auto h-6 absolute left-2 ml-3 bottom-4 flex items-center gap-1 px-2 bg-yellow-100/40 rounded-lg overflow-hidden">
                    <x-heroicon-s-star class="w-4 h-4 text-yellow-500" />
                    <span class="text-xs text-yellow-600">3.0</span>
                    <span class="text-xs">({{ $menu->reviews->count() }} ulasan)</span>
                </div>
            </div>
        </div>

        {{-- Kartu UMKM --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 my-4">
            <div class="flex items-center gap-3">
                {{-- Avatar menggunakan image_banner UMKM --}}
                <div class="h-12 w-12 rounded-full overflow-hidden bg-indigo-100 shrink-0">
                    @if ($umkm->image_banner)
                        <img src="{{ asset('storage/' . $umkm->image_banner) }}" alt="{{ $umkm->name }}"
                            class="w-full h-full object-cover">
                    @else
                        {{-- Fallback: tampilkan inisial jika tidak ada gambar --}}
                        <div class="w-full h-full flex items-center justify-center bg-indigo-100">
                            <span
                                class="text-indigo-700 font-bold text-sm">{{ strtoupper(substr($umkm->name, 0, 2)) }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <a href="{{ route('umkm.detail', $umkm->slug) }}"
                        class="text-md font-bold text-gray-900 hover:text-indigo-600 transition">
                        {{ $umkm->name }}
                    </a>
                    {{-- Status Buka / Tutup --}}
                    <div class="flex items-center">
                        @if ($umkm->latitude && $umkm->longitude)
                            <a href="https://www.google.com/maps?q={{ $umkm->latitude }},{{ $umkm->longitude }}"
                                target="_blank"
                                class="shrink-0 inline-flex gap-1.5 px-3 py-1.5 text-xs transition-all active:scale-95 cursorpointer"
                                title="Cek Lokasi di Google Maps">
                                <x-heroicon-o-map-pin class="w-4 h-4 text-gray-900" />

                                Lokasi
                            </a>
                        @endif
                        <span class="text-xs font-medium {{ $umkm->is_open ? 'text-green-600' : 'text-red-600' }}">
                            {{ $umkm->is_open ? '● Buka' : '● Tutup' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border-gray-100 p-5">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Detail Menu</h3>
            <p class="mb-4 text-gray-600 leading-relaxed text-sm">{{ $menu->description }}</p>

            {{-- Ukuran --}}
            <div class="mb-4">
                <span class="text-sm font-bold text-gray-900 block mb-1">Ukuran:</span>
                <div class="inline-block bg-gray-200 rounded-xl px-3 py-1 shadow-sm">
                    <span class="text-sm text-gray-900">{{ $menu->ukuran ?: '-' }}</span>
                </div>
            </div>

            {{-- Varian --}}
            <div>
                <span class="text-sm font-bold text-gray-900 block mb-1">Varian:</span>
                <div class="inline-block bg-gray-200 rounded-xl px-3 py-1 shadow-sm">
                    <span class="text-sm text-gray-900">{{ $menu->variant ?: '-' }}</span>
                </div>
            </div>
        </div>


        <div x-data="{ showUlasanForm: false }" class="mt-4 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            @php
                $averageRating = $menu->reviews->count() > 0 ? round($menu->reviews->avg('rating'), 1) : 0;
                $ratingCount = $menu->reviews->count();
            @endphp

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-md md:text-lg font-bold text-gray-900 flex items-center gap-2">
                    Ulasan Pelanggan
                </h2>

                @auth
                    @php
                        $user = auth()->user();
                        $hasReviewed = $menu->reviews()->where('user_id', $user->id)->exists();
                        $canReview = ($user->role === 'user' || $user->role === 'pengusaha') && !$hasReviewed;
                    @endphp

                    @if ($canReview)
                        <button @click="showUlasanForm = !showUlasanForm"
                            class="inline-flex items-center gap-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-medium px-4 py-2 rounded-full transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Tulis Ulasan
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-full transition">
                        Masuk untuk tulis ulasan
                    </a>
                @endauth
            </div>

            {{-- FORM ULASAN dipindahkan ke sini (setelah div flex) --}}
            @auth
                @if (isset($canReview) && $canReview)
                    <div x-show="showUlasanForm" x-cloak class="mb-6 transition-all duration-300">
                        <form action="{{ route('ulasan.store', ['umkm' => $umkm->slug, 'menu' => $menu->slug]) }}"
                            method="POST" class="p-6 bg-gray-50 rounded-xl border border-gray-200">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Beri Rating</label>
                                <select name="rating"
                                    class="px-2 py-2 border-gray-300 rounded-lg shadow-sm w-full sm:w-60 focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                                    <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                    <option value="4">⭐⭐⭐⭐ Baik</option>
                                    <option value="3">⭐⭐⭐ Cukup</option>
                                    <option value="2">⭐⭐ Kurang</option>
                                    <option value="1">⭐ Sangat Kurang</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Ceritakan Pengalaman
                                    Anda</label>
                                <textarea name="comment" rows="3"
                                    class="p-3 text-xs sm:text-sm border-gray-300 rounded-lg shadow-sm w-full focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Rasa, porsi, pelayanan..." required></textarea>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="bg-prim1 text-sm md:text-md text-white px-6 py-2 rounded-lg font-medium hover:bg-prim2">Kirim
                                    Ulasan</button>
                                <button type="button" @click="showUlasanForm = false"
                                    class="text-sm md:text-md bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300">Batal</button>
                            </div>
                        </form>
                    </div>
                @endif
            @endauth
            <div class="space-y-6">
                @forelse($menu->reviews as $review)
                    <div x-data="{ modeEditUlasan: false, modeEditBalasan: false }"
                        class="p-4 bg-white hover:bg-gray-50 rounded-xl transition border border-gray-100 shadow-sm mb-4">

                        <div class="flex gap-3">
                            <!-- Avatar -->
                            <div class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center shrink-0">
                                <span
                                    class="text-indigo-700 font-bold text-sm">{{ strtoupper(substr($review->user->name, 0, 2)) }}</span>
                            </div>

                            <div class="flex-1">
                                <!-- Nama & waktu -->
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900">{{ $review->user->name }}</h4>
                                        <p class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}
                                        </p>
                                        <!-- Rating bintang di bawah nama & waktu -->
                                        <div class="text-yellow-400 text-xs mt-1 tracking-wide">
                                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Komentar -->
                                <div x-show="!modeEditUlasan" class="mt-2">
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                </div>

                                <!-- Form edit ulasan -->
                                @if (auth()->check() && auth()->id() === $review->user_id)
                                    <form x-show="modeEditUlasan" style="display: none;"
                                        action="{{ route('ulasan.update', $review->id) }}" method="POST"
                                        class="mt-3 bg-indigo-50 p-3 rounded-lg">
                                        @csrf @method('PUT')
                                        <select name="rating"
                                            class="mb-2 text-sm border-gray-300 rounded-lg w-full sm:w-48" required>
                                            <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐
                                            </option>
                                            <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐
                                            </option>
                                            <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>⭐⭐⭐
                                            </option>
                                            <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>⭐⭐
                                            </option>
                                            <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>⭐
                                            </option>
                                        </select>
                                        <textarea name="comment" rows="2" class="w-full text-sm border-gray-300 rounded-lg" required>{{ $review->comment }}</textarea>
                                        <div class="flex gap-2 mt-2">
                                            <button type="submit"
                                                class="bg-indigo-600 text-white px-3 py-1 text-xs rounded">Simpan</button>
                                            <button type="button" @click="modeEditUlasan = false"
                                                class="bg-gray-300 px-3 py-1 text-xs rounded">Batal</button>
                                        </div>
                                    </form>

                                    <!-- Tombol Edit/Hapus di bawah komentar -->
                                    <div class="flex gap-3 mt-2 text-xs" x-show="!modeEditUlasan">
                                        <button @click="modeEditUlasan = true"
                                            class="text-blue-500 hover:underline">Edit</button>
                                        <form action="{{ route('ulasan.destroy', $review->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus ulasan ini?');"
                                            class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                @endif

                                <!-- Balasan dari pemilik usaha -->
                                <div class="mt-3">
                                    @if ($review->reply)
                                        <div x-show="!modeEditBalasan"
                                            class="p-3 bg-gray-50 rounded-lg border-l-4 border-indigo-400 text-sm">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-xs font-semibold text-indigo-800">Balasan dari
                                                    {{ $umkm->name }}</span>
                                                @if (auth()->check() && auth()->user()->role === 'pengusaha' && auth()->user()->umkm->id === $menu->umkm_id)
                                                    <div class="flex gap-2">
                                                        <button @click="modeEditBalasan = true"
                                                            class="text-xs text-blue-600 hover:underline">Edit</button>
                                                        <form
                                                            action="{{ route('pengusaha.ulasan.hapus-balasan', $review->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus balasan ini?');"
                                                            class="inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                class="text-xs text-red-600 hover:underline">Hapus</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="text-gray-700 italic">“{{ $review->reply }}”</p>
                                        </div>
                                    @else
                                        @if (auth()->check() && auth()->user()->role === 'pengusaha' && auth()->user()->umkm->id === $menu->umkm_id)
                                            <button x-show="!modeEditBalasan" @click="modeEditBalasan = true"
                                                class="text-xs font-medium text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-200">
                                                ↪ Balas Ulasan
                                            </button>
                                        @endif
                                    @endif

                                    <!-- Form balasan -->
                                    @if (auth()->check() && auth()->user()->role === 'pengusaha' && auth()->user()->umkm->id === $menu->umkm_id)
                                        <form x-show="modeEditBalasan" style="display: none;"
                                            action="{{ route('pengusaha.ulasan.balas', $review->id) }}"
                                            method="POST" class="mt-2 bg-gray-100 p-3 rounded-lg">
                                            @csrf
                                            <textarea name="reply" rows="2" class="w-full text-sm border-gray-300 rounded-lg"
                                                placeholder="Tulis balasan...">{{ $review->reply }}</textarea>
                                            <div class="flex gap-2 mt-2">
                                                <button type="submit"
                                                    class="bg-indigo-600 text-white px-3 py-1 text-xs rounded">Kirim</button>
                                                <button type="button" @click="modeEditBalasan = false"
                                                    class="bg-gray-300 px-3 py-1 text-xs rounded">Batal</button>
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
