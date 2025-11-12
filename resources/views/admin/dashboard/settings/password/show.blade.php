<x-layout.app title="Change Password">
    <x-layout.admin.admin-sidebar></x-layout.admin.admin-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.admin.admin-navbar page="Change Password"></x-layout.admin.admin-navbar>

        @php
            $admin = Auth::guard('admin')->user();
        @endphp

        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
            class="shadow-sm rounded-sm p-7 w-full">
            <div class="flex flex-col gap-4">
                <h1 class="font-poppins text-md">Last Update</h1>
                <hr class="border-base-300" />
                <div class="flex flex-col sm:flex-row justify-between items-start lg:items-center gap-2">
                    <div class="flex flex-col font-outfit">
                        <p class="text-sm">{{ $admin->password_changed_at ? $admin->password_changed_at->diffForHumans() : 'Never changed' }}</p>
                    </div>
                    <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="primary" onclick="my_modal_1.showModal()">Change</x-ui.button>
                </div>
            </div>
        </div>

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

        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Change Password</h3>
                </div>
                <form method="POST" action="{{ route('admin.dashboard.settings.password.update') }}"
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset x-data="{ show: false }" class="fieldset">

                       <!-- Current Password -->
                        <x-ui.form-label required>Current Password:</x-ui.form-label>
                        <x-ui.form-input x-bind:type="show ? 'text' : 'password'" name="current_password" placeholder="Password" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                                    <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                </g>
                            </svg>
                        </x-ui.form-input>

                        <!-- New Password -->
                        <x-ui.form-label required>New Password:</x-ui.form-label>
                        <x-ui.form-input class="validator" x-bind:type="show ? 'text' : 'password'" name="password" placeholder="Password" minlength="8" maxlength="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                                    <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Must be more than 8 and less than 20 characters, including at least one number, one lowercase, and one uppercase letter
                        </p>

                        <!-- Confirm Password -->
                        <x-ui.form-label required>Confirm Password:</x-ui.form-label>
                        <x-ui.form-input class="validator" x-bind:type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Confirm Password" minlength="8" maxlength="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                                    <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                </g>
                            </svg>
                        </x-ui.form-input>

                        <!-- Show Password & Forget Password -->
                        <div class="mt-4 flex justify-between">
                            <div class="flex w-full items-center gap-2">
                                <input x-model="show" type="checkbox" class="checkbox checkbox-sm""> Show Password
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <x-ui.button 
                            type="submit" 
                            color="primary" 
                            class="mt-4"
                            x-bind:disabled="submitting" 
                        >
                            <span x-show="!submitting">Save password</span>
                            <span x-show="submitting">Saving <span class="loading loading-dots loading-xs"></span></span>
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
