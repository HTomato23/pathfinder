@props([
    'traits' => null,
    'meaning' => null,
    'percent' => null,
    'score' => null,
])

<div class="reveal-stagger flex flex-col w-full gap-2">
    <h1 class="text-sm cursor-help font-semibold" title="{{ $meaning }}">
        {{ $traits }}
    </h1>
    @if ($percent >= 80 && $percent <= 100)
        <progress class="progress progress-success w-full" value="{{ $percent }}" max="100"></progress>
    @elseif ($percent >= 52 && $percent <= 79)
        <progress class="progress progress-warning w-full" value="{{ $percent }}" max="100"></progress>
    @elseif ($percent >= 0 && $percent <= 51)
        <progress class="progress progress-error w-full" value="{{ $percent }}" max="100"></progress>
    @endif
    <div class="flex justify-end text-xs">
        <span>{{ $score ? $score : '0.0' }} / 5.0</span>
    </div>
</div>