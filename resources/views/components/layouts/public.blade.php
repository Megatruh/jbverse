<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JBVerse</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('public.beranda') }}" class="text-2xl font-bold text-indigo-600">
                        JBVerse
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 font-medium">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">Daftar</a>
                    @endguest

                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a href="/admin/dashboard" class="text-indigo-600 font-medium">Dashboard Admin</a>
                        @elseif(auth()->user()->role === 'pengusaha')
                            <a href="/pengusaha/dashboard" class="text-indigo-600 font-medium">Toko Saya</a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="text-gray-700 font-medium hover:text-indigo-600">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Keluar</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

</body>

</html>
