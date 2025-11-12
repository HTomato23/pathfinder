@props(['skill_scale_field', 'skill_scale'])

<div x-data="{
        totalQuestions: {{ count($skill_scale_field) }},
        answeredQuestions: 0,
        submitting: false,
        
        init() {
            setTimeout(() => {
                this.calculateProgress();
            }, 100);
        },
        
        calculateProgress() {
            let answered = 0;
            const hiddenInputs = this.$el.querySelectorAll('input[type=hidden][name]');
            
            hiddenInputs.forEach(input => {
                if (input.name !== '_token' && input.value && input.value.trim() !== '') {
                    answered++;
                }
            });
            console.log('Answered count:', answered);
            this.answeredQuestions = answered;
        },
        
        getProgress() {
            if (this.totalQuestions === 0) return 0;
            const progress = Math.round((this.answeredQuestions / this.totalQuestions) * 100);
            return progress;
        },
        
        handleSubmitClick(event) {
            event.preventDefault();
            document.getElementById('submit_modal').showModal();
        },
        
        confirmSubmit() {
            if (this.submitting) return;
            this.submitting = true;
            document.getElementById('submit_modal').close();
            document.getElementById('skill-test-form').submit();
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
    @answer-changed.window="calculateProgress()"
    class="flex flex-col-reverse lg:flex-row gap-6 items-start w-full"
>
    <!-- Questions Section -->
    <div class="flex-1 space-y-4 w-full lg:w-auto">

        @if (Auth::user()->program === 'BSHM')
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal flex justify-between w-full shadow-sm rounded-sm p-5">
                <div class="flex flex-col">
                    <span class="font-bold">14-16 minutes</span>
                    <span class="text-xs uppercase">skill scale test</span>
                </div>
                <div class="flex flex-col items-end">
                    <span class="font-bold">Unlimited</span>
                    <span class="text-xs uppercase">possibilities</span>
                </div>
            </div>
        @else
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal flex justify-between w-full shadow-sm rounded-sm p-5">
                <div class="flex flex-col">
                    <span class="font-bold">7-10 minutes</span>
                    <span class="text-xs uppercase">skill scale test</span>
                </div>
                <div class="flex flex-col items-end">
                    <span class="font-bold">Unlimited</span>
                    <span class="text-xs uppercase">possibilities</span>
                </div>
            </div>
        @endif
        


        @if (Auth::user()->program === 'BSHM')
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal p-8 w-full shadow-sm rounded-sm">
                <span class="flex gap-2 items-center font-semibold text-primary"><x-heroicon-o-exclamation-triangle class="w-5 h-5"/>Note:</span>
                <p class="text-sm">
                    This skill scale test consists of 62 questions designed to assess your current level of skills and abilities.
                    Select the number that best describes your level of confidence or ability, using the scale below:
                </p>
            </div>
        @else
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal p-8 w-full shadow-sm rounded-sm">
                <span class="flex gap-2 items-center font-semibold text-primary"><x-heroicon-o-exclamation-triangle class="w-5 h-5"/>Note:</span>
                <p class="text-sm">
                    This skill scale test consists of 36 questions designed to assess your current level of skills and abilities.
                    Select the number that best describes your level of confidence or ability, using the scale below:
                </p>
            </div>
        @endif




        <div class="flex flex-col gap-4">
            @foreach ($skill_scale_field as $item)
                <x-layout.client.client-question question="{!! $item->field !!}" name="{{ $item->name }}">
                    @foreach ($skill_scale as $option)
                        <x-layout.client.client-question-input value="{{ $option->value }}" method="{{ $option->dreyfus }}" />
                    @endforeach
                </x-layout.client.client-question>
            @endforeach
            
            <!-- Submit Button & Cancel Button -->
            <div class="flex justify_start lg:justify-end gap-2">
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
                experience_check="true"
                experience_end_line="true"
                skill_start_line="true"
            />
        </div>
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col items-center justify-center w-full shadow-sm rounded-sm p-5 gap-3">
            <div 
                class="radial-progress text-primary" 
                :style="`--value:${getProgress()}; --size:12rem; --thickness: 2rem;`" 
                role="progressbar"
                :aria-valuenow="getProgress()"
                x-text="`${getProgress()}%`">
            </div>
            <p class="text-sm text-center" x-text="`${answeredQuestions} of ${totalQuestions} questions answered`"></p>
        </div>
    </div>

    <!-- Submit Confirmation Modal -->
    <dialog id="submit_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Submit Skill Scale Test?</h3>
            <p class="py-4">
                Are you ready to submit your answers? Please double-check your responses before proceeding.
            </p>
            <p class="text-warning font-semibold">
                Once submitted, you cannot go back to make any changes to your answers.
            </p>
            <div class="modal-action">
                <button 
                    type="button" 
                    @click="closeSubmitModal()" 
                    class="btn btn-ghost"
                    x-bind:disabled="submitting"
                >
                    Review Answers
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
            <h3 class="font-bold text-lg">Cancel Skill Scale Test?</h3>
            <p class="py-4">
                Are you sure you want to cancel this test?
            </p>
            <p class="text-error font-semibold">
                Your answers will NOT be saved and you will have to start over again from the beginning.
            </p>
            <div class="modal-action">
                <button 
                    type="button" 
                    @click="closeCancelModal()" 
                    class="btn btn-ghost"
                    x-bind:disabled="submitting"
                >
                    Continue Test
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