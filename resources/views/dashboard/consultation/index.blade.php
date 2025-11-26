<x-layout.client title="Consultation">
    <x-layout.client.client-sidebar />
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]"">
        <x-layout.client.client-navbar page="Consultation" />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($consultation as $item)
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"  class="rounded-sm shadow-sm p-4">
                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between text-xs mb-1 opacity-70">
                            <span class="text-sm opacity-70">Consultation</span>
                            @if ($item->status === 'Upcoming')
                                <x-ui.badge color="info" size="sm">{{ $item->status }}</x-ui.badge>
                            @elseif ($item->status === 'Ongoing')
                                <x-ui.badge color="secondary" size="sm">{{ $item->status }}</x-ui.badge>
                            @elseif ($item->status === 'Completed')
                                <x-ui.badge color="success" size="sm">{{ $item->status }}</x-ui.badge>
                            @else
                                <x-ui.badge color="error" size="sm">{{ $item->status }}</x-ui.badge>
                            @endif
                        </div>

                        <span class="text-3xl font-bold text-primary">{{ $item->title }}</span>
                        
                       <div class="flex flex-col gap-1 mt-2 text-sm">
                            <div class="flex justify-between">
                                <span class="opacity-70">Start:</span>
                                <span>{{ $item->start_time ? $item->start_time->format('F j, Y \a\t g:i A') : 'No start time set' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="opacity-70">End:</span>
                                <span>{{ $item->end_time ? $item->end_time->format('F j, Y \a\t g:i A') : 'No end time set' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="opacity-70">Location:</span>
                                <span>{{ $item->location ?? 'No location set' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </main>
</x-layout.client>