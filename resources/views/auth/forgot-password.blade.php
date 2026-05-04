<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="border-b-2 -mx-6">
            <h1 class="ml-6 -mt-2 py-4 font-bold">Lupa Kata Sandi</h1>
        </div>
        <div class="my-4 text-sm text-gray-600">
            {{ __('Konfirmasi email untuk mengirim link reset kata sandi.') }}
        </div>
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-600" />
                </div>
                <x-text-input id="email" class="pl-10 py-2 block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required autofocus placeholder="Konfirmasi email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div class="mt-8 mb-2">
            <x-primary-button class="my-4 w-full flex justify-center py-2">
                Kirim Email
            </x-primary-button>
        </div>
        <div class="relative border-t py-2 -mx-6 -mb-2 text-center">
            <a href="{{ route('login') }}" class="mt-2 inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-1" />
                <span>Kembali ke halaman login</span>
            </a>
        </div>
    </form>
</x-guest-layout>
