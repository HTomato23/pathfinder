<x-layout.app title="Job Portal Details">
    <x-layout.admin.admin-sidebar />
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.admin.admin-navbar page="Job Portal" />

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

        <div class="flex justify-between flex-col xl:flex-row gap-2 font-outfit">
            <div class="flex flex-col gap-y-2 w-full">  
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="flex justify-center sm:justify-between rounded-sm shadow-sm p-5">
                    <div class="flex items-center justify-center gap-5">
                        <div class="avatar avatar-placeholder">
                            <div class="bg-neutral text-neutral-content w-24 rounded-full">
                                <x-heroicon-o-briefcase class="w-12 h-12" />
                            </div>
                        </div>
                        <div class="flex flex-col min-w-0 flex-1">
                            <span class="text-sm font-semibold truncate">{{ $jobs->title }}</span>
                            <span class="text-xs text-gray-500">Job Portal</span>
                        </div>
                    </div>
                    <div class="flex justify-center items-center p-3">
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="hidden md:block" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
                    </div>
                </div>

                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"  
                    class="flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
                    <h1 class="font-medium text-md">General Information</h1>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex flex-col gap-y-3 w-full min-w-0">
                            <div>
                                <label class="text-gray-600 text-sm">ID</label>
                                <p class="text-sm">{{ $jobs->id }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Title</label>
                                <p class="text-sm break-words">{{ $jobs->title }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Description</label>
                                <p class="text-sm break-words whitespace-pre-wrap">{{ $jobs->description }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-3 w-full min-w-0">
                            <div>
                                <label class="text-gray-600 text-sm">Status</label>
                                <p class="text-sm">
                                    @if ($jobs->status === 'Active')
                                        <x-ui.badge color="success" size="sm">{{ $jobs->status }}</x-ui.badge>
                                    @else
                                        <x-ui.badge color="error" size="sm">{{ $jobs->status }}</x-ui.badge>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Portal Link</label>
                                <p class="text-sm break-all">
                                    <a href="{{ $jobs->link }}" target="_blank" class="link link-primary">
                                        Visit Portal
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Date Created</label>
                                <p class="text-sm">{{ \Carbon\Carbon::parse($jobs->created_at)->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="block sm:hidden" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
        </div>

        <div x-cloak class="alert alert-vertical sm:alert-horizontal">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h3 class="font-bold">Delete job portal</h3>
                <div class="text-xs">This action will permanently delete the job portal information. This cannot be undone.</div>
            </div>
            <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="error"
                size="sm" onclick="my_modal_2.showModal()">Delete</x-ui.button>
        </div>

        {{-- Edit Job Portal Modal --}}
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Update Job Portal</h3>
                </div>
                <form method="POST" action="/admin/dashboard/jobs/{{ $jobs->id }}/update" 
                    x-data="{ submitting: false }" 
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">

                        <!-- Title -->
                        <x-ui.form-label required>Title:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="text" name="title" value="{{ $jobs->title }}" placeholder="Job Portal Title" maxlength="100" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M4 7h16M4 12h16M4 17h10"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Max length of characters is 100
                        </p>

                        <!-- Description -->
                        <x-ui.form-label required>Description:</x-ui.form-label>
                        <textarea name="description" class="textarea textarea-bordered w-full" placeholder="Brief description" maxlength="500" required>{{ $jobs->description }}</textarea>
                        <p class="validator-hint hidden">
                            Max length of characters is 500
                        </p>

                        <!-- Link -->
                        <x-ui.form-label required>Link:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="url" name="link" value="{{ $jobs->link }}" placeholder="https://example.com" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>

                        <!-- Status -->
                        <x-ui.form-label required>Status:</x-ui.form-label>
                        <select name="status" class="select w-full validator" required>
                            <option disabled value="">Select status</option>
                            <option value="Active" {{ $jobs->status === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $jobs->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <!-- Submit Button -->
                        <x-ui.button 
                            type="submit" 
                            color="accent" 
                            class="mt-4"
                            x-bind:disabled="submitting" 
                        >
                            <span x-show="!submitting">Update</span>
                            <span x-show="submitting" style="display: none">Updating <span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        {{-- Delete Job Portal Modal --}}
        <dialog id="my_modal_2" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-error mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Are you sure?</h3>
                </div>
                <form method="POST" action="/admin/dashboard/jobs/{{ $jobs->id }}/delete" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('DELETE')

                    <fieldset class="fieldset">

                        <p class="text-sm text-justify mb-2">Are you sure you want to delete this job portal? Only administrators are authorized to perform this action. Please proceed with caution, this cannot be undone.</p>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-ui.button 
                                type="submit" 
                                variant="outline"
                                color="error" 
                                size="sm"
                                x-bind:disabled="submitting"                  
                            >
                                <span x-show="!submitting">Delete</span>
                                <span x-show="submitting" style="display: none">Deleting <span class="loading loading-dots loading-xs"></span></span>
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
</x-layout.app>