<x-layout.client title="Profile">
    <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">

        <x-layout.client.client-navbar page="Profile"></x-layout.client.client-navbar>

        @php
            $client = Auth::user();
            $initials = $client ? strtoupper(substr($client->first_name, 0, 1)) . strtoupper(substr($client->last_name, 0, 1)) : 'AD';
        @endphp
        
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
        
        <div class="flex justify-between flex-col lg:flex-row gap-2 font-outfit">
            <div class="flex flex-col gap-y-4 w-full">
                <!-- Profile Section -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex justify-center sm:justify-between shadow-sm rounded-sm p-5">
                    <div class="flex items-center justify-center gap-5">
                        @if ($client->status === 'Online')
                            <div class="avatar avatar-online avatar-placeholder">
                                <div class="bg-neutral text-neutral-content w-24 rounded-full">
                                    <span class="text-3xl">{{ $initials }}</span>
                                </div>
                            </div>
                        @elseif ($client->status === 'Offline')
                            <div class="avatar avatar-placeholder">
                                <div class="bg-neutral text-neutral-content w-24 rounded-full">
                                    <span class="text-3xl">{{ $initials }}</span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="flex flex-col">
                            <span class="text-sm mb-1">{{ $client->first_name . ' ' . $client->last_name ?? 'N/A' }}</span>
                            @if ($client->status === 'Online')
                                <x-ui.badge color="success" size="sm">{{ $client->status ??  'Unknown'}}</x-ui.badge>
                            @elseif ($client->status === 'Offline')
                                <x-ui.badge color="error" size="sm">{{ $client->status ??  'Unknown'}}</x-ui.badge>
                            @elseif ($client->status === 'Disabled')
                                <x-ui.badge color="warning" size="sm">{{ $client->status ??  'Unknown'}}</x-ui.badge>
                            @endif
                        </div>
                    </div>
                    <div class="hidden sm:flex sm:justify-center sm:items-center sm:p-3">
                        <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="hidden sm:flex" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
                    </div>
                </div>

                <!-- Personal Information -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
                    <h1 class="font-medium text-md">Personal Information</h1>
                    <div class="flex flex-col md:flex-row">
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">First name</label>
                                <p class="text-sm">{{ $client->first_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Last name</label>
                                <p class="text-sm">{{ $client->last_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Email address</label>
                                <p class="text-sm">{{ $client->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Sex</label>
                                <p class="text-sm">{{ $client->sex ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Work Experience</label>
                                <p class="text-sm">{{ $client->work_experience ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">Age</label>
                                <p class="text-sm">{{ $client->age ?? 0 }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Civil Status</label>
                                <p class="text-sm">{{ $client->civil_status ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Dream</label>
                                <p class="text-sm">{{ $client->dream ?? 'Guest Dream' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Freelance</label>
                                <p class="text-sm">{{ $client->freelance ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
                    <h1 class="font-medium text-md">Academic Information</h1>
                    <div class="flex flex-col md:flex-row">
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">Student ID</label>
                                <p class="text-sm">{{ $client->student_id ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Program</label>
                                <p class="text-sm">{{ $client->program ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Year Level</label>
                                <p class="text-sm">{{ $client->year_level ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Section</label>
                                <p class="text-sm">{{ $client->section ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">First Choice</label>
                                <p class="text-sm">{{ $client->first_choice ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">OJT Experience</label>
                                <p class="text-sm">{{ $client->OJT ? 'Yes' : 'No' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Member of Organization</label>
                                <p class="text-sm">{{ $client->member_of_organization ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">Enrollment Status</label>
                                <p class="text-sm">{{ $client->enrollment_status ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Academic Standing</label>
                                <p class="text-sm">{{ $client->academic_standing ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Batch Year</label>
                                <p class="text-sm">{{ $client->batch_year ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Expected Graduation Year</label>
                                <p class="text-sm">{{ $client->graduation_year ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Second Choice</label>
                                <p class="text-sm">{{ $client->second_choice ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">CGPA</label>
                                <p class="text-sm">{{ $client->CPGA ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Leadership Experience</label>
                                <p class="text-sm">{{ $client->leadership_experience ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="block sm:hidden mt-2" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
        </div>

        <div x-cloak class="alert alert-vertical sm:alert-horizontal">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h3 class="font-bold">Delete Account</h3>
                <div class="text-xs">This action will permanently delete your account, including all your data and progress. This cannot be undone.</div>
            </div>
            <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="error"
                size="sm" onclick="my_modal_2.showModal()">Delete</x-ui.button>
        </div>

        <dialog id="my_modal_1" class="modal">
            <div class="modal-box max-w-3xl font-outfit">
                <form class="flex flex-col gap-2" method="POST" action="{{ route('dashboard.settings.profile.update') }}"
                    x-data="{ 
                        submitting: false, 
                        firstName: '{{ $client->first_name }}', 
                        lastName: '{{ $client->last_name }}', 

                        sanitizeName(input) { 
                            return input.replace(/[^a-zA-ZñÑ\s.'-]/g, ''); 
                        },

                        age: '{{ $client->age }}',
                        sanitizeAge(input) {
                            return input.replace(/[^0-9]/g, '');
                        },

                        dream: '{{ $client->dream }}',
                        first_choice: '{{ $client->first_choice }}',
                        second_choice: '{{ $client->second_choice }}',
                        sanitizeInput(input) {
                            return input.replace(/[^a-zA-ZñÑ\s]/g, ''); 
                        },

                        studentId: '{{ $client->student_id }}',
                        sanitizeStudentId(input) {
                            input = input.replace(/[^0-9]/g, '');
                            if (input.length > 2) {
                                input = input.slice(0, 2) + '-' + input.slice(2);
                            }
                            return input.slice(0, 8);
                        },

                        section: '{{ $client->section }}',
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
                        
                        batchYear: '{{ $client->batch_year }}',
                        sanitizeBatchYear(input) {
                            input = input.replace(/[^0-9]/g, '');

                            if (input.length > 4) {
                                input = input.slice(0, 4) + '-' + input.slice(4);
                            }

                            input = input.slice(0, 9);
                            
                            // Validate that first year is 2022 or later
                            if (input.length >= 4) {
                                const firstYear = parseInt(input.slice(0, 4));
                                
                                // If less than 2022, reset to 2022
                                if (firstYear < 2022) {
                                    input = '2022';
                                }
                                
                                // Optional: Prevent future years beyond current year
                                const currentYear = new Date().getFullYear();
                                if (firstYear > currentYear) {
                                    input = currentYear.toString();
                                }
                                
                                // Optional: Validate second year is firstYear + 1
                                if (input.length === 9) {
                                    const secondYear = parseInt(input.slice(5, 9));
                                    const expectedSecondYear = firstYear + 1;
                                    if (secondYear !== expectedSecondYear) {
                                        input = input.slice(0, 5) + expectedSecondYear;
                                    }
                                }
                            }
                            
                            return input;
                        },

                        graduationYear: '{{ $client->graduation_year }}',
                        sanitizeGraduationYear(input) {
                            input = input.replace(/[^0-9]/g, '');

                            return input.slice(0, 4);
                        }
                    }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')
                    
                    {{-- Personal Information --}}
                    <div class="w-full">
                        <h1 class="text-md font-medium">Personal Information</h1>
                        <fieldset class="fieldset">
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

                            {{-- Sex --}}
                            <x-ui.form-label required>Sex:</x-ui.form-label>
                            <select name="sex" class="select w-full validator" required>
                                <option disabled selected value="">Select a sex</option>
                                <option value="Male" {{ $client->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $client->sex == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>

                            {{-- Age --}}
                            <x-ui.form-label required>Age:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="age" placeholder="e.g 17" x-model="age" @input="age = sanitizeAge($event.target.value)" maxlength="3" required />

                            {{-- Civil Status --}}  
                            <x-ui.form-label required>Civil Status:</x-ui.form-label>
                            <select name="civil_status" class="select w-full validator" required>
                                <option disabled selected value="">Select a civil status</option>
                                <option value="Single" {{ $client->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ $client->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ $client->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Separated" {{ $client->civil_status == 'Separated' ? 'selected' : '' }}>Separated</option>
                                <option value="Annulled" {{ $client->civil_status == 'Annulled' ? 'selected' : '' }}>Annulled</option>
                            </select>

                            <x-ui.form-label class="mb-1">What career do you aspire to pursue?</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="dream" placeholder="Career goal" x-model="dream" @input="dream = sanitizeInput($event.target.value)" />
                            <p class="validator-hint hidden">
                                Tell us about your career goal.                    
                            </p>
                        </fieldset>
                    </div>

                    {{-- Academic Information --}}
                    <div class="w-full">
                        <h1 class="text-md font-medium">Academic Information</h1>
                        <fieldset class="fieldset">

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

                                <!-- Section -->
                                <div class="flex w-full flex-col">
                                    <x-ui.form-label class="mb-1" required>Section:</x-ui.form-label>
                                    <x-ui.form-input class="validator" type="text" name="section" x-model="section" @input="section = sanitizeSection($event.target.value)" placeholder="e.g. BSIT-4B" maxlength="15" required />
                                    <p class="validator-hint hidden">
                                        Format: Program-Section (e.g. BSIT-4B)
                                    </p>
                                </div>
                            </div>

                            {{-- Year Level & Batch Year --}}
                            <div class="flex w-full flex-col gap-x-5 gap-y-2 sm:flex-row">
                                <!-- Year Level -->
                                <div class="flex w-full flex-col">
                                    <x-ui.form-label class="mb-1" required>Year Level</x-ui.form-label>
                                    <select name="year_level" class="select w-full validator" required>
                                        <option disabled selected value="">Select a year level</option>
                                        <option value="1st Year" {{ $client->year_level == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                        <option value="2nd Year" {{ $client->year_level == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                        <option value="3rd Year" {{ $client->year_level == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                        <option value="4th Year" {{ $client->year_level == '4th Year' ? 'selected' : '' }}>4th Year</option>
                                    </select>
                                </div>

                                <!-- School Year -->
                                <div class="flex w-full flex-col">
                                    <x-ui.form-label class="mb-1" required>Batch Year:</x-ui.form-label>
                                    <x-ui.form-input class="validator" type="text" name="batch_year"  x-model="batchYear" @input="batchYear = sanitizeBatchYear($event.target.value)" placeholder="e.g. 2022-2023" maxlength="9" required />
                                    <p class="validator-hint hidden">
                                        Format: YYYY-YYYY (e.g. 2022-2023)
                                    </p>
                                </div>
                            </div>

                            <x-ui.form-label class="mb-1" required>Expected Graduation Year:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="graduation_year"  x-model="graduationYear" @input="graduationYear = sanitizeGraduationYear($event.target.value)" placeholder="e.g. 2023" maxlength="4" required />
                            <p class="validator-hint hidden">
                                Format: YYYY (e.g. 2022)
                            </p>

                            <x-ui.form-label class="mb-1">First choice:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="first_choice" placeholder="Course" x-model="first_choice" @input="first_choice = sanitizeInput($event.target.value)" />

                            <x-ui.form-label class="mb-1">Second choice:</x-ui.form-label>
                            <x-ui.form-input class="validator" type="text" name="second_choice" placeholder="Course" x-model="second_choice" @input="second_choice = sanitizeInput($event.target.value)" />
                        </fieldset>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-5">
                        <x-ui.button 
                            type="submit" 
                            color="info" 
                            size="sm"
                            x-bind:disabled="submitting"
                        >
                            <span x-show="!submitting">Update</span>
                            <span x-show="submitting" style="display: none">Updating <span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        {{-- Delete Account --}}
        <dialog id="my_modal_2" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-error mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Are you sure?</h3>
                </div>
                <form method="POST" action="/dashboard/settings/profile/{{ $client->id }}/delete" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('DELETE')

                    <fieldset class="fieldset">

                        <p class="text-sm text-justify mb-2">Are you sure you want to delete this account? Please proceed with caution, this cannot be undone.</p>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-ui.button 
                                type="submit" 
                                variant="outline"
                                color="error" 
                                size="sm"
                                x-bind:disabled="submitting"                  
                            >
                                <span x-show="!submitting">Delete</span>
                                <span x-show="submitting" style="display: none">Deleting <span class="loading loading-dots loading-xs"></span></span>
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
</x-layout.client>
