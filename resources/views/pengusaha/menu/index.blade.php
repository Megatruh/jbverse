<x-layouts.public>
    <div class="min-h-screen bg-white">
        <!-- Header -->
        <div class="sticky top-0 z-20 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between px-4 py-4">
                <h1 class="text-lg font-bold text-gray-900">Dashboard Usaha</h1>
                <button class="p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0018 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
            </div>

            <!-- Tabs -->
            <div class="flex border-b border-gray-200">
                <a href="{{ route('pengusaha.dashboard') }}"
                    class="flex-1 px-4 py-3 text-center font-medium text-gray-600 border-b-2 border-transparent hover:text-gray-900">
                    Dashboard
                </a>
                <a href="{{ route('pengusaha.menu.index') }}"
                    class="flex-1 px-4 py-3 text-center font-medium text-gray-900 border-b-2 border-indigo-600">
                    Menu
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 py-4 pb-24">
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Total Menu -->
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-900">Total: {{ count($menus) }} Menu</h2>
            </div>

            <!-- Menu List -->
            <div class="space-y-3">
                @forelse ($menus as $item)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <a href="{{ route('menu.detail', [$item->umkm->slug, $item->slug]) }}">
                        <div class="flex items-start gap-3">
                            <!-- Image -->
                            <div class="shrink-0">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                        class="h-20 w-20 rounded-lg object-cover border border-gray-200">
                                @else
                                    <div
                                        class="h-20 w-20 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900">{{ $item->name }}</h3>
                                <p class="text-sm font-bold text-gray-900 mt-1">Rp
                                    {{ number_format($item->price, 0, ',', '.') }}</p>

                                <!-- Actions -->
                                <div class="flex gap-2 mt-3">
                                    <a href="{{ route('pengusaha.menu.edit', $item) }}"
                                        class="flex-1 text-center bg-white border border-gray-300 text-gray-900 font-medium py-2 rounded hover:bg-gray-50 transition text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('pengusaha.menu.destroy', $item) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus menu ini?')"
                                            class="w-full bg-red-50 text-red-600 font-medium py-2 rounded hover:bg-red-100 transition text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <p class="text-sm text-gray-600">Anda belum menambahkan menu apa pun.</p>
                        <p class="text-xs text-gray-500 mt-1">Mulai tambahkan menu agar pelanggan bisa melihat produk
                            Anda!</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($menus->hasPages())
                <div class="mt-6">
                    {{ $menus->links() }}
                </div>
            @endif
        </div>

        <!-- FAB Button -->
        <a href="{{ route('pengusaha.menu.create') }}"
            class="fixed bottom-1 right-4 w-16 h-16 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-full flex items-center justify-center shadow-lg transition">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    </div>
</x-layouts.public>
