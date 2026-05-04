<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 bg-prim1 border border-transparent rounded-lg font-bold text-xs text-white tracking-widest hover:bg-prim2 focus:bg-prim1 active:bg-prim3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
