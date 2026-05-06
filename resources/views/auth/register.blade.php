<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="border-b-2 -mx-6">
            <h1 class="ml-6 -mt-2 py-4 font-bold">Daftarkan Akun</h1>
        </div>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Username')" class="mt-4" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-o-user class="w-5 h-5 text-gray-600" />
                </div>
                <x-text-input id="name" class="block mt-1 w-full py-2 pl-10" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan username" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-600" />
                </div>
                <x-text-input id="email" class="block mt-1 w-full py-2 pl-10" type="email" name="email"
                    :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Buat Password')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-600" />
                </div>
                <x-text-input id="password" class="block mt-1 w-full py-2 pl-10" type="password" name="password"
                    required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-600" />
                </div>
                <x-text-input id="password_confirmation" class="block mt-1 w-full py-2 pl-10" type="password"
                    name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Pilihan Role -->
        <div class="mt-4">
            <x-input-label :value="__('Daftar sebagai:')" />

            <div x-data="{ role: '{{ old('role', 'user') }}' }" class="grid grid-cols-2 gap-4 mt-2">
                {{-- Opsi Pengguna --}}
                <label @click="role = 'user'"
                    :class="role === 'user' ? 'border-gray-700 bg-indigo-50' :
                        'opacity-50 border-gray-300 hover:border-gray-500'"
                    class="relative flex flex-col items-center justify-center cursor-pointer border rounded-lg p-4 transition duration-200">

                    <input type="radio" name="role" value="user" class="sr-only" x-model="role">

                    {{-- Ikon di tengah --}}
                    <div class="flex justify-center items-center mb-2">
                        <x-heroicon-o-user class="w-10 h-10 text-gray-700" />
                    </div>
                    <span class="text-sm font-medium text-gray-800">Pengguna</span>
                </label>

                {{-- Opsi Pengusaha --}}
                <label @click="role = 'pengusaha'"
                    :class="role === 'pengusaha' ? 'border-gray-700 bg-indigo-50' :
                        'opacity-50 border-gray-300 hover:border-gray-500'"
                    class="relative flex flex-col items-center justify-center cursor-pointer border rounded-lg p-4 transition duration-200">

                    <input type="radio" name="role" value="pengusaha" class="sr-only" x-model="role">

                    <div class="flex justify-center items-center mb-2">
                        <x-heroicon-o-building-storefront class="w-10 h-10 text-gray-700" />
                    </div>
                    <span class="text-sm font-medium text-gray-800">Pengusaha</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full flex items-center justify-center py-2">
                {{ __('Buat Akun') }}
            </x-primary-button>
        </div>

        <div class="mt-4 text-center">
            <span>Sudah punya akun?</span>
            <a class="underline text-sm text-indigo-500 hover:text-indigo-700 rounded-md focus:outline-none focus:text-indigo-900"
                href="{{ route('login') }}">
                {{ __('Login di sini') }}
            </a>
        </div>

    </form>
</x-guest-layout>
