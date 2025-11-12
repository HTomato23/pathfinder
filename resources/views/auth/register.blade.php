<x-layout.client title="Register">
    <x-layout.client.navbar></x-layout.client.navbar>
      <main class="font-outfit fixed inset-0 mt-10 z-10">

        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#34d399] to-[#a3e635] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>

        <div class="h-full overflow-y-auto px-4">
            <div class="flex min-h-full items-center justify-center py-8">
                <!-- Registration Form -->
                <form class="z-50 mx-auto w-full max-w-lg" method="POST" action="{{ route('register') }}" 
                    x-data="{ submitting: false, firstName: '', lastName: '', sanitizeName(input){ return input.replace(/[^a-zA-ZñÑ\s.'-]/g, ''); } }" 
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf

                    {{-- Get all errors --}}
                    @if ($errors->any())
                        <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                            @foreach ($errors->all() as $error)
                                <x-ui.alert type="error" message="{{ $error }}" class="mb-2" />
                            @endforeach
                        </div>
                    @endif

                    <fieldset x-data="{ show: false }" class="fieldset bg-base-100 border-base-300 rounded-md border p-7">
                        <h1 class="font-outfit text-3xl font-semibold">Create account</h1>
                        <p>Join Pathfinder and discover your career path.</p>

                        <!-- First Name & Last Name -->
                        <div class="flex w-full flex-col gap-x-5 gap-y-2 sm:flex-row">
                            <!-- First Name -->
                            <div class="flex w-full flex-col">
                                <x-ui.form-label class="mb-1" required>First Name:</x-ui.form-label>
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
                            </div>

                            <!-- Last Name -->
                            <div class="flex w-full flex-col">
                                <x-ui.form-label class="mb-1" required>Last Name:</x-ui.form-label>
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
                            </div>
                        </div>

                        <!-- Email -->
                        <x-ui.form-label required>Email:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="email" name="email" placeholder="mail@plpasig.edu.ph" value="{{ old('email') }}" pattern=".*@plpasig\.edu\.ph$"  title="Email must end with @plpasig.edu.ph" required>
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

                        <!-- Password -->
                        <x-ui.form-label required>Password:</x-ui.form-label>
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

                        {{-- Terms & Privacy | Show Password --}}
                        <div class="mt-4 flex flex-col-reverse justify-between sm:flex-row">
                            <div class="flex items-center gap-2 mt-2 sm:mt-0">
                                <input type="checkbox" name="terms_and_privacy" class="checkbox checkbox-sm" required/>
                                <label>
                                    <a href="{{ route('terms') }}" target="_blank" class="cursor-pointer text-success hover:underline">Terms of Service</a>
                                    and
                                    <a href="{{ route('privacy') }}" target="_blank" class="cursor-pointer text-success hover:underline">Privacy Policy</a>.
                                </label>
                            </div>
                            <div class="flex flex-row items-center gap-2 sm:flex-row-reverse">
                                <input x-model="show" type="checkbox" id="showPassword" class="checkbox checkbox-sm" />
                                <label for="showPassword">Show Password</label>
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <x-ui.button 
                            type="submit" 
                            color="neutral" 
                            class="mt-4"
                            x-bind:disabled="submitting" 
                        >
                            <span x-show="!submitting">Register</span>
                            <span x-show="submitting" style="display: none">Processing <span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>


                        <p class="mt-1 text-center">
                            Already have an account? <a href="{{ route('show.loginClient') }}" class="cursor-pointer text-success hover:underline">Sign in</a>
                        </p>
                    </fieldset>
                </form>

            </div>
        </div>

        <div class="absolute inset-x-0 bottom-0 -z-10 transform-gpu overflow-hidden blur-3xl" aria-hidden="true">
            <div class="relative left-1/2 aspect-[1155/678] w-[72rem] -translate-x-1/2 bg-gradient-to-tr from-[#34d399] to-[#a3e635] opacity-30" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
    </main>
    
    <script>
        // Reload page if user navigates back
        if (performance.navigation.type === 2 || 
            performance.getEntriesByType('navigation')[0]?.type === 'back_forward') {
            window.location.replace(window.location.href);
        }
    </script>
</x-layout.client>