<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Profil UMKM</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('pengusaha.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="name" value="Nama Toko" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $umkm->name)" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="description" value="Deskripsi Toko" />
                        <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ old('description', $umkm->description) }}</textarea>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="contact_number" value="Nomor WhatsApp" />
                        <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" :value="old('contact_number', $umkm->contact_number)" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="logo" value="Update Logo Toko" />
                            <input type="file" name="logo" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="image_banner" value="Update Banner Toko" />
                            <input type="file" name="image_banner" class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>