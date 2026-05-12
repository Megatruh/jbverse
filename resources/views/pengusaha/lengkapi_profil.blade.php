
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Terima kasih telah mendaftar! Sebelum akun Anda ditinjau oleh Admin, mohon lengkapi data kontak, lokasi toko, dan unggah foto toko (banner) Anda terlebih dahulu.') }}
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

    <form method="POST" action="{{ route('pengusaha.simpan_profil') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mt-4">
            <x-input-label for="name" :value="__('Nama UMKM')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="contact_number" :value="__('Nomor WhatsApp / Telepon')" />
            <x-text-input id="contact_number" class="block mt-1 w-full" type="number" name="contact_number" required autofocus />
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
            ></textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
            <div class="flex items-center justify-between mb-2">
                <x-input-label :value="__('Titik Lokasi Toko (Koordinat)')" />
                
                <button type="button" onclick="getLocation()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-md text-xs font-bold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Ambil Lokasi Saat Ini
                </button>
            </div>
            
            <p id="status-lokasi" class="text-xs text-gray-500 mb-3 italic">Klik tombol di atas jika Anda sedang berada di lokasi toko.</p>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="latitude" :value="__('Latitude')" class="text-xs" />
                    <x-text-input id="latitude" class="block mt-1 w-full text-sm" type="text" name="latitude" placeholder="Isi manual / Otomatis" />
                </div>
                <div>
                    <x-input-label for="longitude" :value="__('Longitude')" class="text-xs" />
                    <x-text-input id="longitude" class="block mt-1 w-full text-sm" type="text" name="longitude" placeholder="Isi manual / Otomatis" />
                </div>
            </div>
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

    <script>
        function getLocation() {
            const statusText = document.getElementById('status-lokasi');
            
            if (navigator.geolocation) {
                statusText.textContent = "Sedang mencari titik GPS Anda...";
                statusText.className = "text-xs text-indigo-600 mb-3 italic font-semibold";
                
                navigator.geolocation.getCurrentPosition(showPosition, showError, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                statusText.textContent = "Browser Anda tidak mendukung fitur lokasi.";
                statusText.className = "text-xs text-red-600 mb-3 italic";
            }
        }

        function showPosition(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            
            const statusText = document.getElementById('status-lokasi');
            statusText.textContent = "✅ Titik koordinat berhasil didapatkan!";
            statusText.className = "text-xs text-emerald-600 mb-3 font-bold";
        }

        function showError(error) {
            const statusText = document.getElementById('status-lokasi');
            statusText.className = "text-xs text-red-600 mb-3 font-semibold";
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    statusText.textContent = "Gagal: Anda menolak izin akses lokasi. Izinkan di pengaturan browser Anda.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    statusText.textContent = "Gagal: Informasi lokasi tidak tersedia saat ini.";
                    break;
                case error.TIMEOUT:
                    statusText.textContent = "Gagal: Waktu permintaan lokasi habis. Coba lagi.";
                    break;
                default:
                    statusText.textContent = "Gagal: Terjadi kesalahan yang tidak diketahui.";
                    break;
            }
        }
    </script>
</x-guest-layout>