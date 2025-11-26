<x-layout.app title="Control">
    <x-layout.admin.admin-sidebar />
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]" x-data="adminTable()" x-init="init()">
        <x-layout.admin.admin-navbar page="Control" />

        {{-- Get the initials of admins --}}
        @php
            $initials = $admin ? strtoupper(substr($admin->first_name, 0, 1)) . strtoupper(substr($admin->last_name, 0, 1)) : 'AD';
        @endphp

        {{-- Success message --}}
         @if (session('success'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
            </div>
        @endif

        {{-- Display the disable  --}}
        @if (session('disabled'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="warning" message="{{ session('disabled') }}" class="mb-3" />
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

                {{-- Admin Profile --}}
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="flex justify-center sm:justify-between rounded-sm shadow-sm p-5">
                    <div class="flex items-center justify-center gap-5">
                        @if ($admin->status === 'Online')
                            <div class="avatar avatar-online avatar-placeholder">
                                <div class="bg-neutral text-neutral-content w-24 rounded-full">
                                    <span class="text-3xl">{{ $initials }}</span>
                                </div>
                            </div>
                        @elseif ($admin->status === 'Offline')
                            <div class="avatar avatar-placeholder">
                                <div class="bg-neutral text-neutral-content w-24 rounded-full">
                                    <span class="text-3xl">{{ $initials }}</span>
                                </div>
                            </div>
                        @elseif ($admin->status === 'Disabled')
                            <div class="avatar avatar-placeholder">
                                <div class="bg-neutral text-neutral-content w-24 rounded-full">
                                    <span class="text-3xl">{{ $initials }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-sm">{{ $admin->first_name . ' ' . $admin->last_name ?? 'Guest Admin' }}</span>
                            <span class="text-xs text-gray-500 mb-1">{{ $admin->role ?? 'Unknown' }}</span>
                            @if ($admin->status === 'Online')
                                <x-ui.badge color="success" size="sm">{{ $admin->status ??  'Unknown'}}</x-ui.badge>
                            @elseif ($admin->status === 'Offline')
                                <x-ui.badge color="error" size="sm">{{ $admin->status ??  'Unknown'}}</x-ui.badge>
                            @elseif ($admin->status === 'Disabled')
                                <x-ui.badge color="warning" size="sm">{{ $admin->status ??  'Unknown'}}</x-ui.badge>
                            @endif
                        </div>
                    </div>
                    <div class="hidden sm:flex sm:justify-center sm:items-center sm:p-3"">
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="hidden md:block" color="primary" onclick="my_modal_1.showModal()">Edit Role</x-ui.button>
                    </div>
                </div>

                {{-- Display Admin Information --}}
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
                    <h1 class="font-medium text-md">Personal Information</h1>
                    <div class="flex flex-col md:flex-row">
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">ID</label>
                                <p class="text-sm">{{ $admin->admin_id ?? '0' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">First Name</label>
                                <p class="text-sm">{{ $admin->first_name ?? 'Guest Admin' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Last Name</label>
                                <p class="text-sm">{{ $admin->last_name ?? 'Guest Admin' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">Role</label>
                                <p class="text-sm">{{ $admin->role ?? 'Unknown' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Email address</label>
                                <p class="text-sm">{{ $admin->email ?? 'Guest Admin' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Account Settings and Action Field --}}
            <div class="flex flex-col justify-center gap-2 w-full">
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="flex flex-col gap-y-2 rounded-sm shadow-sm p-5 h-full">
                    <h1 class="font-medium text-2xl text-center sm:text-start">Account Settings</h1>
                    <button class="btn bg-base-100 hover:bg-base-200 w-full h-[50px]" onclick="my_modal_5.showModal()">What can you do here?</button>
                    <button class="btn bg-base-100 hover:bg-base-200 w-full h-[50px]" onclick="my_modal_6.showModal()">How does each button work?</button>
                </div>
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="flex flex-col gap-2 rounded-sm shadow-sm h-full p-5">
                    <h1 class="font-medium text-lg">Action Button</h1>
                    <span class="text-sm text-gray-600">Note: Review the account settings.</span>
                    <div class="flex flex-col flex-wrap md:flex-row items-center gap-2">
                        <x-ui.button href="{{ route('admin.dashboard.control') }}" x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full lg:w-18" color="info">Back</x-ui.button>
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full md:hidden" color="primary" onclick="my_modal_1.showModal()">Edit Role</x-ui.button>
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full lg:w-18" color="success" onclick="my_modal_2.showModal()">Activate</x-ui.button>
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full lg:w-18" color="warning" onclick="my_modal_3.showModal()">Disable</x-ui.button>
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full lg:w-18" color="error" onclick="my_modal_4.showModal()">Delete</x-ui.button>                    
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Log Table -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
            class="overflow-x-auto shadow-sm rounded-sm h-[350px]">

            <table class="table font-outfit">
                <thead x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="sticky top-0 z-40">
                    <tr>
                        <th>ID</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin->activityLogs  as $log)
                        <tr>
                            <td>{{ $log->admin_admin_id }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Edit Role --}}
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Update Role</h3>
                </div>
                <form method="POST" action="/admin/dashboard/control/{{ $admin->admin_id }}/update" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">

                        <!-- Role -->
                        <x-ui.form-label required>Select a role:</x-ui.form-label>
                        <select class="select w-full" name="role" required>
                            <option disabled selected>Select a role</option>
                            <option value="Administrator" {{ $admin->role === 'Administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="Consultant" {{ $admin->role === 'Consultant' ? 'selected' : '' }}>Consultant</option>
                            <option value="Blog Moderator" {{ $admin->role === 'Blog Moderator' ? 'selected' : '' }}>Blog Moderator</option>
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

        {{-- Reactivate Account --}}
        <dialog id="my_modal_2" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-success mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Reactivate Account</h3>
                </div>
                <form method="POST" action="/admin/dashboard/control/{{ $admin->admin_id }}/activate" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">

                        <!-- Activate -->
                        <x-ui.form-input class="hidden" type="text" value="Offline" name="status" />

                        <p class="text-sm text-justify mb-2">Are you sure you want to reactivate this account? Only administrators are authorized to perform this action. The admin will regain full access to the system upon activation.</p>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-ui.button 
                                type="submit" 
                                variant="outline"
                                color="success" 
                                size="sm"
                                x-bind:disabled="submitting"
                            >
                                <span x-show="!submitting">Activate</span>
                                <span x-show="submitting" style="display: none">Activating <span class="loading loading-dots loading-xs"></span></span>
                            </x-ui.button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        {{-- Disable Account --}}
        <dialog id="my_modal_3" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-warning mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Disable Account</h3>
                </div>
                <form method="POST" action="/admin/dashboard/control/{{ $admin->admin_id }}/disabled" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">

                        <!-- Disabled -->
                        <x-ui.form-input class="hidden" type="text" value="Disabled" name="status" />

                        <p class="text-sm text-justify mb-2">Are you sure you want to disable this account? Only administrators are authorized to perform this action. The admin will not be able to access the system upon disabling.</p>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-ui.button 
                                type="submit" 
                                variant="outline"
                                color="warning" 
                                size="sm"
                                x-bind:disabled="submitting"
                            >
                                <span x-show="!submitting">Disable</span>
                                <span x-show="submitting" style="display: none">Disabling <span class="loading loading-dots loading-xs"></span></span>
                            </x-ui.button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        {{-- Delete Account --}}
        <dialog id="my_modal_4" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-error mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Delete Account</h3>
                </div>
                <form method="POST" action="/admin/dashboard/control/{{ $admin->admin_id }}/delete" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('DELETE')

                    <fieldset class="fieldset">

                        <p class="text-sm text-justify mb-2">Are you sure you want to delete this account? Only administrators are authorized to perform this action. Please proceed with caution, this cannot be undone.</p>

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

        {{-- What can you do here? --}}
        <dialog id="my_modal_5" class="modal font-outfit">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="flex items-center gap-3 mb-3">
                    <h3 class="text-xl font-bold">What can you do here?</h3>
                </div>
                <div class="text-sm">This Admin Profile Dashboard allows administrators to view and manage their position and status. It also provides quick access to edit roles.</div>
            </div>
        </dialog>

        {{-- How does each button work --}}
        <dialog id="my_modal_6" class="modal font-outfit">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="flex items-center gap-3 mb-3">
                    <h3 class="text-xl font-bold">How does each button work</h3>
                </div>
                <p class="mb-2 text-sm">
                    <span class="font-medium text-info">Back: </span> <br />
                    Returns to Admin Management page.
                </p>
                <p class="mb-2 text-sm">
                    <span class="font-medium text-primary">Edit Role: </span> <br />
                    Updates the admin’s role or access level.
                </p>
                <p class="mb-2 text-sm">
                    <span class="font-medium text-success">Activate: </span> <br />
                    Reactivates a previously deactivated account.
                </p>
                <p class="mb-2 text-sm">
                    <span class="font-medium text-warning">Disabled: </span> <br />
                    Temporarily disables the admin’s account.
                </p>
                <p class="text-sm">
                    <span class="font-medium text-error">Delete: </span> <br />
                    Permanently removes the admin’s account and data.
                </p>
            </div>
        </dialog>
    </main>
</x-layout.app>
