@props(['name'])

@error($name)
    <p class="text-red-500 text-xs font-light">{{ $message }}</p>
@enderror
