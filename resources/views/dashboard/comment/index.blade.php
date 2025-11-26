<x-layout.client title="Comments">
    <x-layout.client.client-sidebar />
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.client.client-navbar page="Comments" />

        <!-- Comments Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @forelse ($comments as $item)
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="card bg-base-100 shadow-md hover:shadow-lg transition-shadow">
                    <div class="card-body">
                        <!-- Header -->
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="avatar avatar-placeholder">
                                    <div class="bg-neutral text-neutral-content w-12 rounded-full">
                                        <span>{{ substr($item->admin->first_name, 0, 1) }}{{ substr($item->admin->last_name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm">{{ $item->admin->first_name }} {{ $item->admin->last_name }}</p>
                                    <p class="text-xs opacity-60">Administrator</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs opacity-60">{{ $item->created_at->format('M j, Y') }}</p>
                                <p class="text-xs opacity-60">{{ $item->created_at->format('g:i A') }}</p>
                            </div>
                        </div>

                        <div class="divider my-0"></div>

                        <!-- Comment Content -->
                        <div class="overflow-y-auto max-h-[180px]">
                            <p class="text-sm leading-relaxed break-words">{{ $item->comment }}</p>
                        </div>

                        <!-- Footer -->
                        <div class="card-actions justify-end mt-2">
                            <div class="badge badge-primary badge-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $item->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="card bg-base-100 shadow-md">
                        <div class="card-body items-center text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <h3 class="text-xl font-bold">No Comments Yet</h3>
                            <p class="text-sm opacity-70 max-w-md mt-2">
                                You haven't received any comments from administrators yet. Check back later for feedback.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </main>
</x-layout.client>