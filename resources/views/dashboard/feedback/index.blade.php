<x-layout.client title="Feedback">
    <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.client.client-navbar page="Feedback"></x-layout.client.client-navbar>

        {{-- Success message --}}
        @if (session('success'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
            </div>
        @endif

        {{-- Get all errors --}}
        @if ($errors->any())
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                @foreach ($errors->all() as $error)
                    <x-ui.alert type="error" message="{{ $error }}" class="mb-2" />
                @endforeach
            </div>
        @endif

        <div class="flex justify-end">
            <x-ui.button 
                x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" 
                color="primary" 
                onclick="my_modal_1.showModal()"
                class="w-full sm:w-auto"
            >
                <x-heroicon-o-plus class="w-5 h-5"/>
                Create Feedback
            </x-ui.button>
        </div>

        <!-- Feedback Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @forelse ($feedbacks as $item)
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
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
                                    <p class="text-xs opacity-60">User Feedback</p>
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

                        <!-- Footer -->
                        <div class="flex items-center justify-between mt-4">
                            <div class="badge badge-primary badge-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $item->created_at->diffForHumans() }}
                            </div>

                            <!-- View Button -->
                            <a href="/dashboard/feedback/{{ $item->id }}" class="btn btn-sm btn-ghost">
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
                                You haven't submitted any feedback yet. Click the button above to create your first feedback.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Create Feedback Modal -->
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit w-11/12 max-w-2xl">
                <div class="flex items-center gap-2 text-primary mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <h3 class="text-lg font-bold">Create Feedback</h3>
                </div>

                <form method="POST" action="{{ route('dashboard.feedback.store') }}" 
                    x-data="{ 
                        submitting: false,
                        rating: '',
                        comment: ''
                    }" 
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf

                    <fieldset class="fieldset">

                        <!-- Comment -->
                        <x-ui.form-label required>Feedback:</x-ui.form-label>
                        <textarea 
                            class="textarea textarea-primary w-full h-[120px] resize-none" 
                            name="comment" 
                            placeholder="Share your thoughts, suggestions, or experience..."
                            x-model="comment"
                            maxlength="1000"
                            required
                        ></textarea>
                        <p class="text-xs opacity-70 mt-1">
                            <span x-text="comment.length"></span>/1000 characters
                        </p>

                        <!-- Rating with Stars -->
                        <x-ui.form-label required class="mt-4">Rating:</x-ui.form-label>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="rating rating-lg">
                                @for($i = 1; $i <= 5; $i++)
                                    <input 
                                        type="radio" 
                                        name="rating" 
                                        value="{{ $i }}"
                                        class="mask mask-star-2 bg-orange-400"
                                        required
                                    />
                                @endfor
                            </div>
                        </div>
                        <p class="text-xs opacity-70">Click on the stars to rate (1-5)</p>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-2 mt-6">
                            <button 
                                type="button" 
                                class="btn btn-ghost w-full sm:w-auto"
                                onclick="my_modal_1.close()"
                                x-bind:disabled="submitting"
                            >
                                Cancel
                            </button>
                            <x-ui.button 
                                type="submit" 
                                color="primary" 
                                class="w-full sm:w-auto"
                                x-bind:disabled="submitting" 
                            >
                                <span x-show="!submitting">Submit Feedback</span>
                                <span x-show="submitting" style="display: none">Submitting <span class="loading loading-dots loading-xs"></span></span>
                            </x-ui.button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </main>
</x-layout.client>