<div x-data="{
        submitting: false,
        
        init() {
            // Load saved data from localStorage
            this.loadFromLocalStorage();
        },

        firstYearFirstSem: '',
        firstYearSecondSem: '',
        secondYearFirstSem: '',
        secondYearSecondSem: '',
        thirdYearFirstSem: '',
        thirdYearSecondSem: '',
        thirdYearSummer: '',
        fourthYearFirstSem: '',
        fourthYearSecondSem: '',
        
        // Checkbox states
        workExperience: false,
        freelance: false,

        // Load data from localStorage
        loadFromLocalStorage() {
            this.firstYearFirstSem = localStorage.getItem('1st_year_1st_sem') || '';
            this.firstYearSecondSem = localStorage.getItem('1st_year_2nd_sem') || '';
            this.secondYearFirstSem = localStorage.getItem('2nd_year_1st_sem') || '';
            this.secondYearSecondSem = localStorage.getItem('2nd_year_2nd_sem') || '';
            this.thirdYearFirstSem = localStorage.getItem('3rd_year_1st_sem') || '';
            this.thirdYearSecondSem = localStorage.getItem('3rd_year_2nd_sem') || '';
            this.thirdYearSummer = localStorage.getItem('3rd_year_summer') || '';
            this.fourthYearFirstSem = localStorage.getItem('4th_year_1st_sem') || '';
            this.fourthYearSecondSem = localStorage.getItem('4th_year_2nd_sem') || '';
            
            // Load checkbox states
            this.workExperience = localStorage.getItem('work_experience') === 'true';
            this.freelance = localStorage.getItem('freelance') === 'true';
        },
        
        handleSubmitClick(event) {
            event.preventDefault();
            document.getElementById('submit_modal').showModal();
        },
        
        confirmSubmit() {
            if (this.submitting) return;
            this.submitting = true;
            document.getElementById('submit_modal').close();
            document.getElementById('personal-test-form').submit();
        },
        
        closeSubmitModal() {
            document.getElementById('submit_modal').close();
        },
        
        handleCancelClick(event) {
            event.preventDefault();
            document.getElementById('cancel_modal').showModal();
        },
        
        confirmCancel() {
            if (this.submitting) return;
            this.submitting = true;
            document.getElementById('cancel_modal').close();
            document.getElementById('cancel-form').submit();
        },
        
        closeCancelModal() {
            document.getElementById('cancel_modal').close();
        }
    }"
    class="flex flex-col-reverse lg:flex-row gap-6 items-start w-full"
>
    <!-- Questions Section -->
    <div class="flex-1 space-y-4 w-full lg:w-auto">
        
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal flex justify-between w-full shadow-sm rounded-sm p-5">
            <div class="flex flex-col">
                <span class="font-bold">1-2 minutes</span>
                <span class="text-xs uppercase">personal experience</span>
            </div>
            <div class="flex flex-col items-end">
                <span class="font-bold">Unlimited</span>
                <span class="text-xs uppercase">possibilities</span>
            </div>
        </div>

        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal p-8 w-full shadow-sm rounded-sm">
            <span class="flex gap-2 items-center font-semibold text-primary"><x-heroicon-o-exclamation-triangle class="w-5 h-5"/>Note:</span>
            <p class="text-sm">
                These options reflect any work or freelance experience you've gained outside of school. 
                If you don't have any experience yet, you may leave this section blank.
            </p>
        </div>

        <div class="flex flex-col gap-4">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal p-8 w-full shadow-sm rounded-sm">
                <!-- Personal Experience -->
                <div class="mb-4">
                    <span class="font-semibold text-primary">Personal Experience</span>
                </div>

                <div class="flex flex-col gap-5">
                    <div class="flex justify-between">
                        <div class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                name="work_experience" 
                                class="checkbox checkbox-sm checkbox-primary" 
                                x-model="workExperience"
                                @change="localStorage.setItem('work_experience', workExperience)"
                            />
                            <span class="text-sm">Work Experience</span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                name="freelance" 
                                class="checkbox checkbox-sm checkbox-primary" 
                                x-model="freelance"
                                @change="localStorage.setItem('freelance', freelance)"
                            />
                            <span class="text-sm">Freelance</span>
                        </div>
                    </div>
                </div>
            </div>  

            <!-- Submit Button & Cancel Button -->
            <div class="flex justify-start lg:justify-end gap-2">
                <x-ui.button x-cloak color="default" type="button" @click="handleCancelClick($event)">Cancel</x-ui.button>
                <x-ui.button x-cloak color="primary" type="button" @click="handleSubmitClick($event)">Submit</x-ui.button>
            </div>
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
            />
        </div>
    </div>

    <!-- Submit Confirmation Modal -->
    <dialog id="submit_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Submit Personal Experience?</h3>
            <p class="py-4">
                Are you ready to submit your personal experience? Please double-check your entries before proceeding.
            </p>
            <p class="text-warning font-semibold">
                Once submitted, you cannot go back to make any changes to your personal experience.
            </p>
            <div class="modal-action">
                <button 
                    type="button" 
                    @click="closeSubmitModal()" 
                    class="btn btn-ghost"
                    x-bind:disabled="submitting"
                >
                    Review Experience
                </button>
                <button 
                    type="button" 
                    @click="confirmSubmit()" 
                    class="btn btn-primary"
                    x-bind:disabled="submitting"
                >
                    <span x-show="!submitting">Yes, Submit</span>
                    <span x-show="submitting" style="display: none">Submitting <span class="loading loading-dots loading-xs"></span></span>
                </button>
            </div>
        </div>
    </dialog>

    <!-- Cancel Confirmation Modal -->
    <dialog id="cancel_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Cancel Personal Experience Assessment?</h3>
            <p class="py-4">
                Are you sure you want to cancel this assessment?
            </p>
            <p class="text-error font-semibold">
                Your experience selections will be saved and you can continue later from where you left off.
            </p>
            <div class="modal-action">
                <button 
                    type="button" 
                    @click="closeCancelModal()" 
                    class="btn btn-ghost"
                    x-bind:disabled="submitting"
                >
                    Continue Assessment
                </button>
                <button 
                    type="button" 
                    @click="confirmCancel()" 
                    class="btn btn-error"
                    x-bind:disabled="submitting"
                >
                    <span x-show="!submitting">Yes, Cancel</span>
                    <span x-show="submitting" style="display: none">Canceling <span class="loading loading-dots loading-xs"></span></span>
                </button>
            </div>
        </div>
    </dialog>
</div>