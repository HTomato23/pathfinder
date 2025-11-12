<main class="flex flex-col gap-6 p-5 overflow-x-hidden">
<x-layout.client.client-fillout-navbar page="Dashboard"></x-layout.client.client-fillout-navbar>

    {{-- Get all success --}}
    @if (session('success'))
        <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
            <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
        </div>
    @endif

    @if ($errors->any())
        <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
            @foreach ($errors->all() as $error)
                <x-ui.alert type="error" message="{{ $error }}" class="mb-2" />
            @endforeach
        </div>
    @endif

    @php
        $client = Auth::user();
    @endphp

    <div x-cloak :class="$store.theme.isDark() ? 'alert-soft' : ''" class="alert alert-info alert-vertical sm:alert-horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div>
            <h3 class="font-bold">Completion of account</h3>
            <div class="text-xs">You are required to complete your account information before accessing the system. You may finish it at any time, but system access will remain restricted until this is done..</div>
        </div>
    </div>

    <form class="flex flex-col gap-2" method="POST" action="/dashboard/update"
        x-data="{ 
            submitting: false, 
            firstName: '{{ $client->first_name }}', 
            lastName: '{{ $client->last_name }}', 

            sanitizeName(input) { 
                return input.replace(/[^a-zA-ZñÑ\s.'-]/g, ''); 
            },

            dream: '',
            first_choice: '',
            second_choice: '',
            sanitizeInput(input) {
                return input.replace(/[^a-zA-ZñÑ\s]/g, ''); 
            },

            studentId: '',
            sanitizeStudentId(input) {
                input = input.replace(/[^0-9]/g, '');
                if (input.length > 2) {
                    input = input.slice(0, 2) + '-' + input.slice(2);
                }
                return input.slice(0, 8);
            },

            section: '',
            sanitizeSection(input) {
                input = input.replace(/[^a-zA-Z0-9-]/g, '');
                input = input.toUpperCase();
                if (input.length > 4 && input[4] !== '-') {
                    input = input.slice(0, 4) + '-' + input.slice(4);
                }
                if (input.length > 7) {
                    input = input.slice(0, 7);
                }
                return input;
            },
            
            batchYear: '',
            sanitizeBatchYear(input) {
                input = input.replace(/[^0-9]/g, '');

                if (input.length > 4) {
                    input = input.slice(0, 4) + '-' + input.slice(4);
                }

                return input.slice(0, 9);
            },

            graduationYear: '',
            sanitizeGraduationYear(input) {
                input = input.replace(/[^0-9]/g, '');

                return input.slice(0, 4);
            }
        }"

        @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

        @csrf
        @method('PATCH')

        <div class="flex flex-col lg:flex-row justify-center gap-4 w-full font-outfit">
            {{-- Personal Information --}}
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"  class="flex flex-col gap-2 w-full lg:w-auto lg:basis-[40%] shadow-sm rounded-sm p-5">
                <h1 class="text-md font-medium">Personal Information</h1>
                <fieldset x-data="{ show: false }" class="fieldset">
                    {{-- First Name & Last Name --}}
                    <div class="flex w-full flex-col gap-x-5 gap-y-2 sm:flex-row">
                        <!-- First Name -->
                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="mb-1" required>First Name:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="first_name" x-model="firstName" @input="firstName = sanitizeName(firstName)" placeholder="First Name" maxlength="50" required>
                                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </g>
                                </svg>
                            </x-ui.form-input>
                            <p class="validator-hint hidden">
                                Max length of characters is 50
                            </p>
                        </div>

                        <!-- Last Name -->
                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="mb-1" required>Last Name:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="last_name" x-model="lastName" @input="lastName = sanitizeName(lastName)" placeholder="Last Name" maxlength="50" required>
                                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </g>
                                </svg>
                            </x-ui.form-input>
                            <p class="validator-hint hidden">
                                Max length of characters is 50
                            </p>
                        </div>
                    </div>

                    {{-- Sex & Age --}}
                    <div class="flex w-full flex-col gap-x-5 gap-y-2 sm:flex-row">
                        <!-- Sex -->
                        <div class="flex w-full flex-col">
                            <x-ui.form-label required>Sex:</x-ui.form-label>
                            <select name="sex" class="select w-full validator" required>
                                <option disabled selected value="">Select a sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <p class="validator-hint hidden">
                                Select a sex
                            </p>
                        </div>

                        {{-- Age --}}
                        <div class="flex w-full flex-col">
                            <x-ui.form-label required>Age:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="number" name="age" placeholder="e.g 17" maxlength="2" @keydown="if(['e','E','+','-'].includes($event.key)) $event.preventDefault()" required />
                            <p class="validator-hint hidden">
                                Input your age
                            </p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <x-ui.form-label required>Email:</x-ui.form-label>
                    <x-ui.form-input class="validator" type="email" name="email" placeholder="mail@plpasig.edu.ph" value="{{ $client->email }}" pattern=".*@plpasig\.edu\.ph$"  title="Email must end with @plpasig.edu.ph" required>
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </g>
                        </svg>
                    </x-ui.form-input>
                    <p class="validator-hint hidden">
                        Email must end with @plpasig.edu.ph
                    </p>
                    
                    {{-- Civil Status --}}  
                    <x-ui.form-label required>Civil Status:</x-ui.form-label>
                    <select name="civil_status" class="select w-full validator" required>
                        <option disabled selected value="">Select a civil status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Separated">Separated</option>
                        <option value="Annulled">Annulled</option>
                    </select>
                    <p class="validator-hint hidden">
                        Select a civil status
                    </p>

                    <x-ui.form-label class="mb-1">What career do you aspire to pursue?</x-ui.form-label>
                    <x-ui.form-input class="validator" type="text" name="dream" placeholder="Career goal" x-model="dream" @input="dream = sanitizeInput(dream)" />
                    <p class="validator-hint hidden">
                        Tell us about your career goal.                    
                    </p>
                </fieldset>
            </div>

            {{-- Academic Information --}}
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"  class="w-full lg:w-auto lg:basis-[60%] shadow-sm rounded-sm p-5">
                <h1 class="text-md font-medium">Academic Information</h1>
                <fieldset x-data="{ show: false }" class="fieldset">

                    {{-- Student ID, Program, & Section --}}
                    <div class="flex w-full flex-col gap-x-5 gap-y-2 sm:flex-row">
                        <!-- Student ID -->
                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="mb-1" required>Student ID:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="student_id"  x-model="studentId" @input="studentId = sanitizeStudentId($event.target.value)" placeholder="e.g. 22-00632" maxlength="8" required>
                                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </g>
                                </svg>
                            </x-ui.form-input>
                            <p class="validator-hint hidden">
                                Format: YY-XXXXX (e.g. 24-01234)
                            </p>
                        </div>

                        <!-- Program -->
                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="mb-1" required>Program</x-ui.form-label>
                            <select name="program" class="select w-full validator" required>
                                <option disabled selected value="">Select a program</option>
                                <option value="BSIT">BS Information Technology</option>
                                <option value="BSCS">BS Computer Science</option>
                                <option value="BSHM">BS Hospitality Management</option>
                            </select>
                            <p class="validator-hint hidden">
                                Select a program
                            </p>
                        </div>

                        <!-- Section -->
                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="mb-1" required>Section:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="section" x-model="section" @input="section = sanitizeSection($event.target.value)" placeholder="e.g. BSIT-4B" maxlength="15" required />
                            <p class="validator-hint hidden">
                                Format: Program-Section (e.g. BSIT-4B)
                            </p>
                        </div>
                    </div>

                    {{-- Year Level & Batch Year & Academic Standing --}}
                    <div class="flex w-full flex-col gap-x-5 gap-y-2 sm:flex-row">
                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="mb-1" required>Year Level</x-ui.form-label>
                            <select name="year_level" class="select w-full validator" required>
                                <option disabled selected value="">Select a year level</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                            <p class="validator-hint hidden">
                                Select a year level
                            </p>
                        </div>

                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="mb-1" required>Batch Year:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="batch_year"  x-model="batchYear" @input="batchYear = sanitizeBatchYear($event.target.value)" placeholder="e.g. 2022-2023" maxlength="9" required />
                            <p class="validator-hint hidden">
                                Format: YYYY-YYYY (e.g. 2022-2023)
                            </p>
                        </div>

                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="mb-1" required>Academic Standing</x-ui.form-label>
                            <select name="academic_standing" class="select w-full validator" required>
                                <option disabled selected value="">Select an academic standing</option>
                                <option value="Regular">Regular</option>
                                <option value="Irregular">Irregular</option>
                            </select>
                            <p class="validator-hint hidden">
                                Select a academic standing
                            </p>
                        </div>
                    </div>

                    {{-- Enrollment Status & Expected Graduation Year --}}
                    <div class="flex w-full flex-col gap-x-5 gap-y-2 sm:flex-row">
                        <div class="flex w-full flex-col">
                            <x-ui.form-label required>Enrollment Status:</x-ui.form-label>
                            <select name="enrollment_status" class="select w-full validator" required>
                                <option disabled selected value="">Select an enrollment status</option>
                                <option value="Enrolled">Enrolled</option>
                                <option value="LOA">LOA</option>
                            </select>
                            <p class="validator-hint hidden">
                                Select a enrollment status
                            </p>
                        </div>

                        <div class="flex w-full flex-col">
                            <x-ui.form-label class="mb-1" required>Expected Graduation Year:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="graduation_year"  x-model="graduationYear" @input="graduationYear = sanitizeGraduationYear($event.target.value)" placeholder="e.g. 2023" maxlength="4" required />
                            <p class="validator-hint hidden">
                                Format: YYYY (e.g. 2022)
                            </p>
                        </div>
                    </div>

                    <x-ui.form-label class="mb-1">First choice:</x-ui.form-label>
                    <x-ui.form-input class="validator" type="text" name="first_choice" placeholder="Course" x-model="first_choice" @input="first_choice = sanitizeInput(first_choice)" />

                    <x-ui.form-label class="mb-1">Second choice:</x-ui.form-label>
                    <x-ui.form-input class="validator" type="text" name="second_choice" placeholder="Course" x-model="second_choice" @input="second_choice = sanitizeInput(second_choice)" />
                </fieldset>
            </div>
        </div>

        <div x-cloak class="alert alert-vertical sm:alert-horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="font-bold">Complete Account</h3>
                <div class="text-xs">This will complete your account setup and allow you to use the system. Make sure all required information is filled out. Please review your details before proceeding.</div>
            </div>
            <x-ui.button 
                type="submit" 
                variant="outline"
                color="success" 
                size="sm"
                x-bind:disabled="submitting"                  
            >
                <span x-show="!submitting">Complete</span>
                <span x-show="submitting" style="display: none">Processing <span class="loading loading-dots loading-xs"></span></span>
            </x-ui.button>
        </div>
    </form>
</main>