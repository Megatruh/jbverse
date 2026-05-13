<x-layouts.public>
    <x-slot name="navbarLogo">
        <div class="flex items-center h-full">
        <a href="{{ route('pengusaha.menu.index') }}"
            class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-white/20 transition mr-2"
            title="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
                {{-- <p class="text-[10px] text-indigo-300 font-medium uppercase tracking-widest leading-none">Pengusaha</p> --}}
                <p class="text-base font-bold text-white leading-tight">Tambah Menu</p>
            </div>
        </div>
    </x-slot>
    <div class="min-h-screen bg-white">

        <!-- Content -->
        <form action="{{ route('pengusaha.menu.store') }}" method="POST" enctype="multipart/form-data"
            class="px-4 py-6 pb-32 space-y-6">
            @csrf

            <!-- Foto Menu -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-base font-semibold text-gray-900 mb-3">Foto Menu</label>

                <!-- Upload Area (shown when no image) -->
                <label for="image" id="upload-area-image"
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
                    <input id="image" name="image" type="file" class="hidden" accept="image/*"
                        onchange="previewImage(this, 'preview-image', 'upload-area-image')" />
                </label>

                <!-- Image Preview (hidden initially) -->
                <div id="preview-image" class="hidden relative w-full">
                    <img id="preview-image-img" src="" alt="Preview Foto Menu"
                        class="w-full h-48 object-cover rounded-lg border border-gray-200" />
                    <button type="button"
                        onclick="removeImage('image', 'preview-image', 'upload-area-image')"
                        class="absolute top-2 left-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-md transition"
                        title="Hapus gambar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Nama Menu -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Nama Menu
                    <span class="text-red-600">*</span>
                </label>
                <input type="text" id="name" name="name" placeholder="Masukan nama menu"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white"
                    required />
            </div>

            <!-- Harga Menu -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Harga Menu
                    <span class="text-red-600">*</span>
                </label>
                <input type="number" id="price" name="price" placeholder="0"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white"
                    min="0" required />
            </div>

            <!-- Kategori -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Kategori</label>
                <select id="category" name="category"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white appearance-none"
                    required>
                    <option value="">Pilih kategori</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Jajanan">Jajanan</option>
                    <option value="Dessert">Dessert</option>
                </select>
            </div>

            <!-- Deskripsi Menu -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi Menu</label>
                <textarea id="description" name="description" placeholder="Jelaskan detail menu kamu..." rows="4"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white resize-none"></textarea>
            </div>

            <!-- Tambahkan Varian -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-1">Tambahkan Varian (Opsional)</h3>
                <p class="text-xs text-gray-500 mb-4">Tambahkan pilihan seperti level pedas, ukuran, atau topping.</p>
                <input type="text" name="ukuran" placeholder="Contoh: Ukuran"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white mb-3" />
                <input type="text" name="variant" placeholder="Contoh: Rasa"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white" />
                <button type="button"
                    class="mt-3 w-full bg-gray-800 text-white font-medium py-3 rounded-lg hover:bg-gray-900 transition">
                    Tambah
                </button>
            </div>

            <!-- Buttons -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 space-y-3">
                <button type="submit"
                    class="w-full bg-gray-900 text-white font-semibold py-3 rounded-lg hover:bg-black transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('pengusaha.menu.index') }}"
                    class="block text-center text-gray-700 font-medium py-3 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

<script>
    function previewImage(input, previewId, uploadAreaId) {
        const file = input.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const previewDiv = document.getElementById(previewId);
            const previewImg = document.getElementById(previewId + '-img');
            const uploadArea = document.getElementById(uploadAreaId);

            previewImg.src = e.target.result;
            previewDiv.classList.remove('hidden');
            uploadArea.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    function removeImage(inputId, previewId, uploadAreaId) {
        const input = document.getElementById(inputId);
        const previewDiv = document.getElementById(previewId);
        const previewImg = document.getElementById(previewId + '-img');
        const uploadArea = document.getElementById(uploadAreaId);

        input.value = '';
        previewImg.src = '';
        previewDiv.classList.add('hidden');
        uploadArea.classList.remove('hidden');
    }
</script>
</x-layouts.public>