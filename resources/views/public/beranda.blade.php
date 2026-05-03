<x-layouts.public>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">Eksplorasi Rasa di JBVerse</h1>
            <p class="mt-4 text-xl text-gray-500">Temukan gerai UMKM favorit di sekitar Anda yang sedang buka saat ini.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($umkms as $toko)
                <a href="{{ route('toko.detail', $toko->slug) }}" class="block bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group">
                    <div class="h-48 bg-gray-200">
                        @if($toko->image_banner)
                            <img src="{{ asset('storage/' . $toko->image_banner) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="{{ $toko->name }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300 text-4xl">🏪</div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">{{ $toko->name }}</h3>
                        <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $toko->description }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xs font-semibold text-green-700 bg-green-100 px-2 py-1 rounded-full">Buka</span>
                            <span class="text-sm font-medium text-indigo-600 group-hover:underline">Lihat Menu &rarr;</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Wah, belum ada UMKM yang buka saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $umkms->links() }}
        </div>
    </div>
</x-layouts.public>