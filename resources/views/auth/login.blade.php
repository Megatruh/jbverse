<x-guest-layout class="w-sm">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <div class="border-b-2 -mx-6">
                <h1 class="ml-6 -mt-2 py-4 font-bold">Masuk</h1>
            </div>
            <!-- Email Address -->
            <x-input-label for="email" :value="__('Email')" class="mt-4" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-600" />
                </div>
                <x-text-input id="email" class="block mt-1 pl-10 py-2 w-full" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <x-input-label for="password" :value="__('Password')" class="mt-4" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-800" />
                </div>
                <x-text-input id="password" class="block mt-1 pl-10 pr-2.5 py-2 w-full" type="password" name="password"
                    required autocomplete="current-password" placeholder="Masukkan password" />
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                </label>
            </div>
            <x-primary-button class="my-4 w-full flex justify-center">
                MASUK
            </x-primary-button>
            <div class="mb-6 text-center">
                <span>Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-indigo-500 hover:text-indigo-700 focus:text-indigo-900 underline">
                    Daftar di sini
                </a>
            </div>
            <div class="border-t">
                <div class="relative mt-6 mb-4 py-4 rounded-xl bg-red-300 border border-gray-700">
                    @if (Route::has('password.request'))
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-800" />
                        </div>
                        <a class="pl-10 underline text-sm text-gray-600 hover:text-gray-800 focus:text-gray-900"
                            href="{{ route('password.request') }}">
                            Lupa kata sandi? Klik untuk reset
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
