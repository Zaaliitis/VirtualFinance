<button {{ $attributes->merge(['type' => 'submit', 'class' => 'm-2 inline-flex items-center px-4 py-2 bg-customDarkGreen border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-customLightGreen focus:bg-customDarkGreen-700 active:bg-customDarkGreen-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
