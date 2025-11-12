@props([
    'variant' => null,
    'color' => null,
    'size' => null,
])

@php
    $variantClasses = [
        'outline' => 'badge-outline',
        'dash' => 'badge-dash',
        'ghost' => 'badge-ghost',
    ];
    
    $colorClasses = [
        'neutral' => 'badge-neutral',
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
        'accent' => 'badge-accent',
        'info' => 'badge-info',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'error' => 'badge-error',
    ];
    
    $sizeClasses = [
        'sm' => 'badge-sm',
        'md' => 'badge-md',
        'lg' => 'badge-lg',
        'xl' => 'badge-xl',
    ];
    
    $classes = 'badge';
    if ($variant && isset($variantClasses[$variant])) $classes .= ' ' . $variantClasses[$variant];
    if ($color && isset($colorClasses[$color])) $classes .= ' ' . $colorClasses[$color];
    if ($size && isset($sizeClasses[$size])) $classes .= ' ' . $sizeClasses[$size];
@endphp

<div :class="$store.theme.isDark() ? 'badge-soft' : ''" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>