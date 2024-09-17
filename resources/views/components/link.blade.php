@props(['active' => false])
<a class="{{ $active ? ' text-blue-600 underline underline-offset-2 font-bold md:font-semibold' : 'hover:text-black text-gray-700 hover:underline' }} font-semibold text-black"
   aria-current="{{ $active ? 'page' : 'false' }}" {{ $attributes }}>{{ $slot }}
</a>
