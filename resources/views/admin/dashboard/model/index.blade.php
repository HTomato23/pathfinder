<x-layout.app title="Model Configuration">
    <x-layout.admin.admin-sidebar></x-layout.admin.admin-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.admin.admin-navbar page="Model Configuration"></x-layout.admin.admin-navbar>

        {{-- Success message --}}
        @if (session('success'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
            </div>
        @endif

        @if (session('error'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="error" message="{{ session('error') }}" class="mb-3" />
            </div>
        @endif

        <!-- Model Performance Metrics -->
        <div class="flex flex-col gap-y-5">            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Training Accuracy -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="rounded-sm shadow-sm p-4">
                    <div class="flex flex-col gap-2">
                        <span class="text-sm opacity-70">Training Accuracy</span>
                        <span class="text-3xl font-bold text-primary">{{ number_format($trainingAccuracy, 2) }}%</span>
                        <div class="flex justify-between text-xs mb-1 opacity-70">
                            <span>Performance on training data</span>
                        </div>
                        <progress class="progress progress-primary" value="{{ $trainingAccuracy }}" max="100"></progress>
                    </div>
                </div>
                
                <!-- Testing Accuracy -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="rounded-sm shadow-sm p-4">
                    <div class="flex flex-col gap-2">
                        <span class="text-sm opacity-70">Testing Accuracy</span>
                        <span class="text-3xl font-bold text-secondary">{{ number_format($testingAccuracy, 2) }}%</span>
                        <div class="flex justify-between text-xs mb-1 opacity-70">
                            <span>Performance on test data</span>
                        </div>
                        <progress class="progress progress-secondary" value="{{ $testingAccuracy }}" max="100"></progress>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overfitting Status -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="shadow-sm rounded-sm p-5">
            <div class="flex flex-col gap-1">
                <div class="font-semibold">
                    Model Health: 
                    @if($overfittingGap < 5)
                        <span class="text-success">Excellent</span>
                    @elseif($overfittingGap < 10)
                        <span class="text-info">Good</span>
                    @elseif($overfittingGap < 15)
                        <span class="text-warning">Needs Attention</span>
                    @else
                        <span class="text-error">Critical</span>
                    @endif
                </div>
                <div class="text-xs">
                    Overfitting Gap: {{ number_format($overfittingGap, 2) }}% - 
                    @if($overfittingGap < 5)
                        Model generalizes well to unseen data.
                    @elseif($overfittingGap < 10)
                        Minor overfitting. Model is acceptable for production use.
                    @elseif($overfittingGap < 15)
                        Some overfitting detected. Monitor performance closely.
                    @else
                        Model is memorizing training data. Consider adding more diverse training data or increasing regularization.
                    @endif
                </div>
            </div>
        </div>

        <!-- Ready to Sync Section -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
            <div class="flex flex-col gap-2">
                <h1 class="flex items-center gap-2 font-medium text-primary">
                    Ready to Sync
                </h1>
                
                <p class="text-sm">
                    This will automatically fetch data from students who have completed their assessment 
                    and sync it to the dataset table for model training.
                </p>
            </div>
            
            <div x-cloak :class="$store.theme.isDark() ? 'alert-soft' : ''" class="alert alert-success rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><strong>{{ number_format($readyToSyncCount) }} students</strong> have completed their assessment and are ready for model training.</span>
            </div>
            
            <div class="flex flex-col gap-2">
                <h6 class="font-semibold">What will be synced:</h6>
                <ul class="space-y-2 list-disc list-inside ml-4">
                    <li>Personal information (age, sex, civil status)</li>
                    <li>Personality test results (Big Five traits)</li>
                    <li>Academic information (program, CGPA, OJT completion)</li>
                    <li>Soft skills and hard skills ratings</li>
                    <li>Leadership and organization participation</li>
                    <li>Work experience and freelance background</li>
                </ul>
            </div>
        </div>

        <div x-cloak class="alert alert-vertical sm:alert-horizontal">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h3 class="font-bold">Ready to Sync Data</h3>
                <div class="text-xs">Click the button below to sync student profiles to the dataset table for model training. This will transfer all completed assessments.</div>
            </div>
            @if($readyToSyncCount > 0)
                <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="neutral"
                    size="sm" class="text-white" onclick="my_modal_1.showModal()">Sync Data</x-ui.button>
            @else
                <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" variant="disabled"
                    size="sm">No records to sync</x-ui.button>
            @endif
        </div>

        {{-- Reactivate Account --}}
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-success mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Sync Dataset</h3>
                </div>
                <form method="POST" action="{{ route('admin.dashboard.model.sync') }}" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf

                    <fieldset class="fieldset">

                        <!-- Activate -->
                        <x-ui.form-input class="hidden" type="text" value="Offline" name="status" />

                        <p class="text-sm text-justify mb-2">Are you sure you want to continue? This action will sync the dataset and start training the model. Proceeding may take a few moments.</p>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-ui.button 
                                type="submit" 
                                variant="outline"
                                color="success" 
                                size="sm"
                                x-bind:disabled="submitting"
                            >
                                <span x-show="!submitting">Sync</span>
                                <span x-show="submitting" style="display: none">Syncing <span class="loading loading-dots loading-xs"></span></span>
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