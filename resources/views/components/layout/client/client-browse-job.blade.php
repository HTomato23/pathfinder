@props([
    'id' => null,
    'title' => null,
    'description' => null,
    'link' => null,
])

 <li class="reveal-stagger list-row transition-transform duration-300 hover:text-white hover:bg-accent-content">
    <div class="text-4xl font-thin opacity-30 tabular-nums">{{ $id }}</div>
    <div class="list-col-grow">
        <div class="">{{ $title }}</div>
        <div class="text-xs uppercase font-semibold opacity-60">{{ $description }}</div>
    </div>
    <x-ui.button href="{{ $link }}" target="_blank" variant="ghost" size="square">
        <x-heroicon-o-magnifying-glass class="w-5 h-5" />
    </x-ui.button>
</li>