<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Terima kasih telah mendaftar! Sebelum akun Anda ditinjau oleh Admin, mohon lengkapi data kontak dan unggah foto toko (banner) Anda terlebih dahulu.') }}
    </div>

    <form method="POST" action="{{ route('pengusaha.simpan_profil') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mt-4">
            <x-input-label for="contact_number" :value="__('Nomor WhatsApp / Telepon')" />
            <x-text-input id="contact_number" class="block mt-1 w-full" type="text" name="contact_number" :value="old('contact_number', $umkm->contact_number)" required autofocus />
            <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="description" :value="__('Deskripsi Singkat Usaha')" />
            <textarea
                id="description"
                name="description"
                rows="4"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required
            >{{ old('description', $umkm->description) }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="image_banner" :value="__('Foto Gerai / Banner Toko (Maks 2MB)')" />
            <input id="image_banner" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="file" name="image_banner" accept="image/jpeg, image/png, image/jpg" required />
            <x-input-error :messages="$errors->get('image_banner')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Simpan Profil & Ajukan') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>