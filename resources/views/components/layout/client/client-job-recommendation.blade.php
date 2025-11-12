@props([
    'id' => null,
    'title' => null,
    'match' => null,
])

<li class="list-row">
    <div class="text-4xl font-thin opacity-30 tabular-nums">{{ $id }}</div>
    <div class="list-col-grow">
        <div>{{ $title }}</div>
        @if ($match === 'High Match')
            <div class="text-xs text-success uppercase font-semibold opacity-60">{{ $match }}</div>
        @elseif ($match === 'Good Match')
            <div class="text-xs text-warning uppercase font-semibold opacity-60">{{ $match }}</div>
        @else
            <div class="text-xs uppercase font-semibold opacity-60">{{ $match }}</div>
        @endif
    </div>
    <x-ui.button href="{{ route('browse.jobs') }}" variant="ghost" size="square">
        <x-heroicon-o-briefcase class="w-5 h-5" />
    </x-ui.button>
</li>