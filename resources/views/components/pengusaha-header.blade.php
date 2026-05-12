@props([
    'title' => 'Dashboard Pengusaha',
    'backUrl' => null,
    'tabs' => null,          {{-- array of ['label'=>'...','route'=>'...'] --}}
    'activeTab' => null,
])

<div class="sticky top-0 z-20 bg-indigo-600 text-white shadow-md">
    <div class="flex items-center gap-3 px-4 py-3">
        {{-- Back button --}}
        @if($backUrl)
            <a href="{{ $backUrl }}"
                class="p-1.5 rounded-full hover:bg-indigo-500 transition shrink-0"
                title="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @endif

        {{-- Title area --}}
        <div class="flex-1 min-w-0">
            <p class="text-xs text-indigo-200 font-medium uppercase tracking-wide leading-none mb-0.5">
                JBVerse · Pengusaha
            </p>
            <h1 class="text-base font-bold leading-tight truncate">{{ $title }}</h1>
        </div>

        {{-- Right: logout --}}
        <form method="POST" action="{{ route('logout') }}" class="shrink-0">
            @csrf
            <button type="submit"
                class="p-1.5 rounded-full hover:bg-indigo-500 transition"
                title="Keluar">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>
    </div>

    {{-- Tabs (optional) --}}
    @if($tabs)
        <div class="flex border-t border-indigo-500">
            @foreach($tabs as $tab)
                <a href="{{ $tab['url'] }}"
                    class="flex-1 py-2.5 text-center text-sm font-semibold transition
                        {{ $activeTab === $tab['label']
                            ? 'text-white border-b-2 border-white'
                            : 'text-indigo-200 border-b-2 border-transparent hover:text-white' }}">
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>
    @endif
</div>