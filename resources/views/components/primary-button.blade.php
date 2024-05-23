<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center py-2.5 px-5 bg-lime-500 border border-transparent rounded-md font-semibold text-sm text-black hover:text-white uppercase tracking-widest hover:bg-lime-700 focus:bg-lime-700 active:bg-lime-900 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
