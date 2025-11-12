<x-layout.client title="Verify Email">
     <main class="font-outfit grid min-h-screen place-items-center px-4">

        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#34d399] to-[#a3e635] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        @if (session('success'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
            </div>
        @endif

        @if (session('message'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="success" message="{{ session('message') }}" class="mb-3" />
            </div>
        @endif
        
        <!-- Verify Form -->
        <div class="mx-auto w-full max-w-md">
           <fieldset class="fieldset bg-base-100 border-base-300 rounded-md border p-7">
                <div class="grid place-items-center text-success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-20 h-20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                
                <h1 class="text-xl text-center mb-2">Verify Your Email Address</h1>
        
                <div class="alert alert-success alert-soft">
                    <div class="flex flex-col gap-y-2 p-2">
                        <p class="font-bold">Welcome, {{ auth()->user()->first_name }}!</p>
                        <p>Thanks for registering! Before you can access your account, please verify your email address.</p>
                    </div>
                    
                </div>

                <div class="alert alert-default alert-soft justify-center my-2">
                    {{ auth()->user()->email }}
                </div>

                <p class="text-sm text-justify">We've sent a verification link to your email address. Please check your inbox and click the link to verify your account.</p>
                
                <p class="text-xs">Didn't receive the email? Check your spam folder or click below to resend.</p>

                <div class="flex justify-center space-x-2">
                    <form method="POST" action="{{ route('verification.send') }}" style="display: inline;"
                        x-data="{ submitting: false }"  
                        @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">
                        @csrf
                        <x-ui.button 
                            type="submit" 
                            color="success" 
                            class="mt-3"
                            x-bind:disabled="submitting"
                        >
                            <span x-show="!submitting">Resend Verification Email</span>
                            <span x-show="submitting" style="display: none">Sending Verification <span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" style="display: inline;"
                        x-data="{ submitting: false }"  
                        @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">
                        @csrf
                        <x-ui.button 
                            type="submit" 
                            color="warning" 
                            class="mt-3"
                            x-bind:disabled="submitting"
                        >
                            <span x-show="!submitting">Log out</span>
                            <span x-show="submitting" style="display: none">Logging out <span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>
                    </form>
                </div>
            </fieldset>
        </div>

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