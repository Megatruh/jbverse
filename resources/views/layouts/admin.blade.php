<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-inter antialiased bg-bg">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.admin-components.sidebar', ['sidebarClass' => 'lg:flex'])

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            @include('layouts.admin-components.navbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-bg p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
