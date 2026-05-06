<!-- Sidebar -->
<div id="sidebar" class="hidden {{ $sidebarClass ?? 'lg:flex' }} w-64 bg-prim4 text-white flex-col">
    <!-- Sidebar Header -->
    <div class="h-16 flex items-center px-6 border-b border-prim1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-opacity-80 transition">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-18 w-auto">
        </a>
    </div>

    <!-- Sidebar Content -->
    <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-prim1' : 'hover:bg-prim1' }}">
            <x-heroicon-o-squares-2x2 class="w-5 h-5" />
            <span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-prim1' : 'hover:bg-prim1' }}">
            <x-heroicon-o-document class="w-5 h-5" />
            <span class="font-medium">Permintaan Daftar Usaha</span>
        </a>
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-prim1' : 'hover:bg-prim1' }}">
            <x-heroicon-o-building-storefront class="w-5 h-5" />
            <span class="font-medium">Usaha Terdaftar</span>
        </a>
        <a href="{{ route('admin.laporan.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('admin.laporan.index') ? 'bg-prim1' : 'hover:bg-prim1' }}">
            <x-heroicon-o-flag class="w-5 h-5" />
            <span class="font-medium">Laporan</span>
        </a>
    </nav>

    {{-- <!-- Sidebar Footer -->
    <div class="border-t border-prim1 px-3 py-4">
        <a href="{{ route('logout') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition hover:bg-red-600/20 text-red-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="font-medium">Logout</span>
        </a>
    </div> --}}
</div>

<script>
    // Show sidebar on larger screens
    function checkSidebarVisibility() {
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('flex');
        } else {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('flex');
        }
    }

    checkSidebarVisibility();
    window.addEventListener('resize', checkSidebarVisibility);
</script>
