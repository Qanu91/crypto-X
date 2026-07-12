<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2
                bg-indigo-600 text-white
                border border-transparent rounded-md
                font-semibold text-xs uppercase tracking-widest
                hover:bg-indigo-700 active:bg-indigo-800
                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>