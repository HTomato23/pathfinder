<x-layout.app title="Consultation">
    <x-layout.admin.admin-sidebar></x-layout.admin.admin-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.admin.admin-navbar page="Consultation"></x-layout.admin.admin-navbar>

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

        <div class="flex justify-between flex-col lg:flex-row gap-2 font-outfit">
            <div class="flex flex-col gap-y-4 w-full">
                <!-- Profile Section -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex justify-center sm:justify-between shadow-sm rounded-sm p-5">
                    <div class="flex flex-col justify-center gap-2">
                        <span class="text-primary uppercase">{{ $consult->title }}</span>
                        @if ($consult->status === 'Upcoming')
                                <x-ui.badge color="info" size="sm">{{ $consult->status }}</x-ui.badge>
                        @elseif ($consult->status === 'Ongoing')
                            <x-ui.badge color="secondary" size="sm">{{ $consult->status }}</x-ui.badge>
                        @elseif ($consult->status === 'Completed')
                            <x-ui.badge color="success" size="sm">{{ $consult->status }}</x-ui.badge>
                        @else
                            <x-ui.badge color="error" size="sm">{{ $consult->status }}</x-ui.badge>
                        @endif
                    </div>
                    <div class="hidden sm:flex sm:justify-center sm:items-center sm:p-3">
                        <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="hidden sm:flex" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
                    </div>
                </div>

                <!-- General Information -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
                    <h1 class="font-medium text-md">General Information</h1>
                    <div class="flex flex-col md:flex-row">
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">Start Time</label>
                                <p class="text-sm">{{ $consult->start_time ? $consult->start_time->format('F j, Y \a\t g:i A') : 'No start time set' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">End Time</label>
                                <p class="text-sm">{{ $consult->end_time ? $consult->end_time->format('F j, Y \a\t g:i A') : 'No end time set' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Location</label>
                                <p class="text-sm">{{ $consult->location ?? 'No location set' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">Updated by</label>
                                <p class="text-sm">{{ $consult->admin->first_name }} {{ $consult->admin->last_name }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Updated at</label>
                                <p class="text-sm">{{ $consult->updated_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="block sm:hidden" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
        </div>

        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">General Information</h3>
                </div>
                <form method="POST" action="/admin/dashboard/consultation/{{ $consult->id }}/update" 
                    x-data="{ submitting: false }" 
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">

                        <!-- Start Time -->
                        <x-ui.form-label required>Start Time:</x-ui.form-label>
                        <input type="datetime-local" name="start_time" class="input w-full" />

                        <!-- End Time -->
                        <x-ui.form-label required>End Time:</x-ui.form-label>
                        <input type="datetime-local" name="end_time" class="input w-full" />

                        <!-- Location -->
                        <x-ui.form-label required>Location:</x-ui.form-label>
                        <x-ui.form-input type="text" name="location" placeholder="Location" maxlength="100" required />

                        <!-- Status -->
                        <x-ui.form-label required>Select a status:</x-ui.form-label>
                        <select class="select w-full" name="status" required>
                            <option disabled selected>Select a status</option>
                            <option value="Upcoming" {{ $consult->status === 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="Ongoing" {{ $consult->status === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ $consult->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ $consult->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        <!-- Submit Button -->
                        <x-ui.button 
                            type="submit" 
                            color="primary" 
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
    </main>
</x-layout.app>