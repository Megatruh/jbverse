// pengajuan  usaha
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Daftar sebagai Mitra JBVerse. Akun Anda akan ditinjau oleh Admin sebelum diaktifkan.') }}
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg shadow-sm">
            <div class="flex items-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="font-bold text-sm">{{ __('Terdapat kesalahan pada pengisian form:') }}</p>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 ml-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.pengusaha.store') }}" enctype="multipart/form-data">
        @csrf

        <h3 class="text-lg font-medium text-gray-900 mt-4 mb-2">Data Pemilik</h3>
        
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap Pemilik')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email (Untuk Login)')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <h3 class="text-lg font-medium text-gray-900 mt-6 mb-2">Data Gerai / Usaha</h3>

        <div class="mt-4">
            <x-input-label for="umkm_name" :value="__('Nama Gerai (Misal: Kopi Kenangan)')" />
            <x-text-input id="umkm_name" class="block mt-1 w-full" type="text" name="umkm_name" required />
            <x-input-error :messages="$errors->get('umkm_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="contact_number" :value="__('Nomor Telepon/WhatsApp')" />
            <x-text-input id="contact_number" class="block mt-1 w-full" type="text" name="contact_number" required />
            <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="description" :value="__('Deskripsi Singkat Usaha')" />
            <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description" required></textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="image_banner" :value="__('Upload Foto Bukti Gerai (JPG/PNG)')" />

            <!-- Upload Area (shown when no file selected) -->
            <label for="image_banner" id="upload-area-banner"
                class="flex flex-col items-center justify-center w-full h-36 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition mt-1">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm text-gray-600 font-medium">Tap untuk upload foto</p>
                    <p class="text-xs text-gray-400 mt-1">Format JPG, PNG (Maks 2MB)</p>
                </div>
                <input id="image_banner" class="hidden" type="file" name="image_banner" accept="image/*" required
                    onchange="handleImageSelected(this)" />
            </label>

            <!-- File info row (hidden initially, shown after file selected) -->
            <div id="file-info-banner" class="hidden mt-2 flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">
                <!-- File icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <!-- Clickable filename -->
                <button type="button" id="file-name-btn"
                    onclick="openImagePreviewModal()"
                    class="flex-1 text-left text-sm text-indigo-600 font-medium hover:underline truncate">
                </button>
                <!-- Remove button -->
                <button type="button" onclick="removeBannerImage()"
                    class="shrink-0 text-gray-400 hover:text-red-500 transition ml-1" title="Hapus gambar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('image_banner')" class="mt-2" />
        </div>

        {{-- Image Preview Modal --}}
        <div id="image-preview-modal"
            class="fixed inset-0 z-50 hidden items-center justify-center p-4"
            role="dialog" aria-modal="true">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeImagePreviewModal()"></div>
            {{-- Card --}}
            <div class="relative z-10 bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-800">Preview Foto Bukti Gerai</p>
                    <button type="button" onclick="closeImagePreviewModal()"
                        class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-1.5 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 bg-gray-50">
                    <img id="modal-preview-img" src="" alt="Preview"
                        class="w-full max-h-80 object-contain rounded-xl border border-gray-200 bg-white" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>
    </form>

<script>
    let _previewDataUrl = '';

    function handleImageSelected(input) {
        const file = input.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            _previewDataUrl = e.target.result;

            // Show file info row
            document.getElementById('file-name-btn').textContent = file.name;
            document.getElementById('file-info-banner').classList.remove('hidden');
            document.getElementById('file-info-banner').classList.add('flex');
            document.getElementById('upload-area-banner').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    function removeBannerImage() {
        _previewDataUrl = '';
        document.getElementById('image_banner').value = '';
        document.getElementById('file-info-banner').classList.add('hidden');
        document.getElementById('file-info-banner').classList.remove('flex');
        document.getElementById('upload-area-banner').classList.remove('hidden');
    }

    function openImagePreviewModal() {
        if (!_previewDataUrl) return;
        document.getElementById('modal-preview-img').src = _previewDataUrl;
        const modal = document.getElementById('image-preview-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImagePreviewModal() {
        const modal = document.getElementById('image-preview-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeImagePreviewModal();
    });
</script>
</x-guest-layout>