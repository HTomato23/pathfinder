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
        ojtExperience: false,
        memberOrganization: false,
        leadershipExperience: false,

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
            this.ojtExperience = localStorage.getItem('OJT') === 'true';
            this.memberOrganization = localStorage.getItem('member_of_organization') === 'true';
            this.leadershipExperience = localStorage.getItem('leadership_experience') === 'true';
        },

        sanitizeGradeInput(input) {
            input = input.replace(/[^0-9]/g, '');
            if (input.length > 1) {
                input = input.slice(0, 1) + '.' + input.slice(1);
            }
            return input.slice(0, 4);
        },
        
        handleSubmitClick(event) {
            event.preventDefault();
            document.getElementById('submit_modal').showModal();
        },
        
        confirmSubmit() {
            if (this.submitting) return;
            this.submitting = true;
            document.getElementById('submit_modal').close();
            document.getElementById('academic-test-form').submit();
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
                <span class="font-bold">5-8 minutes</span>
                <span class="text-xs uppercase">academic</span>
            </div>
            <div class="flex flex-col items-end">
                <span class="font-bold">Unlimited</span>
                <span class="text-xs uppercase">possibilities</span>
            </div>
        </div>

        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal p-8 w-full shadow-sm rounded-sm">
            <span class="flex gap-2 items-center font-semibold text-primary"><x-heroicon-o-exclamation-triangle class="w-5 h-5"/>Note:</span>
            <p class="text-sm">
                You may leave fields blank for years or semesters where grades are not yet available.
                You can only check the boxes for OJT, organization membership, or leadership experience if you have actually experienced them.
            </p>
        </div>

        <div class="reveal flex flex-col gap-4">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-8 w-full shadow-sm rounded-sm">
                <!-- 1st Year Grade -->
                <div class="mb-2">
                    <span class="font-semibold text-primary">1st Year Grade</span>
                </div>

                <div class="flex flex-col md:flex-row justify-between gap-4">
                    {{-- 1st sem --}}
                    <div class="flex w-full flex-col">
                        <x-ui.form-label class="text-xs mb-1">1st sem:</x-ui.form-label>
                        <x-ui.form-input 
                            class="validator" 
                            type="text" 
                            x-model="firstYearFirstSem"
                            @input="firstYearFirstSem = sanitizeGradeInput($event.target.value); localStorage.setItem('1st_year_1st_sem', firstYearFirstSem)"
                            name="1st_year_1st_sem" 
                            placeholder="1.00"
                            maxlength="4">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="text-xs text-gray-500 mt-1">Format: 1.00 - 5.00</p>
                    </div>

                    {{-- 2nd sem --}}
                    <div class="flex w-full flex-col">
                        <x-ui.form-label class="text-xs mb-1">2nd sem:</x-ui.form-label>
                        <x-ui.form-input 
                            class="validator" 
                            type="text" 
                            x-model="firstYearSecondSem"
                            @input="firstYearSecondSem = sanitizeGradeInput($event.target.value); localStorage.setItem('1st_year_2nd_sem', firstYearSecondSem)"
                            name="1st_year_2nd_sem" 
                            placeholder="1.00"
                            maxlength="4">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="text-xs text-gray-500 mt-1">Format: 1.00 - 5.00</p>
                    </div>
                </div>
            </div>

            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-8 w-full shadow-sm rounded-sm">
                <!-- 2nd Year Grade -->
                <div class="mb-2">
                    <span class="font-semibold text-primary">2nd Year Grade</span>
                </div>

                <div class="flex flex-col md:flex-row justify-between gap-4">
                    {{-- 1st sem --}}
                    <div class="flex w-full flex-col">
                        <x-ui.form-label class="text-xs mb-1">1st sem:</x-ui.form-label>
                        <x-ui.form-input 
                            class="validator" 
                            type="text" 
                            x-model="secondYearFirstSem"
                            @input="secondYearFirstSem = sanitizeGradeInput($event.target.value); localStorage.setItem('2nd_year_1st_sem', secondYearFirstSem)"
                            name="2nd_year_1st_sem" 
                            placeholder="1.00"
                            maxlength="4">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="text-xs text-gray-500 mt-1">Format: 1.00 - 5.00</p>
                    </div>

                    {{-- 2nd sem --}}
                    <div class="flex w-full flex-col">
                        <x-ui.form-label class="text-xs mb-1">2nd sem:</x-ui.form-label>
                        <x-ui.form-input 
                            class="validator" 
                            type="text" 
                            x-model="secondYearSecondSem"
                            @input="secondYearSecondSem = sanitizeGradeInput($event.target.value); localStorage.setItem('2nd_year_2nd_sem', secondYearSecondSem)"
                            name="2nd_year_2nd_sem" 
                            placeholder="1.00"
                            maxlength="4">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="text-xs text-gray-500 mt-1">Format: 1.00 - 5.00</p>
                    </div>
                </div>
            </div>

            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-8 w-full shadow-sm rounded-sm">
                <!-- 3rd Year Grade -->
                <div class="mb-2">
                    <span class="font-semibold text-primary">3rd Year Grade</span>
                </div>

                <div class="flex flex-col md:flex-row justify-between gap-4">
                    {{-- 1st sem --}}
                    <div class="flex w-full flex-col">
                        <x-ui.form-label class="text-xs mb-1">1st sem:</x-ui.form-label>
                        <x-ui.form-input 
                            class="validator" 
                            type="text" 
                            x-model="thirdYearFirstSem"
                            @input="thirdYearFirstSem = sanitizeGradeInput($event.target.value); localStorage.setItem('3rd_year_1st_sem', thirdYearFirstSem)"
                            name="3rd_year_1st_sem" 
                            placeholder="1.00"
                            maxlength="4">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="text-xs text-gray-500 mt-1">Format: 1.00 - 5.00</p>
                    </div>

                    {{-- 2nd sem --}}
                    <div class="flex w-full flex-col">
                        <x-ui.form-label class="text-xs mb-1">2nd sem:</x-ui.form-label>
                        <x-ui.form-input 
                            class="validator" 
                            type="text" 
                            x-model="thirdYearSecondSem"
                            @input="thirdYearSecondSem = sanitizeGradeInput($event.target.value); localStorage.setItem('3rd_year_2nd_sem', thirdYearSecondSem)"
                            name="3rd_year_2nd_sem" 
                            placeholder="1.00"
                            maxlength="4">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="text-xs text-gray-500 mt-1">Format: 1.00 - 5.00</p>
                    </div>

                    @if (Auth::user()->program === 'BSIT' || Auth::user()->program === 'BSCS')
                        {{-- summer --}}
                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="text-xs mb-1">Summer:</x-ui.form-label>
                            <x-ui.form-input 
                                class="validator" 
                                type="text" 
                                x-model="thirdYearSummer"
                                @input="thirdYearSummer = sanitizeGradeInput($event.target.value); localStorage.setItem('3rd_year_summer', thirdYearSummer)"
                                name="3rd_year_summer" 
                                placeholder="1.00"
                                maxlength="4">
                                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    </g>
                                </svg>
                            </x-ui.form-input>
                            <p class="text-xs text-gray-500 mt-1">Format: 1.00 - 5.00</p>
                        </div>
                    @endif
                </div>
            </div>

            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-8 w-full shadow-sm rounded-sm">
                <!-- 4th Year Grade -->
                <div class="mb-2">
                    <span class="font-semibold text-primary">4th Year Grade</span>
                </div>

                <div class="flex flex-col md:flex-row justify-between gap-4">
                    {{-- 1st sem --}}
                    <div class="flex w-full flex-col">
                        <x-ui.form-label class="text-xs mb-1">1st sem:</x-ui.form-label>
                        <x-ui.form-input 
                            class="validator" 
                            type="text" 
                            x-model="fourthYearFirstSem"
                            @input="fourthYearFirstSem = sanitizeGradeInput($event.target.value); localStorage.setItem('4th_year_1st_sem', fourthYearFirstSem)"
                            name="4th_year_1st_sem" 
                            placeholder="1.00"
                            maxlength="4">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="text-xs text-gray-500 mt-1">Format: 1.00 - 5.00</p>
                    </div>

                    {{-- 2nd sem --}}
                    <div class="flex w-full flex-col">
                        <x-ui.form-label class="text-xs mb-1">2nd sem:</x-ui.form-label>
                        <x-ui.form-input 
                            class="validator" 
                            type="text" 
                            x-model="fourthYearSecondSem"
                            @input="fourthYearSecondSem = sanitizeGradeInput($event.target.value); localStorage.setItem('4th_year_2nd_sem', fourthYearSecondSem)"
                            name="4th_year_2nd_sem" 
                            placeholder="1.00"
                            maxlength="4">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="text-xs text-gray-500 mt-1">Format: 1.00 - 5.00</p>
                    </div>
                </div>
            </div>

            
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-8 w-full shadow-sm rounded-sm">
                <!-- Extracurricular Experience -->
                <div class="mb-4">
                    <span class="font-semibold text-primary">Extracurricular Experience</span>
                </div>

                <div class="flex flex-col gap-5">
                    <div class="flex justify-between">
                        <div class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                name="OJT" 
                                class="checkbox checkbox-sm checkbox-primary" 
                                x-model="ojtExperience"
                                @change="localStorage.setItem('OJT', ojtExperience)"
                            />
                            <span class="text-sm">OJT Experience</span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                name="member_of_organization" 
                                class="checkbox checkbox-sm checkbox-primary" 
                                x-model="memberOrganization"
                                @change="localStorage.setItem('member_of_organization', memberOrganization)"
                            />
                            <span class="text-sm">Member of Organization</span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                name="leadership_experience" 
                                class="checkbox checkbox-sm checkbox-primary" 
                                x-model="leadershipExperience"
                                @change="localStorage.setItem('leadership_experience', leadershipExperience)"
                            />
                            <span class="text-sm">Leadership Experience</span>
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
            />
        </div>
    </div>

    <!-- Submit Confirmation Modal -->
    <dialog id="submit_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Submit Academic Grades?</h3>
            <p class="py-4">
                Are you ready to submit your grades? Please double-check your entries before proceeding.
            </p>
            <p class="text-warning font-semibold">
                Once submitted, you cannot go back to make any changes to your grades.
            </p>
            <div class="modal-action">
                <button 
                    type="button" 
                    @click="closeSubmitModal()" 
                    class="btn btn-ghost"
                    x-bind:disabled="submitting"
                >
                    Review Grades
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
            <h3 class="font-bold text-lg">Cancel Academic Assessment?</h3>
            <p class="py-4">
                Are you sure you want to cancel this assessment?
            </p>
            <p class="text-error font-semibold">
                Your grades will be saved and you can continue later from where you left off.
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