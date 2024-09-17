@props(['name'])

@error($name)
<p class="mt-0.5 text-sm font-medium italic text-red-500">{{ $message }}</p>
@enderror
