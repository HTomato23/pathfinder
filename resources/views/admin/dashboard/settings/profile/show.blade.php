<x-layout.app title="Profile">
    <x-layout.admin.admin-sidebar></x-layout.admin.admin-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.admin.admin-navbar page="Profile"></x-layout.admin.admin-navbar>

        @php
            $admin = Auth::guard('admin')->user();
            $initials = $admin ? strtoupper(substr($admin->first_name, 0, 1)) . strtoupper(substr($admin->last_name, 0, 1)) : 'AD';
        @endphp

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
                        <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="hidden sm:flex" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
                    </div>
                </div>

                <!-- Personal Information -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
                    <h1 class="font-medium text-md">Personal Information</h1>
                    <div class="flex flex-col md:flex-row">
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">ID</label>
                                <p class="text-sm">{{ $admin->admin_id ?? '0' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">First name</label>
                                <p class="text-sm">{{ $admin->first_name ?? 'Guest Admin' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Last name</label>
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
            <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="block sm:hidden" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
        </div>

        <div x-cloak class="alert alert-vertical sm:alert-horizontal">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h3 class="font-bold">Delete Account</h3>
                <div class="text-xs">This action will permanently delete your account, including all your data and progress. This cannot be undone.</div>
            </div>
            <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="error"
                size="sm" onclick="my_modal_2.showModal()">Delete</x-ui.button>
        </div>

        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Profile Information</h3>
                </div>
                <form method="POST" action="{{ route('admin.dashboard.settings.profile.update') }}" 
                    x-data="{ submitting: false, firstName: '{{ $admin->first_name }}', lastName: '{{ $admin->last_name }}', sanitizeName(input){ return input.replace(/[^a-zA-ZñÑ\s.'-]/g, ''); } }" 
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">

                        <!-- First Name -->
                        <x-ui.form-label required>First Name:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="text" name="first_name" x-model="firstName" @input="firstName = sanitizeName(firstName)" placeholder="First Name" maxlength="50" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Max length of characters is 50
                        </p>

                        <!-- Last Name -->
                        <x-ui.form-label required>Last Name:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="text" name="last_name" x-model="lastName" @input="lastName = sanitizeName(lastName)" placeholder="Last Name" maxlength="50" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Max length of characters is 50
                        </p>

                        <!-- Email -->
                        <x-ui.form-label required>Email:</x-ui.form-label>
                        <x-ui.form-input class="validator" value="{{ $admin->email }}"  type="email" name="email" placeholder="mail@plpasig.edu.ph" pattern=".*@plpasig\.edu\.ph$"  title="Email must end with @plpasig.edu.ph" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Email must end with @plpasig.edu.ph
                        </p>

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

        {{-- Delete Account --}}
        <dialog id="my_modal_2" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-error mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Are you sure?</h3>
                </div>
                <form method="POST" action="/admin/dashboard/settings/profile/{{ $admin->admin_id }}/delete" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('DELETE')

                    <fieldset class="fieldset">

                        <p class="text-sm text-justify mb-2">Are you sure you want to delete this account? Please proceed with caution, this cannot be undone.</p>

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
