<x-layout.client title="Feedback">
    <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.client.client-navbar page="Feedback"></x-layout.client.client-navbar>

        <!-- Feedback Detail Card -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="avatar avatar-placeholder">
                            <div class="bg-primary text-primary-content w-16 rounded-full">
                                <span class="text-xl">{{ substr($feedback->user->first_name, 0, 1) }}{{ substr($feedback->user->last_name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ $feedback->user->first_name }} {{ $feedback->user->last_name }}</h2>
                            <p class="text-sm opacity-60">User Feedback</p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button 
                            onclick="edit_modal.showModal()" 
                            class="btn btn-sm btn-primary"
                            x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                        <button 
                            onclick="delete_modal.showModal()" 
                            class="btn btn-sm btn-error"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>

                <div class="divider my-0"></div>

                <!-- Date & Time -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm">{{ $feedback->created_at->format('F j, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $feedback->created_at->format('g:i A') }}</span>
                    </div>
                    <div class="badge badge-primary">
                        {{ $feedback->created_at->diffForHumans() }}
                    </div>
                </div>

                <!-- Rating Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Rating</h3>
                    <div class="flex items-center gap-3">
                        <div class="rating rating-lg">
                            @for($i = 1; $i <= 5; $i++)
                                <input 
                                    type="radio" 
                                    name="rating-display" 
                                    class="mask mask-star-2 bg-orange-400" 
                                    {{ $feedback->rating == $i ? 'checked' : '' }}
                                    disabled 
                                />
                            @endfor
                        </div>
                        <span class="text-2xl font-bold">{{ $feedback->rating }}/5</span>
                    </div>
                </div>

                <div class="divider my-0"></div>

                <!-- Feedback Comment -->
                <div>
                    <h3 class="text-lg font-semibold mb-3">Feedback</h3>
                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-300' : 'bg-base-200'" class="p-4 rounded-lg bg-base-200">
                        <p class="text-base leading-relaxed whitespace-pre-wrap break-words">{{ $feedback->comment }}</p>
                    </div>
                </div>

                <!-- Metadata -->
                @if($feedback->updated_at != $feedback->created_at)
                    <div class="mt-6">
                        <p class="text-xs opacity-60">
                            Last updated: {{ $feedback->updated_at->format('F j, Y g:i A') }} ({{ $feedback->updated_at->diffForHumans() }})
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Edit Feedback Modal -->
        <dialog id="edit_modal" class="modal">
            <div class="modal-box font-outfit w-11/12 max-w-2xl">
                <div class="flex items-center gap-2 text-primary mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <h3 class="text-lg font-bold">Edit Feedback</h3>
                </div>

                <form method="POST" action="/dashboard/feedback/{{ $feedback->id }}/update" 
                    x-data="{ 
                        submitting: false,
                        rating: '{{ $feedback->rating }}',
                        comment: '{{ $feedback->comment }}'
                    }" 
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

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
                                        {{ $feedback->rating == $i ? 'checked' : '' }}
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
                                onclick="edit_modal.close()"
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
                                <span x-show="!submitting">Update Feedback</span>
                                <span x-show="submitting" style="display: none">Updating <span class="loading loading-dots loading-xs"></span></span>
                            </x-ui.button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        <!-- Delete Confirmation Modal -->
        <dialog id="delete_modal" class="modal">
            <div class="modal-box">
                <div class="flex items-center gap-2 text-error mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-lg font-bold">Delete Feedback</h3>
                </div>
                
                <p class="py-4">Are you sure you want to delete this feedback? This action cannot be undone.</p>
                
                <form method="POST" action="/dashboard/feedback/{{ $feedback->id }}/delete" 
                    x-data="{ deleting: false }"
                    @submit.prevent="if (!deleting) { deleting = true; $el.submit(); }">
                    @csrf
                    @method('DELETE')
                    
                    <div class="flex justify-end gap-2">
                        <button 
                            type="button" 
                            class="btn btn-ghost"
                            onclick="delete_modal.close()"
                            x-bind:disabled="deleting"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            class="btn btn-error"
                            x-bind:disabled="deleting"
                        >
                            <span x-show="!deleting">Delete</span>
                            <span x-show="deleting" style="display: none">Deleting <span class="loading loading-dots loading-xs"></span></span>
                        </button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </main>
</x-layout.client>