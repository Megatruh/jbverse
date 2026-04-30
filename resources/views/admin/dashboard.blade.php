<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-lg font-semibold">
                        Halo, {{ auth()->user()->name }}!
                    </p>
                    <p class="mt-1 text-sm text-gray-600">
                        Selamat datang di panel admin JBVerse.
                    </p>
                    <p class="mt-4 text-sm text-gray-600">
                        Kamu bisa logout lewat menu profil di kanan atas (navbar bawaan).
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>