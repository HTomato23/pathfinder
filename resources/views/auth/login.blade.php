<x-layout.client title="Sign In">
    <x-layout.client.navbar />
     <main class="font-outfit grid min-h-screen place-items-center px-4">

        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#34d399] to-[#a3e635] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        <!-- Login Form -->
        <form class="mx-auto w-full max-w-sm" method="POST" action="{{ route('login') }}"
            x-data="{ submitting: false }"  
            @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

            @csrf

            {{-- Success message --}}
            @if (session('success'))
                <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                    <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
                </div>
            @endif

            {{-- Logout message --}}
            @if (session('logout'))
                <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                    <x-ui.alert type="success" message="{{ session('logout') }}" class="mb-3" />
                </div>
            @endif

            {{-- Disabled warning (session) --}}
            @if (session('error'))
                <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                    <x-ui.alert type="warning" message="{{ session('error') }}" class="mb-3" />
                </div>
            @endif

            {{-- Disabled warning --}}
            @error('disabled')
                <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                    <x-ui.alert type="warning" message="{{ $message }}" class="mb-3" />
                </div>
            @enderror

            {{-- Other validation errors (excluding "disabled") --}}
            @if ($errors->any())
                <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                    @foreach ($errors->getMessages() as $key => $messages)
                        @if ($key !== 'disabled')
                            @foreach ($messages as $error)
                                <x-ui.alert type="error" message="{{ $error }}" class="mb-2" />
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @endif

            <fieldset x-data="{ show: false }" class="fieldset bg-base-100 border-base-300 rounded-md border p-7">
                <h1 class="font-outfit text-3xl font-semibold">Sign in</h1>
                <p>Welcome Back! Please enter your details</p>

                <!-- Email -->
                <x-ui.form-label required>Email</x-ui.form-label>
                <x-ui.form-input type="email" name="email" :value="old('email')" placeholder="mail@plpasig.edu.ph"
                    maxlength="50" required>
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </g>
                    </svg>
                </x-ui.form-input>

                <!-- Password -->
                <x-ui.form-label required>Password</x-ui.form-label>
                <x-ui.form-input x-bind:type="show ? 'text' : 'password'" name="password"
                    placeholder="Enter your password" maxlength="50" required>
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <path
                                d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z">
                            </path>
                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                        </g>
                    </svg>
                </x-ui.form-input>
                <x-ui.form-error name="password" />

                <!-- Show Password & Forget Password -->
                <div class="mt-3 flex justify-between">
                    <div class="flex w-full items-center gap-2">
                        <input x-model="show" type="checkbox" class="checkbox checkbox-sm""> Show Password
                    </div>
                    <div class="flex w-full justify-end">
                        <a href="{{ route('auth.forgotpassword') }}" class="hover:underline">Forgot Password?</a>
                    </div>
                </div>

                <!-- Sign In Button -->
                <x-ui.button 
                    type="submit" 
                    color="neutral" 
                    class="mt-3"
                    x-bind:disabled="submitting"
                >
                    <span x-show="!submitting">Sign In</span>
                    <span x-show="submitting" style="display: none">Signing in <span class="loading loading-dots loading-xs"></span></span>
                </x-ui.button>

                <p class="text-center">
                    Don't have an account?
                    <a href="{{ route('show.registerClient') }}" class="text-success hover:underline">Create an account</a>
                </p>
            </fieldset>
        </form>

        <div class="absolute inset-x-0 bottom-0 -z-10 transform-gpu overflow-hidden blur-3xl" aria-hidden="true">
            <div class="relative left-1/2 aspect-[1155/678] w-[72rem] -translate-x-1/2 bg-gradient-to-tr from-[#34d399] to-[#a3e635] opacity-30"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
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