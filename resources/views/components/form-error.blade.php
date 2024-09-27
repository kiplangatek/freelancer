@props(['name'])

@error($name)
<p class="mt-0.5 text-xs font-medium  text-red-500">{{ $message }}</p>
@enderror
