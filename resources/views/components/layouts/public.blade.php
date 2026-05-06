<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JBVerse</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-inter antialiased bg-gray-50 text-gray-900">

    <nav class="bg-header sticky top-0 z-50 shadow-xl">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('public.beranda') }}" class="text-2xl font-bold text-indigo-600">
                        <img src="{{ asset('images/logo.png') }}" alt="JBVerse" class="h-16 w-16 xl:h-25 xl:w-25">
                    </a>
                </div>

                <div class="hidden lg:flex items-center space-x-4">
                    @guest
                        <div>
                            <a href="{{ route('login') }}" class="mr-2 text-gray-300 hover:text-gray-100 font-medium">Masuk</a>
                            <a href="{{ route('register') }}"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">Daftar</a>
                        </div>
                    @endguest

                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a href="/admin/dashboard" class="text-indigo-600 font-medium">Dashboard Admin</a>
                        @elseif(auth()->user()->role === 'pengusaha')
                            <a href="/pengusaha/dashboard" class="text-indigo-600 font-medium">Toko Saya</a>
                        @else
                            <a href="{{ route('profile.edit') }}"
                                class="text-gray-300 font-medium hover:text-gray-100">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Keluar</button>
                            </form>
                        @endif
                    @endauth
                </div>
                @guest
                    <div class="flex lg:hidden items-center space-x-4">
                        <a href="{{ route('login') }}"
                            class="text-gray-500 hover:text-gray-300 font-medium text-sm">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg font-medium hover:bg-indigo-700 transition text-sm">Daftar</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    {{-- Bottom Navigation Bar untuk Mobile --}}
    <div class="block md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 z-16 shadow-lg">
        <div class="flex justify-around items-center h-16 px-2">
            <a href="{{ route('public.beranda') }}"
                class="flex flex-col items-center justify-center text-gray-600 hover:text-indigo-600 transition {{ request()->routeIs('public.beranda') ? 'text-indigo-600' : '' }}">
                <x-heroicon-o-home
                    class="h-7 w-auto text-gray-600 hover:text-indigo-600 transition {{ request()->routeIs('public.beranda') ? 'text-indigo-600' : '' }}" />
                <span class="text-xs mt-1">Beranda</span>
            </a>

            @auth
                @if (auth()->user()->role === 'pengusaha')
                    <a href="/pengusaha/dashboard" 
                    class="flex flex-col items-center justify-center text-gray-600 hover:text-indigo-600 transition {{ request()->routeIs('pengusaha.dashboard') ? 'text-indigo-600' : '' }}">
                        <x-heroicon-o-building-storefront class="w-7 h-7" />
                        <span class="text-xs mt-1">Toko Saya</span>
                    </a>
                @endif
                    <a href="{{ route('profile.edit') }}"
                        class="flex flex-col items-center justify-center text-gray-600 hover:text-indigo-600 transition {{ request()->routeIs('profile.edit') ? 'text-indigo-600' : '' }}">
                        <x-heroicon-o-user-circle
                            class="h-7 w-auto text-gray-600 hover:text-indigo-600 transition {{ request()->routeIs('profile.edit') ? 'text-indigo-600' : '' }}" />
                        <span class="text-xs mt-1">Profil</span>
                    </a>
            @endauth
        </div>
    </div>
    {{-- Tambahkan padding bottom agar konten tidak tertutup navbar --}}
    <div class="h-16 block md:hidden"></div>
</body>

</html>