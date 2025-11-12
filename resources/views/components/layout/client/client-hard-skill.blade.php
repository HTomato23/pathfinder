@props([
    'skill' => null,
    'percent' => null,
])

@php
    // Map percentage ranges to rating scale
    $rating = match(true) {
        $percent == 0 => 0, // No knowledge
        $percent <= 18 => 1.0, // Novice
        $percent <= 37 => 2.0, // Beginner
        $percent <= 56 => 3.0, // Intermediate
        $percent <= 75 => 4.0, // Advanced
        $percent <= 100 => 5.0, // Expert
        default => 0,
    };
@endphp

<div class="flex flex-col w-full gap-2">
    <div class="flex justify-between items-center">
        <h2 class="text-sm font-semibold">{{ $skill }}</h2>
        <span class="text-xs font-medium">{{ number_format($rating, 1) }} / 5.0</span>
    </div>
    @if ($percent >= 0 && $percent <= 18)
        <progress class="progress progress-error w-full" value="{{ $percent }}" max="100"></progress>
    @elseif ($percent >= 19 && $percent <= 56)
        <progress class="progress progress-warning w-full" value="{{ $percent }}" max="100"></progress>
    @elseif ($percent >= 57 && $percent <= 100)
        <progress class="progress progress-success w-full" value="{{ $percent }}" max="100"></progress>
    @endif
</div>