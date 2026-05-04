<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-red-50">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-lg text-center border-t-4 border-red-600">
            
            <div class="flex justify-center mb-6">
                <svg class="w-20 h-20 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Akun Ditangguhkan</h2>
            
            <p class="text-gray-600 mb-6 italic">
                "Mohon maaf {{ $user->name }}, toko <strong>{{ $umkm->name }}</strong> sedang dibekukan sementara karena melanggar ketentuan layanan."
            </p>

            <div class="bg-red-50 p-4 rounded-md mb-6">
                <p class="text-sm text-red-700 text-left">
                    <strong>Konsekuensi:</strong><br>
                    - Toko otomatis berstatus TUTUP di katalog.<br>
                    - Anda tidak dapat menambah atau mengubah menu.<br>
                    - Profil Anda disembunyikan dari pencarian publik.
                </p>
            </div>

            <form method="POST" action="{{ route('pengusaha.request_reactivate') }}">
                @csrf
                <x-primary-button class="w-full bg-red-600 hover:bg-red-700">
                    Ajukan Aktivasi Kembali
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>