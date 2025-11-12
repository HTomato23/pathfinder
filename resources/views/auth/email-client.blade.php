<x-layout.client title="Forgot Password">
    <main class="font-outfit grid min-h-screen place-items-center px-4">

        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#34d399] to-[#a3e635] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        <!-- Login Form -->
        <form class="mx-auto w-full max-w-md" method="POST" action="{{ route('auth.forgotpassword.send') }}"
            x-data="{ submitting: false }"  
            @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

            @csrf

            {{-- Success message --}}
            @if (session('success'))
                <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                    <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
                </div>
            @endif

            {{-- All error message --}}
            @if ($errors->any())
                <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                    @foreach ($errors->all() as $error)
                        <x-ui.alert type="error" message="{{ $error }}" class="mb-2" />
                    @endforeach
                </div>
            @endif



            <fieldset x-data="{ show: false }" class="fieldset bg-base-100 border-base-300 rounded-md border p-7">
                <h1 class="font-outfit text-3xl font-semibold">Forgot Password</h1>
                <p>Please enter your email address!</p>

                <!-- Email -->
                <x-ui.form-label required>Email</x-ui.form-label>
                <x-ui.form-input type="email" name="email" placeholder="mail@plpasig.edu.ph"
                    maxlength="50" required>
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </g>
                    </svg>
                </x-ui.form-input>

                <!-- Send Email Button -->
                <x-ui.button 
                    type="submit" 
                    color="neutral" 
                    class="mt-3"
                    x-bind:disabled="submitting"
                >
                    <span x-show="!submitting">Send</span>
                    <span x-show="submitting" style="display: none">Sending <span class="loading loading-dots loading-xs"></span></span>
                </x-ui.button>

                <p class="text-center">
                    <a href="{{ route('show.loginClient') }}" class="text-success hover:underline">Back to Sign In</a>
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