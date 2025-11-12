@props([
    'type' => 'button',
    'variant' => null,
    'color' => null,
    'size' => null,
    'href' => null,
])

@php
    $variantClasses = [
        'soft' => 'btn-soft',
        'outline' => 'btn-outline',
        'dash' => 'btn-dash',
        'ghost' => 'btn-ghost',
        'link' => 'btn-link',
        'active' => 'btn-active',
        'disabled' => 'btn-disabled',
    ];
    
    $colorClasses = [
        'neutral' => 'btn-neutral',
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'accent' => 'btn-accent',
        'info' => 'btn-info',
        'success' => 'btn-success',
        'warning' => 'btn-warning',
        'error' => 'btn-error',
    ];
    
    $sizeClasses = [
        'xs' => 'btn-xs',
        'sm' => 'btn-sm',
        'md' => 'btn-md',
        'lg' => 'btn-lg',
        'xl' => 'btn-xl',
        'wide' => 'btn-wide',
        'block' => 'btn-block',
        'square' => 'btn-square',
        'circle' => 'btn-circle',
    ];
    
    $classes = 'btn';
    if ($variant && isset($variantClasses[$variant])) $classes .= ' ' . $variantClasses[$variant];
    if ($color && isset($colorClasses[$color])) $classes .= ' ' . $colorClasses[$color];
    if ($size && isset($sizeClasses[$size])) $classes .= ' ' . $sizeClasses[$size];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif