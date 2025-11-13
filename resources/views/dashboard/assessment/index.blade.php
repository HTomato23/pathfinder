<x-layout.client title="Assessment">
    <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.client.client-navbar page="Assessment"></x-layout.client.client-navbar>

        {{-- Cancel message --}}
        @if (session('warning'))
            <div class="fixed bottom-4 right-4 z-[9999] space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="warning" message="{{ session('warning') }}" class="mb-3" />
            </div>
        @endif

        <div class="flex flex-col gap-y-4 xl:flex-row xl:gap-x-2">
            <div class="reveal flex justify-center p-5 w-full">
                <div class="flex flex-col gap-4">
                    <h1 class="text-5xl font-medium text-center md:text-start"><span class="bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent">Career Assessment</span></h1>
                    <p class="text-justify">
                        The Career Pathfinder Assessment serves as a valuable tool designed to help students identify
                        their strengths, interests, and potential career path. It aims to provide a clearer
                        understanding of each student’s unique capabilities by evaluating areas such as personality, soft skills, academic performance, personal experience, and skill scale. For PLP non-board
                        program students, this assessment plays a crucial role in guiding them toward career paths that align
                        with their personal attributes and professional goals. Since non-board programs offer a wide range of
                        possible career opportunities, the Career Pathfinder Assessment helps students make informed
                        decisions about their future by matching their competencies and preferences with suitable job
                        fields.
                    </p>
                    <h2 class="text-lg font-semibold">Assessment Guidelines</h2>
                    <ul class="space-y-1">
                        <li class="flex items-center gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                            Answer honestly to get accurate results.
                        </li>
                        <li class="flex items-center gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                            There are no right or wrong answers.
                        </li>
                        <li class="flex items-center gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                            Make sure you are in a quiet environment to focus.
                        </li>
                        <li class="flex items-center gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                            Do not skip any question to ensure a more accurate result.
                        </li>
                        <li class="flex items-center gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                            Choose the option that best reflects how you usually think, feel, or behave.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="reveal p-5 w-full">
                <img src="{{ asset('images/svg/Online test-amico.svg') }}" alt="educationSVG" />
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div class="p-5 w-full mb-2">
                <h1 class="reveal text-5xl font-medium text-center"><span class="bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent">Career Timeline Assessment</span></h1>
            </div>

            <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical font-outfit">
                <li class="reveal-stagger">
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end mb-10">
                        <time class="italic">0 minutes</time>
                        <div class="text-lg font-black">Start</div>
                        <div>
                           The Menu Button with Speed Dial, located at the bottom right of the screen, provides quick and easy access 
                           to important actions before starting the assessment. When clicked, it expands to show three labeled options - Technical 
                           Tips for viewing guidelines, Privacy & Consent for reading the data use agreement, and Start Assessment to begin the test - along with a Close button to collapse the menu. This feature helps keep the interface clean, organized, and user-friendly, allowing students to prepare and proceed smoothly.
                        </div>
                    </div>
                    <hr />
                </li>
                <li class="reveal-stagger">
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-start mb-10 md:text-end">
                        <time class="italic">15–20 minutes</time>
                        <div class="text-lg font-black">Personality Test</div>
                        <div>
                            This test measures core personality traits such as openness, conscientiousness, extraversion, agreeableness, 
                            and neuroticism to understand how individual characteristics influence career choices and work behavior.
                        </div>
                        <p class="mt-2">50 Questions | Likert Scale</p>
                    </div>
                    <hr />
                </li>
                <li class="reveal-stagger">
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end mb-10">
                        <time class="italic">10-12 minutes</time>
                        <div class="text-lg font-black">Soft Skill Test</div>
                        <div>
                            This test evaluates essential interpersonal and workplace skills, including communication, teamwork, 
                            critical thinking, adaptability, and leadership to assess readiness for professional environments.
                        </div>
                        <p class="mt-2">Likert Scale | 35 Questions</p>
                    </div>
                    <hr />
                </li>
                <li class="reveal-stagger">
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-start mb-10 md:text-end">
                        <time class="italic">5–8 minutes</time>
                        <div class="text-lg font-black">Academic Performance</div>
                        <div>
                            This test assesses self-perceived performance to determine the student’s 
                            academic readiness and strengths related to future career goals.
                        </div>
                        <p class="mt-2">Format: Students will input their CWA, organization membership, OJT experience, and leadership experience.</p>
                    </div>
                    <hr />
                </li>
                <li class="reveal-stagger">
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end mb-10">
                        <time class="italic">1-2 minutes</time>
                        <div class="text-lg font-black">Personal Experience</div>
                        <div>
                            This test identifies relevant personal experiences such as work experience and freelance that contribute to overall career preparedness.
                        </div>
                        <p class="mt-2">Format: Students will indicate if they have experience as a working student, or freelancing that shaped their skills.</p>
                    </div>
                    <hr />
                </li>
                <li class="reveal-stagger">
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-start mb-10 md:text-end">
                        @if (Auth::user()->program === 'BSHM')
                            <time class="italic">14-16 minutes</time>
                        @else
                            <time class="italic">7-10 minutes</time>
                        @endif
                        <div class="text-lg font-black">Skill Scale</div>
                        <div>
                            This test measures and scales each skill based on the participant’s answers
                        </div>
                        <p class="mt-2">Format: Students will be assessed using a 0–5 rating scale based on their level of skill in each specified area.</p>
                    </div>
                    <hr />
                </li>
                <li class="reveal-stagger">
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end mb-10">
                        <time class="italic">Congratulations!</time>
                        <div class="text-lg font-black">Summary</div>
                        <div>
                            You’ve successfully completed all parts of the career assessment — including the Personality Test, Soft Skills, Academic Evaluation, Personal Experience, and Skill Scale sections.                        
                        </div>
                    </div>
                    <hr />
                </li>
                @if (Auth::user()->program === 'BSHM')
                    <li class="reveal-stagger">
                        <hr />
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="timeline-start mb-10 md:text-end">
                            <time class="italic">Result & Job Recommendation</time>
                            <div class="text-lg font-black">Complete</div>
                            <div>
                                This assessment evaluates your hospitality management skills and provides job recommendations 
                                that best match your competency level.
                            </div>
                        </div>
                    </li>
                @else
                    <li class="reveal-stagger">
                        <hr />
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="timeline-start mb-10 md:text-end">
                            <time class="italic">Result & Job Recommendation</time>
                            <div class="text-lg font-black">Complete</div>
                            <div>
                                This assessment evaluates your IT and Computer Science skills and provides 
                                job recommendations aligned with your technical strengths and competencies.
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>

        <div class="fab">
            <!-- a focusable div with tabindex is necessary to work on all browsers. role="button" is necessary for accessibility -->
            <div tabindex="0" role="button" class="btn btn-lg btn-circle btn-accent">
                <x-heroicon-o-ellipsis-vertical class="w-5 h-5" />
            </div>

            <!-- close button should not be focusable so it can close the FAB when clicked. It's just a visual placeholder -->
            <div class="fab-close">
                Close <span class="btn btn-circle btn-lg btn-error">✕</span>
            </div>

            @php
                $user = auth()->user();
                
                // Determine which assessment is next
                $nextRoute = null;
                $buttonText = 'Start Assessment';
                $allCompleted = false;
                
                if (!$user->is_personality_completed) {
                    $nextRoute = route('dashboard.assessment.personality');
                    $buttonText = 'Start Assessment';
                } elseif (!$user->is_softskill_completed) {
                    $nextRoute = route('dashboard.assessment.softskill');
                    $buttonText = 'Continue Assessment';
                } elseif (!$user->is_academic_completed) {
                    $nextRoute = route('dashboard.assessment.academic');
                    $buttonText = 'Continue Assessment';
                } elseif (!$user->is_personal_completed) {
                    $nextRoute = route('dashboard.assessment.personal');
                    $buttonText = 'Continue Assessment';
                } elseif (!$user->is_skill_completed) {
                    $nextRoute = route('dashboard.assessment.skill');
                    $buttonText = 'Continue Assessment';
                } else {
                    $allCompleted = true;
                }
            @endphp

            @if ($allCompleted)
                <!-- All assessments completed - show retake button -->
                <form method="POST" action="{{ route('dashboard.assessment.retake') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Retake Assessment</button>
                </form>
            @else
                <!-- Show Start/Continue Assessment button -->
                <a href="{{ $nextRoute }}" class="btn btn-success">
                    {{ $buttonText }}
                </a>
            @endif
            
            <button class="btn btn-info" onclick="my_modal_1.showModal()">Privacy & Consent</button>
            <button class="btn btn-warning" onclick="my_modal_2.showModal()">Technical Tips</button>
        </div>

        <dialog id="my_modal_1" class="modal">
            <div class="modal-box">
                <div class="flex items-center gap-2 text-info mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-xl font-bold">Privacy & Consent</h3>
                </div>
                <ul class="space-y-1">
                    <li class="flex gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                        Your responses will be kept confidential and will only be accessed by authorized personnel for academic and career development purposes.                    </li>
                    <li class="flex gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                        All collected information will be used solely for assessment, guidance, and will not be shared with third parties without your consent.
                    </li>
                    <li class="flex gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                        Participation in this assessment is voluntary, and you may choose not to proceed at any time.
                    </li>
                    <li class="flex gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                        No personally identifiable information will be published or disclosed outside the institution.
                    </li>
                    <li class="flex gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                        By starting the assessment, you acknowledge that you understand and agree to these terms.
                    </li>
                </ul>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        <dialog id="my_modal_2" class="modal">
            <div class="modal-box">
                <div class="flex items-center gap-2 text-warning mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-bold">Technical Tips</h3>
                </div>
                <ul class="space-y-1">
                    <li class="flex gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                        Use a stable internet connection to avoid interruptions.
                    </li>
                    <li class="flex gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                        Make sure your device is fully charged or plugged in.
                    </li>
                    <li class="flex gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                        Keep only this browser tab open to avoid lag or errors.
                    </li>
                    <li class="flex gap-2"><x-heroicon-o-chevron-double-right class="w-5 h-5" /> 
                        If technical issues occur, contact the admin or support immediately.
                    </li>
                </ul>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
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
