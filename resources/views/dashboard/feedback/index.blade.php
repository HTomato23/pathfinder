<x-layout.client title="Feedback">
    <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.client.client-navbar page="Feedback"></x-layout.client.client-navbar>

        <!-- Feedback -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @forelse ($feedbacks as $item)
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="card bg-base-100 shadow-md hover:shadow-lg transition-shadow">
                    <div class="card-body">
                        <!-- Header -->
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="avatar avatar-placeholder">
                                    <div class="bg-neutral text-neutral-content w-12 rounded-full">
                                        <span>{{ substr($item->user->first_name, 0, 1) }}{{ substr($item->user->last_name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm">{{ $item->user->first_name }} {{ $item->user->last_name }}</p>
                                    <p class="text-xs opacity-60">User</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs opacity-60">{{ $item->created_at->format('M j, Y') }}</p>
                                <p class="text-xs opacity-60">{{ $item->created_at->format('g:i A') }}</p>
                            </div>
                        </div>

                        <div class="divider my-0"></div>

                        <!-- Rating Display -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs font-medium opacity-70">Rating:</span>
                            <div class="rating rating-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <input 
                                        type="radio" 
                                        name="rating-{{ $item->id }}" 
                                        class="mask mask-star-2 bg-orange-400" 
                                        {{ $item->rating == $i ? 'checked' : '' }}
                                        disabled 
                                    />
                                @endfor
                            </div>
                            <span class="text-xs font-semibold">({{ $item->rating }}/5)</span>
                        </div>

                        <!-- Comment Content -->
                        <div class="overflow-y-auto max-h-[180px]">
                            <p class="text-sm leading-relaxed break-words">{{ $item->comment }}</p>
                        </div>

                        <!-- Footer -->
                        <div class="flex items-center justify-between mt-4">
                            <div class="badge badge-primary badge-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $item->created_at->diffForHumans() }}
                            </div>

                            <!-- View Button -->
                            <a href="" class="btn btn-sm btn-ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="card bg-base-100 shadow-md">
                        <div class="card-body items-center text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <h3 class="text-xl font-bold">No Feedback Yet</h3>
                            <p class="text-sm opacity-70 max-w-md mt-2">
                                You haven't submitted any feedback yet.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </main>
</x-layout.client>