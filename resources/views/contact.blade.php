<x-layout.client title="Contact">
    <x-layout.client.navbar />

    {{-- Background gradient bubbles - FIXED --}}
    <div class="absolute inset-x-0 top-10 -z-10 transform-gpu overflow-hidden blur-3xl sm:top-0" aria-hidden="true">
        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[25deg] bg-gradient-to-tr from-[#34d399] to-[#65a30d] opacity-30 dark:opacity-20 sm:left-[calc(50%+20rem)] sm:w-[72rem]" style="clip-path: polygon(20% 10%, 40% 0%, 70% 15%, 85% 35%, 95% 60%, 80% 80%, 60% 90%, 30% 100%, 15% 80%, 5% 50%)"></div>
    </div>
    
    <div class="absolute inset-x-0 -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[50rem]" aria-hidden="true">
        <div class="relative left-[calc(50%-20rem)] aspect-[1155/678] w-[36rem] rotate-[35deg] bg-gradient-to-tr from-[#166534] to-[#4ade80] opacity-30 dark:opacity-20 sm:w-[72rem]" style="clip-path: polygon(80% 0%, 100% 20%, 95% 45%, 85% 65%, 70% 80%, 50% 90%, 30% 80%, 20% 60%, 15% 40%, 20% 10%)"></div>
    </div>

    {{-- Contact header --}}
    <div class="w-[85%] mx-auto py-20 sm:py-32 lg:py-40">
        <div class="reveal text-4xl sm:text-5xl lg:text-7xl text-center font-semibold font-poppins bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent p-3">Reach Out Freely for Pathfinder Inquiries and Support.</div>
    </div>

    {{-- How to submit your inquiry or concern --}}
    <div class="w-[85%] mx-auto py-5">
        <div class="reveal text-2xl sm:text-3xl lg:text-4xl text-center font-medium font-poppins">How To Submit Your Inquiry or Concern</div>
        <div class="flex justify-center mt-8">
            <div class="reveal steps steps-vertical lg:steps-horizontal font-outfit text-gray-400">
                <li class="step step-neutral">Enter your name and email</li>
                <li class="step step-neutral">Provide a brief subject line</li>
                <li class="step step-neutral">Write your message or question</li>
                <li class="step step-neutral">Review your information</li>
                <li class="step step-neutral">Submit the inquiry form</li>
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

    {{-- Form Information & Submit Message --}}
    <div class="w-[85%] mx-auto py-10 lg:py-20 flex flex-col md:flex-row gap-y-10 gap-x-5">
        <div class="flex flex-col justify-center w-full">
            <div class="reveal-stagger text-3xl lg:text-4xl font-semibold font-poppins bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent"> Connect with us on social media, we're just a message away </div>
            <div class="flex flex-col gap-5 mt-10">
                <li class="reveal-stagger flex gap-2 items-center font-outfit"><x-heroicon-o-envelope class="w-5 h-5"/>plppathfinder@gmail.com</li>
                <li class="reveal-stagger flex gap-2 items-center font-outfit"><x-heroicon-o-phone class="w-5 h-5"/>2-8643-1014</li>
                <li class="reveal-stagger flex gap-2 items-center font-outfit"><x-heroicon-o-map-pin class="w-5 h-5"/>12-B Alcalde Jose, Pasig, 1600 Metro Manila</li>
            </div>
        </div>
        <div class="reveal flex w-full">
            <form class="w-full rounded-md shadow-md border-base-300 border p-5 font-outfit" method="POST" action="{{ route('contact.send') }}"
                x-data="{ submitting: false, name: '', sanitizeName(input){ return input.replace(/[^a-zA-ZñÑ\s.'-]/g, ''); } }" 
                @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                @csrf

                {{-- Name --}}
                <label class="reveal-stagger label m-2">Name: <span class="text-red-700">*</span></label>
                <label class="reveal-stagger input validator w-full">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </g>
                    </svg>
                    <input type="text" value="{{ old('name') }}" name="name" placeholder="Name" x-model="name" @input="name = sanitizeName(name)" maxlength="50" required/>
                </label>

                {{-- Email --}}
                <label class="reveal-stagger label m-2">Email: <span class="text-red-700">*</span></label>
                <label class="reveal-stagger input validator w-full">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </g>
                    </svg>
                    <input type="email" value="{{ old('email') }}" name="email" placeholder="mail@site.com" required />
                </label>

                {{-- Subject --}}
                <label class="reveal-stagger label m-2">Subject: <span class="text-red-700">*</span></label>
                <label class="reveal-stagger input validator w-full">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                        </g>
                    </svg>
                    <input type="text" value="{{ old('subject') }}" name="subject" placeholder="Subject" minlength="1" maxlength="30" required />
                </label>

                {{-- Message --}}
                <label class="reveal-stagger label m-2">Message: <span class="text-red-700">*</span></label>
                <textarea name="message" placeholder="Message..." class="reveal-stagger textarea w-full resize-none validator" required></textarea>

                <!-- Message Button -->
                <x-ui.button 
                    type="submit" 
                    color="neutral" 
                    class="reveal-stagger w-full mt-4"
                    x-bind:disabled="submitting" 
                >
                    <span x-show="!submitting">Message</span>
                    <span x-show="submitting" style="display: none">Processing <span class="loading loading-dots loading-xs"></span></span>
                </x-ui.button>
            </form>
        </div>
    </div>

    {{-- Location Map --}}
    <div class="reveal w-[85%] mx-auto mb-20">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.648584052365!2d121.0722005251628!3d14.562077485919717!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c87941df8e2b%3A0xfa411c9f65619616!2s12-B%20Alcalde%20Jose%2C%20Pasig%2C%201600%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1751456725533!5m2!1sen!2sph" class="w-full h-[500px]" style="border: 0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    {{-- Footer --}}
    <x-layout.client.footer />
</x-layout.client>