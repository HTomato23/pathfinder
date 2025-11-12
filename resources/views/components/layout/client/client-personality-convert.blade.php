@props([
    'traits' => null,
    'convertion' => null,
    'score' => null,
])

<div class="reveal-stagger flex flex-col w-full gap-2">
    <div class="flex items-center gap-2">
        <h1 class="text-sm font-semibold">{{ $traits }}</h1>
        @if ($score >= 4.0 && $score <= 5.0)
            <x-ui.badge size="sm" color="success">High</x-ui.badge>
        @elseif ($score >= 2.6 && $score <= 3.9)
            <x-ui.badge size="sm" color="warning">Medium</x-ui.badge>
        @elseif ($score >= 1 && $score <= 2.5)
            <x-ui.badge size="sm" color="error">Low</x-ui.badge>
        @endif
    </div>
    <p class="text-xs opacity-70">
        {{ $convertion ? $convertion : 'No result' }}
    </p>
</div>