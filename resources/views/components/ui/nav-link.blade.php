@props(['active' => false])

<a {{ $attributes->merge(['class' => ($active ? 'menu-active ' : '') . 'font-medium']) }} aria-current="{{ $active ? 'page' : 'false' }}">
    {{ $slot }}
</a>
