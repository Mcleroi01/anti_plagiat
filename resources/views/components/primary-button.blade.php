<button {{ $attributes->merge(['type' => 'submit', 'class' => 'mt-5 tracking-wide font-semibold bg-blue-400 text-white-500 w-full py-4 rounded-lg hover:bg-green-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none']) }}>
    {{ $slot }}
</button>
