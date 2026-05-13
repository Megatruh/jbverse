<x-layouts.public>
    <div class="min-h-screen bg-white">
        <x-pengusaha-header
            title="Edit Menu"
            backUrl="{{ route('pengusaha.menu.index') }}"
        />

        <!-- Content -->
        <form action="{{ route('pengusaha.menu.update', $menu) }}" method="POST" enctype="multipart/form-data"
            class="px-4 py-6 pb-32 space-y-6">
            @csrf
            @method('PUT')

            <!-- Foto Menu -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-base font-semibold text-gray-900 mb-3">Foto Menu</label>

                <!-- Upload Area (shown when no image) -->
                <label for="image" id="upload-area-image"
                    class="@if($menu->image) hidden @endif flex flex-col items-center justify-center w-full h-40 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
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

                <!-- Image Preview -->
                <div id="preview-image" class="@if(!$menu->image) hidden @endif relative w-full">
                    <img id="preview-image-img"
                        src="@if($menu->image) {{ asset('storage/' . $menu->image) }} @endif"
                        alt="Preview Foto Menu"
                        class="w-full h-48 object-cover rounded-lg border border-gray-200" />
                    <button type="button"
                        onclick="removeImage('image', 'preview-image', 'upload-area-image')"
                        class="absolute top-2 left-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-md transition"
                        title="Hapus gambar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <!-- Hidden input to signal image removal to server -->
                    <input type="hidden" id="remove-image-flag" name="remove_image" value="0" />
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
                    value="{{ old('name', $menu->name) }}" required />
            </div>

            <!-- Harga Menu -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Harga Menu
                    <span class="text-red-600">*</span>
                </label>
                <input type="number" id="price" name="price" placeholder="0"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white"
                    min="0" value="{{ old('price', $menu->price) }}" required />
            </div>

            <!-- Kategori -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Kategori</label>
                <select id="category" name="category"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white appearance-none"
                    required>
                    <option value="">Pilih kategori</option>
                    <option value="Makanan" {{ old('category', $menu->category) == 'Makanan' ? 'selected' : '' }}>
                        Makanan</option>
                    <option value="Minuman" {{ old('category', $menu->category) == 'Minuman' ? 'selected' : '' }}>
                        Minuman</option>
                    <option value="Jajanan" {{ old('category', $menu->category) == 'Jajanan' ? 'selected' : '' }}>
                        Jajanan</option>
                    <option value="Dessert" {{ old('category', $menu->category) == 'Dessert' ? 'selected' : '' }}>
                        Dessert</option>
                </select>
            </div>

            <!-- Deskripsi Menu -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi Menu</label>
                <textarea id="description" name="description" placeholder="Jelaskan detail menu kamu..." rows="4"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white resize-none">{{ old('description', $menu->description) }}</textarea>
            </div>

            @php
                $ukuranList = old('ukuran', $menu->ukuran);
                if (is_string($ukuranList)) {
                    $decoded = json_decode($ukuranList, true);
                    $ukuranList = json_last_error() === JSON_ERROR_NONE ? $decoded : [$ukuranList];
                }
                $ukuranList = is_array($ukuranList) ? array_filter($ukuranList) : [];
                if (empty($ukuranList)) $ukuranList = [''];

                $variantList = old('variant', $menu->variant);
                if (is_string($variantList)) {
                    $decoded = json_decode($variantList, true);
                    $variantList = json_last_error() === JSON_ERROR_NONE ? $decoded : [$variantList];
                }
                $variantList = is_array($variantList) ? array_filter($variantList) : [];
                if (empty($variantList)) $variantList = [''];
            @endphp

            <!-- Tambahkan Varian & Rasa -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-1">Tambahkan Varian & Rasa (Opsional)</h3>
                <p class="text-xs text-gray-500 mb-4">Tambahkan pilihan seperti ukuran, atau rasa. Kosongkan jika tidak perlu.</p>
                
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Varian (Contoh: Ukuran, Level Pedas)</label>
                    <div id="ukuran-list" class="space-y-2">
                        @foreach($ukuranList as $uk)
                        <div class="flex space-x-2">
                            <input type="text" name="ukuran[]" placeholder="Contoh: Besar"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white"
                                value="{{ $uk }}" />
                            <button type="button" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition flex-shrink-0" onclick="this.parentElement.remove()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" id="btn-add-ukuran" class="mt-2 text-sm text-indigo-600 font-medium hover:text-indigo-800">+ Tambah Varian</button>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Rasa (Contoh: Coklat, Keju)</label>
                    <div id="variant-list" class="space-y-2">
                        @foreach($variantList as $vr)
                        <div class="flex space-x-2">
                            <input type="text" name="variant[]" placeholder="Contoh: Coklat"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white"
                                value="{{ $vr }}" />
                            <button type="button" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition flex-shrink-0" onclick="this.parentElement.remove()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" id="btn-add-variant" class="mt-2 text-sm text-indigo-600 font-medium hover:text-indigo-800">+ Tambah Rasa</button>
                </div>
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

            // Reset remove flag if it was set
            const removeFlag = document.getElementById('remove-image-flag');
            if (removeFlag) removeFlag.value = '0';
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

        // Signal server to remove current image
        const removeFlag = document.getElementById('remove-image-flag');
        if (removeFlag) removeFlag.value = '1';
    }

    // Script for dynamic inputs
    document.getElementById('btn-add-ukuran').addEventListener('click', function() {
        const container = document.getElementById('ukuran-list');
        const newItem = document.createElement('div');
        newItem.className = 'flex space-x-2';
        newItem.innerHTML = `
            <input type="text" name="ukuran[]" placeholder="Contoh: Besar"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white" />
            <button type="button" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition flex-shrink-0" onclick="this.parentElement.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        `;
        container.appendChild(newItem);
    });

    document.getElementById('btn-add-variant').addEventListener('click', function() {
        const container = document.getElementById('variant-list');
        const newItem = document.createElement('div');
        newItem.className = 'flex space-x-2';
        newItem.innerHTML = `
            <input type="text" name="variant[]" placeholder="Contoh: Coklat"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:bg-white" />
            <button type="button" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition flex-shrink-0" onclick="this.parentElement.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        `;
        container.appendChild(newItem);
    });
</script>
</x-layouts.public>