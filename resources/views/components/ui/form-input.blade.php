<label {{ $attributes->merge(['class' => 'input w-full']) }}>
    {{-- Slot for optional icon --}}
    {{ $slot }}

    <input {{ $attributes }} />
</label>
