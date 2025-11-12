@props([
    'required' => false,
    'label' => null
])

<label for="{{ $label }}" {{ $attributes->merge(['class' => 'label mt-4']) }}>
    {{ $slot }}
    @if($required)
        <span class="text-red-700">*</span>
    @endif
</label>
