<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg text-center">
            
            <div class="flex justify-center mb-6">
                <svg class="w-20 h-20 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Sedang Ditinjau</h2>
            
            <p class="text-gray-600 mb-6">
                Halo, <span class="font-semibold">{{ auth()->user()->name }}</span>! Terima kasih telah mendaftarkan usaha Anda di <strong>JBVerse</strong>. 
                Saat ini tim admin kami sedang melakukan verifikasi data usaha Anda.
            </p>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <p class="text-sm text-yellow-700 text-left">
                    <strong>Catatan:</strong> Proses verifikasi biasanya memakan waktu 1x24 jam. Anda akan bisa mengakses dashboard pengusaha setelah status Anda diubah menjadi <strong>Approved</strong>.
                </p>
            </div>

            <div class="flex flex-col space-y-3">
                <a href="{{ route('pengusaha.dashboard') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Cek Status Verifikasi
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-sm text-gray-500 hover:text-gray-700 underline">
                        Keluar (Logout)
                    </button>
                </form>
            </div>
        </div>
        
        <div class="mt-4 text-gray-500 text-xs">
            &copy; {{ date('Y') }} JBVerse - Katalog UMKM Tasikmalaya
        </div>
    </div>
</x-guest-layout>