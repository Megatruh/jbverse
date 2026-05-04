// pengajuan  usaha
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Daftar sebagai Mitra JBVerse. Akun Anda akan ditinjau oleh Admin sebelum diaktifkan.') }}
    </div>

    <form method="POST" action="{{ route('register.pengusaha.store') }}" enctype="multipart/form-data">
        @csrf

        <h3 class="text-lg font-medium text-gray-900 mt-4 mb-2">Data Pemilik</h3>
        
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap Pemilik')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email (Untuk Login)')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
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
            <x-text-input id="umkm_name" class="block mt-1 w-full" type="text" name="umkm_name" :value="old('umkm_name')" required />
            <x-input-error :messages="$errors->get('umkm_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="contact_number" :value="__('Nomor Telepon/WhatsApp')" />
            <x-text-input id="contact_number" class="block mt-1 w-full" type="text" name="contact_number" :value="old('contact_number')" required />
            <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="description" :value="__('Deskripsi Singkat Usaha')" />
            <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description" required>{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="image_banner" :value="__('Upload Foto Bukti Gerai (JPG/PNG)')" />
            <input id="image_banner" class="block mt-1 w-full" type="file" name="image_banner" accept="image/*" required />
            <x-input-error :messages="$errors->get('image_banner')" class="mt-2" />
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
</x-guest-layout>