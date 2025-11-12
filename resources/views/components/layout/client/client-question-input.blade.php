@props([
    'value' => null,
    'method' => null,
])

<div class="flex justify-between bg-base-100 px-5 py-3 rounded-sm">
    <div class="flex items-center gap-3">
        <input 
            type="checkbox" 
            value="{{ $value }}"
            class="checkbox checkbox-primary checkbox-sm" 
            :checked="selected === '{{ $value }}'"
            @click="selected = (selected === '{{ $value }}' ? '' : '{{ $value }}')"
        />
        <label>{{ $method }}</label>
    </div>
</div>