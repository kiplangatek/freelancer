<button
	{{ $attributes->merge(['class' => ' mt-2 inline-flex w-full max-w-md items-center justify-center rounded-md bg-blue-500 px-3.5 py-2.5 font-semibold leading-7 text-white hover:bg-blue/60', 'type' => 'submit']) }}>
	{{ $slot }}
</button>
