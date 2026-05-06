<!-- Navbar -->
<nav class="bg-prim1 text-white shadow-lg h-16 sticky top-0 z-40">
    <div class="h-full px-6 flex items-center justify-between">
        <!-- Left Side -->
        <div class="flex items-center gap-4">
            <!-- Toggle Sidebar Button (Mobile) -->
            <button id="sidebarToggle" class="lg:hidden p-2 hover:bg-prim2 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Right Side -->
        <div class="flex items-center gap-6">
            <!-- Notifications -->
            {{-- <div class="relative group">
                <button class="p-2 hover:bg-prim2 rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                </button>
            </div> --}}

            <!-- User Menu -->
            <div class="relative group">
                <button class="flex items-center gap-3 p-2 hover:bg-prim2 rounded-lg transition">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs opacity-75">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-prim2 flex items-center justify-center text-sm font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div
                    class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white text-gray-900 rounded-lg shadow-xl">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 hover:bg-gray-100 text-sm rounded-t-lg">
                        Profile
                    </a>
                    {{-- <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                        Settings
                    </a> --}}
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm rounded-b-lg border-t border-gray-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('hidden');
    });
</script>
