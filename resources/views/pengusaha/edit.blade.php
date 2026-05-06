<x-layouts.public>
    <div class="min-h-screen bg-white">
        <!-- Header -->
        <div class="sticky top-0 z-20 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between px-4 py-4">
                <h1 class="text-lg font-bold text-gray-900">Edit Profil UMKM</h1>
                <button class="p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0018 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
            </div>

            <!-- Tabs -->
            {{-- <div class="flex border-b border-gray-200">
                <a href="{{ route('pengusaha.dashboard') }}"
                    class="flex-1 px-4 py-3 text-center font-medium text-gray-600 border-b-2 border-transparent hover:text-gray-900">
                    Dashboard
                </a>
                <a href="{{ route('pengusaha.menu.index') }}"
                    class="flex-1 px-4 py-3 text-center font-medium text-gray-600 border-b-2 border-transparent hover:text-gray-900">
                    Menu
                </a>
            </div> --}}
        </div>

        <!-- Content -->
        <form method="POST" action="{{ route('pengusaha.update') }}" enctype="multipart/form-data"
            class="px-4 py-6 pb-24 space-y-4">
            @csrf
            @method('PATCH')

            <!-- Nama Toko -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Nama Toko
                    <span class="text-red-600">*</span>
                </label>
                <input type="text" id="name" name="name" placeholder="Masukan nama toko"
                    value="{{ old('name', $umkm->name) }}"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white"
                    required />
            </div>

            <!-- Deskripsi Toko -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Deskripsi Toko
                    <span class="text-red-600">*</span>
                </label>
                <textarea id="description" name="description" placeholder="Masukan deskripsi toko" rows="4"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white"
                    required>{{ old('description', $umkm->description) }}</textarea>
            </div>

            <!-- Nomor WhatsApp -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Nomor WhatsApp
                    <span class="text-red-600">*</span>
                </label>
                <input type="text" id="contact_number" name="contact_number" placeholder="Masukan nomor WhatsApp"
                    value="{{ old('contact_number', $umkm->contact_number) }}"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white"
                    required />
            </div>

            <!-- Update Logo Toko -->
            {{-- <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-3">Update Logo Toko</label>
                <label for="logo"
                    class="flex flex-col items-center justify-center w-full h-40 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-gray-600 font-medium">Tap untuk upload foto</p>
                        <p class="text-xs text-gray-400 mt-1">Format JPG, PNG, (Maks 2MB)</p>
                    </div>
                    <input id="logo" name="logo" type="file" class="hidden" accept="image/*" />
                </label>
            </div> --}}

            <!-- Update Banner Toko -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-3">Update Banner Toko</label>
                <label for="image_banner"
                    class="flex flex-col items-center justify-center w-full h-40 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-gray-600 font-medium">Tap untuk upload foto</p>
                        <p class="text-xs text-gray-400 mt-1">Format JPG, PNG, (Maks 2MB)</p>
                    </div>
                    <input id="image_banner" name="image_banner" type="file" class="hidden" accept="image/*" />
                </label>
            </div>

            <!-- Buttons Bottom -->
            <div class="grid grid-cols-2 gap-3 mt-6 mb-6">
                <a href="{{ route('pengusaha.dashboard') }}"
                    class="text-center bg-gray-900 hover:bg-gray-800 text-white font-medium py-3 rounded-lg transition">
                    Batal
                </a>
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-medium py-3 rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-layouts.public>
