<x-layout.client title="Summary">
    <x-layout.client.client-sidebar />
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.client.client-navbar page="Summary" />

        {{-- Success message --}}
        @if (session('success'))
            <div class="fixed bottom-4 right-4 z-[9999] space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
            </div>
        @endif

        {{-- Warning message --}}
        @if (session('warning'))
            <div class="fixed bottom-4 right-4 z-[9999] space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="warning" message="{{ session('warning') }}" class="mb-3" />
            </div>
        @endif

        @props(['skill_scale_field', 'skill_scale'])

        <form method="POST" action="{{ route('dashboard.assessment.summary.update') }}">
            @csrf
            @method('PATCH')
            <div x-data="{ submitting: false }" class="flex flex-col-reverse lg:flex-row gap-6 items-start w-full">
                <!-- Questions Section -->
                <div class="flex-1 space-y-4 w-full lg:w-auto">
                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-8 w-full shadow-sm rounded-sm">
                        <span class="flex gap-2 items-center font-semibold text-primary text-xl mb-3">Congratulations!</span>
                        <p class="text-sm mb-2">
                            You have successfully completed all sections of the career assessment, including 
                            the Personality Test, Soft Skills, Academic Performance, Personal Experience, and Skill Scale.
                        </p>
                        <p class="text-sm">
                            Tap <span class="font-bold">Continue</span> to explore your job matches and see how you performed in each category.
                        </p>
                    </div>

                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-6 w-full shadow-sm rounded-sm">
                        <div class="flex justify-between items-center">
                            <p class="font-medium">Personality Test</p>
                            <span class="text-success"><x-heroicon-o-check-badge class="w-8 h-8"/></span>
                        </div>
                    </div>

                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-6 w-full shadow-sm rounded-sm">
                        <div class="flex justify-between items-center">
                            <p class="font-medium">Soft Skill Test</p>
                            <span class="text-success"><x-heroicon-o-check-badge class="w-8 h-8"/></span>
                        </div>
                    </div>

                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-6 w-full shadow-sm rounded-sm">
                        <div class="flex justify-between items-center">
                            <p class="font-medium">Academic Performance</p>
                            <span class="text-success"><x-heroicon-o-check-badge class="w-8 h-8"/></span>
                        </div>
                    </div>

                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-6 w-full shadow-sm rounded-sm">
                        <div class="flex justify-between items-center">
                            <p class="font-medium">Personal Experience</p>
                            <span class="text-success"><x-heroicon-o-check-badge class="w-8 h-8"/></span>
                        </div>
                    </div>

                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-6 w-full shadow-sm rounded-sm">
                        <div class="flex justify-between items-center">
                            <p class="font-medium">Skill Scale Test</p>
                            <span class="text-success"><x-heroicon-o-check-badge class="w-8 h-8"/></span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <x-ui.button 
                            type="submit" 
                            color="primary" 
                            class="mt-3"
                            x-bind:disabled="submitting"
                        >
                            <span x-show="!submitting">Continue</span>
                            <span x-show="submitting" style="display: none"><span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>
                    </div>
                </div>

                <!-- Sidebar Section -->
                <div class="w-full lg:w-96 lg:sticky lg:top-6 flex flex-col gap-2">
                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="w-full shadow-sm rounded-sm p-5">
                        <x-layout.client.client-assessment-progress 
                            personality_start_line="true" 
                            personality_check="true" 
                            personality_end_line="true"
                            softskill_start_line="true"
                            softskill_check="true" 
                            softskill_end_line="true"
                            academic_start_line="true"
                            academic_check="true"
                            academic_end_line="true"
                            experience_start_line="true"
                            experience_check="true"
                            experience_end_line="true"
                            skill_start_line="true"
                            skill_check="true"
                        />
                    </div>
                </div>
            </div>
        </form>
    </main>

    @if(session('clearStorage'))
        <script>
            // Save items you want to keep
            const itemsToKeep = {
                'theme': localStorage.getItem('theme'),
            };

            // Clear all localStorage
            localStorage.clear();

            // Restore the items you want to keep
            Object.keys(itemsToKeep).forEach(key => {
                if (itemsToKeep[key] !== null) {
                    localStorage.setItem(key, itemsToKeep[key]);
                }
            });
        </script>
    @endif
</x-layout.client>