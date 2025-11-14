<x-layout.app title="Client">
    <x-layout.admin.admin-sidebar></x-layout.admin.admin-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]" x-data="adminTable()" x-init="init()">
        <x-layout.admin.admin-navbar page="Client"></x-layout.admin.admin-navbar>
        
        {{-- Get the initials of admins --}}
        @php
            $initials = $client ? strtoupper(substr($client->first_name, 0, 1)) . strtoupper(substr($client->last_name, 0, 1)) : 'CL';
        @endphp

        {{-- Success message --}}
         @if (session('success'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
            </div>
        @endif

        {{-- Display the disable  --}}
        @if (session('disabled'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="warning" message="{{ session('disabled') }}" class="mb-3" />
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

        <div class="flex justify-between flex-col xl:flex-row gap-2 font-outfit">
            <div class="flex flex-col gap-y-2 w-full">

                {{-- Admin Profile --}}
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="reveal flex justify-center sm:justify-between rounded-sm shadow-sm p-5">
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
                        @elseif ($client->status === 'Disabled')
                            <div class="avatar avatar-placeholder">
                                <div class="bg-neutral text-neutral-content w-24 rounded-full">
                                    <span class="text-3xl">{{ $initials }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-sm mb-1">{{ $client->first_name . ' ' . $client->last_name ?? 'Guest client' }}</span>
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

                {{-- Display Client Information --}}
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="reveal flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
                    <h1 class="font-medium text-md">Personal Information</h1>
                    <div class="flex flex-col md:flex-row">
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">ID</label>
                                <p class="text-sm">{{ $client->id ?? 'N/A' }}</p>
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
                                <p class="text-sm">{{ $client->dream ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Freelance</label>
                                <p class="text-sm">{{ $client->freelance ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Account Settings and Action Field --}}
            <div class="flex flex-col justify-center gap-2 w-full">
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="reveal flex flex-col gap-y-2 rounded-sm shadow-sm p-5 h-full">
                    <h1 class="font-medium text-2xl text-center sm:text-start">Account Settings</h1>
                    <button class="btn bg-base-100 hover:bg-base-200 w-full h-[50px]" onclick="my_modal_5.showModal()">What can you do here?</button>
                    <button class="btn bg-base-100 hover:bg-base-200 w-full h-[50px]" onclick="my_modal_6.showModal()">How does each button work?</button>
                </div>
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="reveal flex flex-col gap-2 rounded-sm shadow-sm h-full p-5">
                    <h1 class="font-medium text-lg">Action Button</h1>
                    <span class="text-sm text-gray-600">Note: Review the account settings.</span>
                    <div class="flex flex-col flex-wrap md:flex-row items-center gap-2">
                        <x-ui.button @click="window.history.back()" x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full lg:w-18" color="info">Back</x-ui.button>                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full md:hidden" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full lg:w-18" color="success" onclick="my_modal_2.showModal()">Activate</x-ui.button>
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full lg:w-18" color="warning" onclick="my_modal_3.showModal()">Disable</x-ui.button>
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="w-full lg:w-18" color="error" onclick="my_modal_4.showModal()">Delete</x-ui.button>                    
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
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

        <!-- Soft Skills Average & Hard Skill Average -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
            class="reveal stats font-outfit shadow-sm rounded-sm w-full">
            <!-- Soft Skills -->
            <div class="stat">
                <div class="stat-figure {{ $client->soft_skill_ave < 50 ? 'text-error' : ($client->soft_skill_ave < 60 ? 'text-warning' : ($client->soft_skill_ave < 75 ? 'text-info' : ($client->soft_skill_ave < 90 ? 'text-success' : 'text-success'))) }}">
                    <x-heroicon-o-chart-bar class="w-8 h-8" />
                </div>
                <div class="stat-title">Soft Skills</div>
                <div class="stat-value {{ $client->soft_skill_ave < 50 ? 'text-error' : ($client->soft_skill_ave < 60 ? 'text-warning' : ($client->soft_skill_ave < 75 ? 'text-info' : ($client->soft_skill_ave < 90 ? 'text-success' : 'text-success'))) }}">{{ $client->soft_skill_ave ?? 0 }}%</div>
                <div class="stat-desc">Skills related to communication, attitude, and behavior.</div>
            </div>

            <!-- Hard Skills -->
            @if ($client->program === 'BSHM')
                <div class="stat">
                    <div class="stat-figure {{ $client->hard_skill_ave < 50 ? 'text-error' : ($client->hard_skill_ave < 60 ? 'text-warning' : ($client->hard_skill_ave < 75 ? 'text-info' : ($client->hard_skill_ave < 90 ? 'text-success' : 'text-success'))) }}">
                        <x-heroicon-o-chart-bar class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Hard Skills</div>
                    <div class="stat-value {{ $client->hard_skill_ave < 50 ? 'text-error' : ($client->hard_skill_ave < 60 ? 'text-warning' : ($client->hard_skill_ave < 75 ? 'text-info' : ($client->hard_skill_ave < 90 ? 'text-success' : 'text-success'))) }}">{{ $client->hard_skill_ave ?? 0 }}%</div>
                    <div class="stat-desc">Skills related to hospitality knowledge and practical abilities.</div>
                </div>
            @else
                <div class="stat">
                    <div class="stat-figure {{ $client->hard_skill_ave < 50 ? 'text-error' : ($client->hard_skill_ave < 60 ? 'text-warning' : ($client->hard_skill_ave < 75 ? 'text-info' : ($client->hard_skill_ave < 90 ? 'text-success' : 'text-success'))) }}">
                        <x-heroicon-o-chart-bar class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Hard Skills</div>
                    <div class="stat-value {{ $client->hard_skill_ave < 50 ? 'text-error' : ($client->hard_skill_ave < 60 ? 'text-warning' : ($client->hard_skill_ave < 75 ? 'text-info' : ($client->hard_skill_ave < 90 ? 'text-success' : 'text-success'))) }}">{{ $client->hard_skill_ave ?? 0  }}%</div>
                    <div class="stat-desc">Skills related to technical knowledge and practical abilities.</div>
                </div>
            @endif
        </div>

        @php
            $score_openness = $client->openness_ave;
            $score_conscientiousness = $client->conscientiousness_ave;
            $score_extraversion = $client->extraversion_ave;
            $score_agreeableness = $client->agreeableness_ave;
            $score_neuroticism = $client->neuroticism_ave;

            $percent_openness = ($score_openness / 5) * 100;
            $percent_conscientiousness = ($score_conscientiousness / 5) * 100;
            $percent_extraversion = ($score_extraversion / 5) * 100;
            $percent_agreeableness = ($score_agreeableness / 5) * 100;
            $percent_neuroticism = ($score_neuroticism / 5) * 100;
        @endphp

         {{-- Personality Test Score & Convertion --}}
        <div class="flex flex-col gap-y-4 xl:flex-row xl:gap-x-2">
            <!-- Five Personality Traits (Left Side) -->
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-5 w-full shadow-sm rounded-sm flex flex-col">
                <h1 class="mb-4 font-medium flex items-center gap-2">
                    <x-heroicon-o-presentation-chart-line class="w-5 h-5" />
                    Five Personality Traits
                </h1>

                <div class="flex flex-col gap-4 flex-1">
                    <!-- Openness -->
                    <x-layout.client.client-personality-score
                        traits="Openness" 
                        meaning="Measures a person's creativity, curiosity, and willingness to try new things and entertain new ideas."
                        percent="{{ $percent_openness }}"
                        score="{{ $client->openness_ave }}"
                    />

                    <!-- Conscientiousness -->
                    <x-layout.client.client-personality-score
                        traits="Conscientiousness" 
                        meaning="Describes how organized, diligent, and self-controlled a person is."
                        percent="{{ $percent_conscientiousness }}"
                        score="{{ $client->conscientiousness_ave }}"
                    />

                    <!-- Extraversion -->
                    <x-layout.client.client-personality-score
                        traits="Extraversion" 
                        meaning="Refers to a person's boldness, energy level, and sociability."
                        percent="{{ $percent_extraversion }}"
                        score="{{ $client->extraversion_ave }}"
                    />

                    <!-- Agreeableness -->
                    <x-layout.client.client-personality-score
                        traits="Agreeableness" 
                        meaning="Indicates how kind, cooperative, and helpful a person is."
                        percent="{{ $percent_agreeableness }}"
                        score="{{ $client->agreeableness_ave }}"
                    />

                    <!-- Neuroticism -->
                    <x-layout.client.client-personality-score
                        traits="Neuroticism" 
                        meaning="Measures a person's tendency to experience negative emotions such as anxiety, depression, and moodiness."
                        percent="{{ $percent_neuroticism }}"
                        score="{{ $client->neuroticism_ave }}"
                    />
                </div>
            </div>

            <!-- Traits Descriptions (Right Side) -->
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-5 w-full shadow-sm rounded-sm flex flex-col">
                <h1 class="mb-4 font-medium flex items-center gap-2">
                    <x-heroicon-o-presentation-chart-line class="w-5 h-5" />
                    Traits Description
                </h1>

                <div class="flex flex-col gap-4 flex-1 justify-between">
                    <!-- Openness -->
                    <x-layout.client.client-personality-convert
                        traits="Openness"
                        score="{{ $client->openness_ave }}"
                        convertion="{{ implode(', ', $client->openness_result ?? []) }}"
                    />

                    <!-- Conscientiousness -->
                    <x-layout.client.client-personality-convert
                        traits="Conscientiousness"
                        score="{{ $client->conscientiousness_ave }}"
                        convertion="{{ implode(', ', $client->conscientiousness_result ?? []) }}"
                    />

                    <!-- Extraversion -->
                    <x-layout.client.client-personality-convert
                        traits="Extraversion"
                        score="{{ $client->extraversion_ave }}"
                        convertion="{{ implode(', ', $client->extraversion_result ?? []) }}"
                    />

                    <!-- Agreeableness -->
                    <x-layout.client.client-personality-convert
                        traits="Agreeableness"
                        score="{{ $client->agreeableness_ave }}"
                        convertion="{{ implode(', ', $client->agreeableness_result ?? []) }}"
                    />

                    <!-- Neuroticism -->
                    <x-layout.client.client-personality-convert
                        traits="Neuroticism"
                        score="{{ $client->neuroticism_ave }}"
                        convertion="{{ implode(', ', $client->neuroticism_result ?? []) }}"
                    />
                </div>
            </div>
        </div>

        {{-- Hard Skills --}}
        @php
            $skills = [
                // Left Column
                'left' => [
                    ['label' => 'Programming', 'field' => 'programming'],
                    ['label' => 'Algorithms', 'field' => 'algorithms'],
                    ['label' => 'Software Design', 'field' => 'software_design'],
                    ['label' => 'Debugging', 'field' => 'debugging'],
                    ['label' => 'Testing', 'field' => 'testing'],
                    ['label' => 'Web Development', 'field' => 'web_development'],
                    ['label' => 'App Development', 'field' => 'app_development'],
                    ['label' => 'UI/UX', 'field' => 'ui_ux'],
                    ['label' => 'Scripting', 'field' => 'scripting'],
                    ['label' => 'Middleware', 'field' => 'middleware'],
                    ['label' => 'Scalability', 'field' => 'scalability'],
                    ['label' => 'Performance Optimization', 'field' => 'performance_optimization'],
                    ['label' => 'Operating Systems', 'field' => 'operating_systems'],
                    ['label' => 'System Administration', 'field' => 'system_administration'],
                    ['label' => 'Networking', 'field' => 'networking'],
                    ['label' => 'Troubleshooting', 'field' => 'troubleshooting'],
                    ['label' => 'Virtualization', 'field' => 'virtualization'],
                    ['label' => 'Security', 'field' => 'security'],
                ],
                // Right Column
                'right' => [
                    ['label' => 'Monitoring', 'field' => 'monitoring'],
                    ['label' => 'Cybersecurity', 'field' => 'cybersecurity'],
                    ['label' => 'Access Control', 'field' => 'access_control'],
                    ['label' => 'Database', 'field' => 'database'],
                    ['label' => 'Data Analysis', 'field' => 'data_analysis'],
                    ['label' => 'Statistics', 'field' => 'statistics'],
                    ['label' => 'Query Optimization', 'field' => 'query_optimization'],
                    ['label' => 'Research', 'field' => 'research'],
                    ['label' => 'Backup & Recovery', 'field' => 'backup_and_recovery'],
                    ['label' => 'IT Audit', 'field' => 'it_audit'],
                    ['label' => 'Risk Assessment', 'field' => 'risk_assessment'],
                    ['label' => 'Compliance', 'field' => 'compliance'],
                    ['label' => 'Ethics', 'field' => 'ethics'],
                    ['label' => 'Quality Assurance', 'field' => 'quality_assurance'],
                    ['label' => 'Bug Tracking', 'field' => 'bug_tracking'],
                    ['label' => 'Maintenance', 'field' => 'maintenance'],
                    ['label' => 'User Support', 'field' => 'user_support'],
                    ['label' => 'Help Desk', 'field' => 'help_desk'],
                ],
            ];
            
            $allSkills = array_merge($skills['left'], $skills['right']);
        @endphp

        @php
            $hmSkills = [
                // Left Column
                'left' => [
                    ['label' => 'POS Operation', 'field' => 'pos_operation'],
                    ['label' => 'Basic Accounting', 'field' => 'basic_accounting'],
                    ['label' => 'Accuracy & Attention to Detail', 'field' => 'accuracy_and_attention_to_detail'],
                    ['label' => 'Sales Reporting', 'field' => 'sales_reporting'],
                    ['label' => 'Customer Service', 'field' => 'customer_service'],
                    ['label' => 'Order Taking', 'field' => 'order_taking'],
                    ['label' => 'Tray Service', 'field' => 'tray_service'],
                    ['label' => 'Service Etiquette', 'field' => 'service_etiquette'],
                    ['label' => 'Table Setting', 'field' => 'table_setting'],
                    ['label' => 'Hygiene & Sanitation', 'field' => 'hygiene_and_sanitation'],
                    ['label' => 'Mixology', 'field' => 'mixology'],
                    ['label' => 'Beverage Preparation', 'field' => 'beverage_preparation'],
                    ['label' => 'Recipe Knowledge', 'field' => 'recipe_knowledge'],
                    ['label' => 'Coffee Preparation', 'field' => 'coffee_preparation'],
                    ['label' => 'Latte Art', 'field' => 'latte_art'],
                    ['label' => 'Inventory Control', 'field' => 'inventory_control'],
                    ['label' => 'Scheduling', 'field' => 'scheduling'],
                    ['label' => 'Reporting', 'field' => 'reporting'],
                    ['label' => 'Service Protocol', 'field' => 'service_protocol'],
                    ['label' => 'Basic Food Preparation', 'field' => 'basic_food_preparation'],
                    ['label' => 'Kitchen Hygiene', 'field' => 'kitchen_hygiene'],
                    ['label' => 'Recipe Execution', 'field' => 'recipe_execution'],
                    ['label' => 'Timing & Coordination', 'field' => 'timing_and_coordination'],
                    ['label' => 'Food Safety', 'field' => 'food_safety'],
                    ['label' => 'Fast-Paced Cooking', 'field' => 'fast_paced_cooking'],
                    ['label' => 'Station Management', 'field' => 'station_management'],
                    ['label' => 'Pastry & Dessert Preparation', 'field' => 'pastry_and_dessert_preparation'],
                    ['label' => 'Decoration & Presentation', 'field' => 'decoration_and_presentation'],
                    ['label' => 'Oven Operation', 'field' => 'oven_operation'],
                    ['label' => 'Kitchen Operations Management', 'field' => 'kitchen_operations_management'],
                    ['label' => 'Menu Execution', 'field' => 'menu_execution'],

                ],
                // Right Column
                'right' => [
                    ['label' => 'Prep Planning', 'field' => 'prep_planning'],
                    ['label' => 'Menu Planning', 'field' => 'menu_planning'],
                    ['label' => 'Kitchen Leadership', 'field' => 'kitchen_leadership'],
                    ['label' => 'HACCP', 'field' => 'haccp'],
                    ['label' => 'Strategic Planning', 'field' => 'strategic_planning'],
                    ['label' => 'Bed Making', 'field' => 'bed_making'],
                    ['label' => 'Room Cleaning', 'field' => 'room_cleaning'],
                    ['label' => 'Housekeeping Procedures', 'field' => 'housekeeping_procedures'],
                    ['label' => 'Sanitation', 'field' => 'sanitation'],
                    ['label' => 'Inspection & Quality Control', 'field' => 'inspection_and_quality_control'],
                    ['label' => 'Equipment Handling', 'field' => 'equipment_handling'],
                    ['label' => 'Check-In & Check-Out Procedures', 'field' => 'check_in_and_check_out_procedures'],
                    ['label' => 'Booking Systems', 'field' => 'booking_systems'],
                    ['label' => 'Record Keeping', 'field' => 'record_keeping'],
                    ['label' => 'Call Handling', 'field' => 'call_handling'],
                    ['label' => 'Guest Assistance', 'field' => 'guest_assistance'],
                    ['label' => 'Local Knowledge', 'field' => 'local_knowledge'],
                    ['label' => 'Yield Management', 'field' => 'yield_management'],
                    ['label' => 'Team Supervision', 'field' => 'team_supervision'],
                    ['label' => 'Operations Management', 'field' => 'operations_management'],
                    ['label' => 'Sales Systems', 'field' => 'sales_systems'],
                    ['label' => 'Telemarketing', 'field' => 'telemarketing'],
                    ['label' => 'Client Handling', 'field' => 'client_handling'],
                    ['label' => 'Event Planning', 'field' => 'event_planning'],
                    ['label' => 'Event Coordination', 'field' => 'event_coordination'],
                    ['label' => 'Event Logistics', 'field' => 'event_logistics'],
                    ['label' => 'Scheduling Events & Marketing', 'field' => 'scheduling_events_and_marketing'],
                    ['label' => 'Marketing Systems', 'field' => 'marketing_systems'],
                    ['label' => 'Branding Tools', 'field' => 'branding_tools'],
                    ['label' => 'Campaign Planning', 'field' => 'campaign_planning'],
                    ['label' => 'Reporting & Documentation', 'field' => 'reporting_and_documentation'],
                ],
            ];
            
            $hmAllSkills = array_merge($hmSkills['left'], $hmSkills['right']);
        @endphp

        @if ($client->program === 'BSHM')
            <div x-cloak 
                x-data="{ 
                    search: '',
                    get hasMatchingSkills() {
                        if (this.search === '') return true;
                        const skills = [
                            'pos operation', 'basic accounting', 'accuracy & attention to detail', 'sales reporting',
                            'customer service', 'order taking', 'tray service', 'service etiquette', 'table setting',
                            'hygiene & sanitation', 'mixology', 'beverage preparation', 'recipe knowledge',
                            'coffee preparation', 'latte art', 'inventory control', 'scheduling', 'reporting',
                            'service protocol', 'basic food preparation', 'kitchen hygiene', 'recipe execution',
                            'timing & coordination', 'food safety', 'fast-paced cooking', 'station management',
                            'pastry & dessert preparation', 'decoration & presentation', 'oven operation',
                            'kitchen operations management', 'menu execution', 'prep planning', 'menu planning',
                            'kitchen leadership', 'haccp', 'strategic planning', 'bed making', 'room cleaning',
                            'housekeeping procedures', 'sanitation', 'inspection & quality control',
                            'equipment handling', 'check-in & check-out procedures', 'booking systems',
                            'record keeping', 'call handling', 'guest assistance', 'local knowledge',
                            'communication skills', 'yield management', 'team supervision', 'operations management',
                            'sales systems', 'telemarketing', 'client handling', 'event planning',
                            'event coordination', 'event logistics', 'scheduling events & marketing',
                            'marketing systems', 'branding tools', 'campaign planning', 'reporting & documentation'
                        ];
                        return skills.some(skill => skill.includes(this.search.toLowerCase()));
                    }
                }"
                :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                class="p-5 w-full shadow-sm rounded-sm flex flex-col">
                <div class="mb-4 flex items-center justify-between gap-4">
                    <h1 class="font-medium flex items-center gap-2">
                        <x-heroicon-o-building-office-2 class="w-5 h-5" />
                        Skills
                    </h1>
                    
                    <!-- Search Bar (smaller, on the right) -->
                    <div class="relative w-64">
                        <input 
                            x-model="search"
                            type="text" 
                            placeholder="Search skills..." 
                            class="input input-sm input-bordered w-full pl-8"
                        />
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-2.5 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div class="flex-1 max-h-[300px] overflow-y-auto pr-2">
                    <!-- Search Results (when searching) - FULL WIDTH -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-show="search !== '' && hasMatchingSkills">
                        @foreach($hmAllSkills as $skill)
                            <div x-show="'{{  strtolower($skill['label']) }}'.includes(search.toLowerCase())">
                                <x-layout.client.client-hard-skill 
                                    skill="{!! $skill['label'] !!}"
                                    percent="{{ round($client->{$skill['field']}) }}"
                                />
                            </div>
                        @endforeach
                    </div>

                    <!-- No Skills Found Message (centered in parent) -->
                    <div x-show="search !== '' && !hasMatchingSkills"
                        class="flex items-center justify-center h-full min-h-[400px]">
                        <div class="flex flex-col items-center gap-3 text-base-content/70">
                            <svg class="w-16 h-16 opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p class="text-base font-medium">No skills found</p>
                            <p class="text-sm opacity-70">Try a different search term</p>
                        </div>
                    </div>

                    <!-- Original Two Columns (when not searching) -->
                    <template x-if="search === ''">
                        <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="flex flex-col gap-4">
                                @foreach($hmSkills['left'] as $skill)
                                    <x-layout.client.client-hard-skill 
                                        skill="{!! $skill['label'] !!}"
                                        percent="{{ round($client->{$skill['field']}) }}"
                                    />
                                @endforeach
                            </div>

                            <!-- Right Column -->
                            <div class="flex flex-col gap-4">
                                @foreach($hmSkills['right'] as $skill)
                                    <x-layout.client.client-hard-skill 
                                        skill="{!! $skill['label'] !!}"
                                        percent="{{ round($client->{$skill['field']}) }}"
                                    />
                                @endforeach
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        @else
            <div x-cloak 
                x-data="{ 
                    search: '',
                    get hasMatchingSkills() {
                        if (this.search === '') return true;
                        const skills = [
                            'programming', 'algorithms', 'software design', 'debugging', 'testing',
                            'web development', 'app development', 'ui/ux', 'scripting', 'middleware',
                            'scalability', 'performance optimization', 'operating systems', 'system administration',
                            'networking', 'troubleshooting', 'virtualization', 'security', 'monitoring',
                            'cybersecurity', 'access control', 'database', 'data analysis', 'statistics',
                            'query optimization', 'research', 'backup & recovery', 'it audit',
                            'risk assessment', 'compliance', 'ethics', 'quality assurance', 'bug tracking',
                            'maintenance', 'user support', 'help desk'
                        ];
                        return skills.some(skill => skill.includes(this.search.toLowerCase()));
                    }
                }"
                :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                class="p-5 w-full shadow-sm rounded-sm flex flex-col">
                <div class="mb-4 flex items-center justify-between gap-4">
                    <h1 class="font-medium flex items-center gap-2">
                        <x-heroicon-o-code-bracket class="w-5 h-5" />
                        Skills
                    </h1>
                    
                    <!-- Search Bar (smaller, on the right) -->
                    <div class="relative w-64">
                        <input 
                            x-model="search"
                            type="text" 
                            placeholder="Search skills..." 
                            class="input input-sm input-bordered w-full pl-8"
                        />
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-2.5 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div class="flex-1 max-h-[300px] overflow-y-auto pr-2">
                    <!-- Search Results (when searching) - FULL WIDTH -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-show="search !== '' && hasMatchingSkills">
                        @foreach($allSkills as $skill)
                            <div x-show="'{{ strtolower($skill['label']) }}'.includes(search.toLowerCase())">
                                <x-layout.client.client-hard-skill 
                                    skill="{!! $skill['label'] !!}"
                                    percent="{{ round($client->{$skill['field']}) }}"
                                />
                            </div>
                        @endforeach
                    </div>

                    <!-- No Skills Found Message (centered in parent) -->
                    <div x-show="search !== '' && !hasMatchingSkills"
                        class="flex items-center justify-center h-full min-h-[400px]">
                        <div class="flex flex-col items-center gap-3 text-base-content/70">
                            <svg class="w-16 h-16 opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p class="text-base font-medium">No skills found</p>
                            <p class="text-sm opacity-70">Try a different search term</p>
                        </div>
                    </div>

                    <!-- Original Two Columns (when not searching) -->
                    <template x-if="search === ''">
                        <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="flex flex-col gap-4">
                                @foreach($skills['left'] as $skill)
                                    <x-layout.client.client-hard-skill 
                                        skill="{!! $skill['label'] !!}"
                                        percent="{{ round($client->{$skill['field']}) }}"
                                    />
                                @endforeach
                            </div>

                            <!-- Right Column -->
                            <div class="flex flex-col gap-4">
                                @foreach($skills['right'] as $skill)
                                    <x-layout.client.client-hard-skill 
                                        skill="{!! $skill['label'] !!}"
                                        percent="{{ round($client->{$skill['field']}) }}"
                                    />
                                @endforeach
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        @endif

        {{-- Job Recommendation Standardization --}}
        <div class="flex flex-col xl:flex-row gap-2">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="stats shadow w-full">
                <div class="stat text-success">
                    <div class="stat-figure">
                        <x-heroicon-o-briefcase class="w-8 h-8" />
                    </div>
                    <div class="stat-title">High Match</div>
                    <div class="stat-value">75% - 100%</div>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"class="stats shadow w-full">
                <div class="stat text-warning">
                    <div class="stat-figure">
                        <x-heroicon-o-briefcase class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Good Match</div>
                    <div class="stat-value">50% - 74%</div>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="stats shadow w-full">
                <div class="stat text-error">
                    <div class="stat-figure">
                        <x-heroicon-o-briefcase class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Low Match</div>
                    <div class="stat-value">0% - 49%</div>
                </div>
            </div>
        </div>

        <div x-cloak 
            x-data="{ 
                jobSearch: '',
                get hasMatchingJobs() {
                    if (this.jobSearch === '') return true;
                    const jobs = [
                        'software engineer',
                        'system software developer',
                        'application software developer',
                        'research & development computing',
                        'computer programmer',
                        'web applications developer',
                        'system analyst',
                        'data analyst',
                        'quality assurance specialist',
                        'software support specialist',
                        'technical support specialist',
                        'junior database administrator',
                        'system administrator',
                        'network engineer',
                        'junior information security administrator',
                        'system integration personnel',
                        'it audit assistant',
                        'cashier',
                        'waiter',
                        'bartender',
                        'barista',
                        'restaurant supervisor',
                        'commis chef',
                        'line cook',
                        'pastry chef',
                        'sous chef',
                        'head chef',
                        'room attendant',
                        'housekeeping attendant',
                        'floor supervisor',
                        'laundry supervisor',
                        'receptionist',
                        'front office attendant',
                        'concierge / crm',
                        'front office manager',
                        'sales representative',
                        'events planner',
                        'marketing manager'
                    ];
                    return jobs.some(job => job.includes(this.jobSearch.toLowerCase()));
                }
            }"
            :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
            class="flex w-full flex-col lg:flex-row shadow-sm p-4">

            @if ($client->program === 'BSHM')
                <div class="card rounded-box grid h-[300px] grow items-start justify-items-center overflow-hidden">
                    <ul x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                        class="list rounded-box shadow-md w-full h-full overflow-y-auto">

                        <li x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                            class="p-4 pb-2 sticky top-0 z-10">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-xs tracking-wide">Job Recommendation</span>
                                
                                <!-- Search Bar -->
                                <div class="relative w-48">
                                    <input 
                                        x-model="jobSearch"
                                        type="text" 
                                        placeholder="Search jobs..." 
                                        class="input input-xs input-bordered w-full pl-7 bg-base-100"
                                    />
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </li>

                        @php
                            $jobRecommendation = $client->job_recommendation_hm ?? null;
                            $isCompleted = $jobRecommendation?->is_job_completed ?? false;

                            $jobs = [
                                [
                                    'id' => '01',
                                    'title' => 'Cashier',
                                    'field' => 'cashier',
                                    'match_field' => 'cashier_match',
                                    'average_field' => 'cashier_average'
                                ],
                                [
                                    'id' => '02',
                                    'title' => 'Waiter',
                                    'field' => 'waiter',
                                    'match_field' => 'waiter_match',
                                    'average_field' => 'waiter_average'
                                ],
                                [
                                    'id' => '03',
                                    'title' => 'Bartender',
                                    'field' => 'bartender',
                                    'match_field' => 'bartender_match',
                                    'average_field' => 'bartender_average'
                                ],
                                [
                                    'id' => '04',
                                    'title' => 'Barista',
                                    'field' => 'barista',
                                    'match_field' => 'barista_match',
                                    'average_field' => 'barista_average'
                                ],
                                [
                                    'id' => '05',
                                    'title' => 'Restaurant Supervisor',
                                    'field' => 'restaurant_supervisor',
                                    'match_field' => 'restaurant_supervisor_match',
                                    'average_field' => 'restaurant_supervisor_average'
                                ],
                                [
                                    'id' => '06',
                                    'title' => 'Commis Chef',
                                    'field' => 'commis_chef',
                                    'match_field' => 'commis_chef_match',
                                    'average_field' => 'commis_chef_average'
                                ],
                                [
                                    'id' => '07',
                                    'title' => 'Line Cook',
                                    'field' => 'line_cook',
                                    'match_field' => 'line_cook_match',
                                    'average_field' => 'line_cook_average'
                                ],
                                [
                                    'id' => '08',
                                    'title' => 'Pastry Chef',
                                    'field' => 'pastry_chef',
                                    'match_field' => 'pastry_chef_match',
                                    'average_field' => 'pastry_chef_average'
                                ],
                                [
                                    'id' => '09',
                                    'title' => 'Sous Chef',
                                    'field' => 'sous_chef',
                                    'match_field' => 'sous_chef_match',
                                    'average_field' => 'sous_chef_average'
                                ],
                                [
                                    'id' => '10',
                                    'title' => 'Head Chef',
                                    'field' => 'head_chef',
                                    'match_field' => 'head_chef_match',
                                    'average_field' => 'head_chef_average'
                                ],
                                [
                                    'id' => '11',
                                    'title' => 'Room Attendant',
                                    'field' => 'room_attendant',
                                    'match_field' => 'room_attendant_match',
                                    'average_field' => 'room_attendant_average'
                                ],
                                [
                                    'id' => '12',
                                    'title' => 'Housekeeping Attendant',
                                    'field' => 'housekeeping_attendant',
                                    'match_field' => 'housekeeping_attendant_match',
                                    'average_field' => 'housekepping_attendant_average'
                                ],
                                [
                                    'id' => '13',
                                    'title' => 'Floor Supervisor',
                                    'field' => 'floor_supervisor',
                                    'match_field' => 'floor_supervisor_match',
                                    'average_field' => 'floor_supervisor_average'
                                ],
                                [
                                    'id' => '14',
                                    'title' => 'Laundry Supervisor',
                                    'field' => 'laundry_supervisor',
                                    'match_field' => 'laundry_supervisor_match',
                                    'average_field' => 'laundry_supervisor_average'
                                ],
                                [
                                    'id' => '15',
                                    'title' => 'Receptionist',
                                    'field' => 'receptionist',
                                    'match_field' => 'receptionist_match',
                                    'average_field' => 'receptionist_average'
                                ],
                                [
                                    'id' => '16',
                                    'title' => 'Front Office Attendant',
                                    'field' => 'front_office_attendant',
                                    'match_field' => 'front_office_attendant_match',
                                    'average_field' => 'front_office_attendant_average'
                                ],
                                [
                                    'id' => '17',
                                    'title' => 'Concierge',
                                    'field' => 'concierge',
                                    'match_field' => 'concierge_match',
                                    'average_field' => 'concierge_average'
                                ],
                                [
                                    'id' => '18',
                                    'title' => 'Front Office Manager',
                                    'field' => 'front_office_manager',
                                    'match_field' => 'front_office_manager_match',
                                    'average_field' => 'front_office_manager_average'
                                ],
                                [
                                    'id' => '19',
                                    'title' => 'Sales Representative',
                                    'field' => 'sales_representative',
                                    'match_field' => 'sales_representative_match',
                                    'average_field' => 'sales_representative_average'
                                ],
                                [
                                    'id' => '20',
                                    'title' => 'Events Planner',
                                    'field' => 'events_planner',
                                    'match_field' => 'events_planner_match',
                                    'average_field' => 'events_planner_average'
                                ],
                                [
                                    'id' => '21',
                                    'title' => 'Marketing Manager',
                                    'field' => 'marketing_manager',
                                    'match_field' => 'marketing_manager_match',
                                    'average_field' => 'marketing_manager_average'
                                ],
                            ];
                        @endphp

                        @if ($isCompleted && $jobRecommendation)
                            @foreach ($jobs as $job)
                                @php
                                    $titleValue = $jobRecommendation->{$job['field']} ?? 'N/A';
                                    $matchValue = $jobRecommendation->{$job['match_field']} ?? 0;
                                    $averageValue = $jobRecommendation->{$job['average_field']} ?? 0;
                                @endphp

                                <div x-show="jobSearch === '' || '{{ strtolower($job['title']) }}'.includes(jobSearch.toLowerCase())">
                                    <x-layout.admin.admin-client-job-recommendation
                                        id="{{ $job['id'] }}"
                                        title="{!! $titleValue !!}"
                                        match="{{ $matchValue }}"
                                        score="{{ $averageValue }}"
                                    />
                                </div>
                            @endforeach

                            <li x-show="jobSearch !== '' && !hasMatchingJobs"
                                class="p-4 text-center text-base-content/70">
                                <div class="flex flex-col items-center gap-2 py-8">
                                    <svg class="w-12 h-12 opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <p class="text-sm font-medium">No jobs found</p>
                                    <p class="text-xs opacity-70">Try a different search term</p>
                                </div>
                            </li>
                        @else
                            <li class="p-4 text-center text-base-content/70">
                                <div class="flex flex-col items-center gap-2 py-8">
                                    <svg class="w-12 h-12 opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm font-medium">No job recommendations available</p>
                                    <p class="text-xs opacity-70">Complete your career assessment to get recommendations</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            @else
                <div class="card rounded-box grid h-[300px] grow items-start justify-items-center overflow-hidden">
                    <ul x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                        class="list rounded-box shadow-md w-full h-full overflow-y-auto">

                        <li x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                            class="p-4 pb-2 sticky top-0 z-10">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-xs tracking-wide">Job Recommendation</span>
                                
                                <!-- Search Bar -->
                                <div class="relative w-48">
                                    <input 
                                        x-model="jobSearch"
                                        type="text" 
                                        placeholder="Search jobs..." 
                                        class="input input-xs input-bordered w-full pl-7 bg-base-100"
                                    />
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </li>

                        @php
                            $jobRecommendation = $client->job_recommendation ?? null;
                            $isCompleted = $jobRecommendation?->is_job_completed ?? false;

                            $jobs = [
                                [
                                    'id' => '01',
                                    'title' => 'Software Engineer',
                                    'field' => 'software_engineer',
                                    'match_field' => 'software_engineer_match',
                                    'average_field' => 'software_engineer_average'
                                ],
                                [
                                    'id' => '02',
                                    'title' => 'System Software Developer',
                                    'field' => 'systems_software_developer',
                                    'match_field' => 'systems_software_developer_match',
                                    'average_field' => 'systems_software_developer_average'
                                ],
                                [
                                    'id' => '03',
                                    'title' => 'Application Software Developer',
                                    'field' => 'applications_software_developer',
                                    'match_field' => 'applications_software_developer_match',
                                    'average_field' => 'applications_software_developer_average'
                                ],
                                [
                                    'id' => '04',
                                    'title' => 'Research & Development Computing',
                                    'field' => 'research_development_computing',
                                    'match_field' => 'research_development_computing_match',
                                    'average_field' => 'research_development_computing_average'
                                ],
                                [
                                    'id' => '05',
                                    'title' => 'Computer Programmer',
                                    'field' => 'computer_programmer',
                                    'match_field' => 'computer_programmer_match',
                                    'average_field' => 'computer_programmer_average'
                                ],
                                [
                                    'id' => '06',
                                    'title' => 'Web Applications Developer',
                                    'field' => 'web_applications_developer',
                                    'match_field' => 'web_applications_developer_match',
                                    'average_field' => 'web_applications_developer_average'
                                ],
                                [
                                    'id' => '07',
                                    'title' => 'System Analyst',
                                    'field' => 'systems_analyst',
                                    'match_field' => 'systems_analyst_match',
                                    'average_field' => 'systems_analyst_average'
                                ],
                                [
                                    'id' => '08',
                                    'title' => 'Data Analyst',
                                    'field' => 'data_analyst',
                                    'match_field' => 'data_analyst_match',
                                    'average_field' => 'data_analyst_average'
                                ],
                                [
                                    'id' => '09',
                                    'title' => 'Quality Assurance Specialist',
                                    'field' => 'quality_assurance_specialist',
                                    'match_field' => 'quality_assurance_specialist_match',
                                    'average_field' => 'quality_assurance_specialist_average'
                                ],
                                [
                                    'id' => '10',
                                    'title' => 'Software Support Specialist',
                                    'field' => 'software_support_specialist',
                                    'match_field' => 'software_support_specialist_match',
                                    'average_field' => 'software_support_specialist_average'
                                ],
                                [
                                    'id' => '11',
                                    'title' => 'Technical Support Specialist',
                                    'field' => 'technical_support_specialist',
                                    'match_field' => 'technical_support_specialist_match',
                                    'average_field' => 'technical_support_specialist_average'
                                ],
                                [
                                    'id' => '12',
                                    'title' => 'Junior Database Administrator',
                                    'field' => 'junior_database_administrator',
                                    'match_field' => 'junior_database_administrator_match',
                                    'average_field' => 'junior_database_administrator_average'
                                ],
                                [
                                    'id' => '13',
                                    'title' => 'System Administrator',
                                    'field' => 'systems_administrator',
                                    'match_field' => 'systems_administrator_match',
                                    'average_field' => 'systems_administrator_average'
                                ],
                                [
                                    'id' => '14',
                                    'title' => 'Network Engineer',
                                    'field' => 'network_engineer',
                                    'match_field' => 'network_engineer_match',
                                    'average_field' => 'network_engineer_average'
                                ],
                                [
                                    'id' => '15',
                                    'title' => 'Junior Information Security Administrator',
                                    'field' => 'junior_information_security_administrator',
                                    'match_field' => 'junior_information_security_administrator_match',
                                    'average_field' => 'junior_information_security_administrator_average'
                                ],
                                [
                                    'id' => '16',
                                    'title' => 'System Integration Personnel',
                                    'field' => 'systems_integration_personnel',
                                    'match_field' => 'systems_integration_personnel_match',
                                    'average_field' => 'systems_integration_personnel_average'
                                ],
                                [
                                    'id' => '17',
                                    'title' => 'IT Audit Assistant',
                                    'field' => 'it_audit_assistant',
                                    'match_field' => 'it_audit_assistant_match',
                                    'average_field' => 'it_audit_assistant_average'
                                ],
                            ];
                        @endphp

                        @if ($isCompleted && $jobRecommendation)
                            @foreach ($jobs as $job)
                                @php
                                    $titleValue = $jobRecommendation->{$job['field']} ?? 'N/A';
                                    $matchValue = $jobRecommendation->{$job['match_field']} ?? 0;
                                    $averageValue = $jobRecommendation->{$job['average_field']} ?? 0;
                                @endphp

                                <div x-show="jobSearch === '' || '{{ strtolower($job['title']) }}'.includes(jobSearch.toLowerCase())">
                                    <x-layout.admin.admin-client-job-recommendation
                                        id="{{ $job['id'] }}"
                                        title="{!! $titleValue !!}"
                                        match="{{ $matchValue }}"
                                        score="{{ $averageValue }}"
                                    />
                                </div>
                            @endforeach

                            <li x-show="jobSearch !== '' && !hasMatchingJobs"
                                class="p-4 text-center text-base-content/70">
                                <div class="flex flex-col items-center gap-2 py-8">
                                    <svg class="w-12 h-12 opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <p class="text-sm font-medium">No jobs found</p>
                                    <p class="text-xs opacity-70">Try a different search term</p>
                                </div>
                            </li>
                        @else
                            <li class="p-4 text-center text-base-content/70">
                                <div class="flex flex-col items-center gap-2 py-8">
                                    <svg class="w-12 h-12 opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm font-medium">No job recommendations available</p>
                                    <p class="text-xs opacity-70">Complete your career assessment to get recommendations</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
            
            <div class="divider lg:divider-horizontal"></div>
            <div class="card rounded-box grid h-[300px] grow place-items-center">
                <h1 class="text-xl font-semibold mb-4">Employability Probability</h1>
                @if ($client->employability === 'Employable')
                    <div class="radial-progress text-success"
                        style="--value:{{ $client->employability_probability }}; --size:12rem; --thickness:2rem;"
                        aria-valuenow="{{ $client->employability_probability }}"
                        role="progressbar">
                        {{ $client->employability_probability }}%
                    </div>
                @else
                    <div class="radial-progress text-error"
                        style="--value:{{ $client->employability_probability  }}; --size:12rem; --thickness:2rem;"
                        aria-valuenow="{{ $client->employability_probability }}"
                        role="progressbar">
                        {{ $client->employability_probability }}%
                    </div>
                @endif
                <p class="text-lg font-medium">{{ $client->employability ?? 'No result' }}</p>
            </div>
        </div>

        {{-- Comment --}}
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
            class="flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
            <div class="flex flex-col gap-y-3 w-full">
                <form method="POST" action="/admin/dashboard/client/{{ $client->id }}/comment"
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf

                    <input class="hidden" name="user_id" type="text" value="{{ $client->id }}">

                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">Comment</legend>
                        <textarea class="textarea textarea-primary w-full h-[200px] resize-none" name="comment" placeholder="Comment or recommendation...">{!! $client->comment()->where('admin_admin_id', Auth::guard('admin')->id())->first()?->comment ?? '' !!}</textarea>                        
                        <p class="text-gray-500">Please provide your comments or recommendations</p>
                    </fieldset>

                    <div class="flex justify-end">
                        <!-- Submit Button -->
                        <x-ui.button 
                            type="submit" 
                            color="primary" 
                            x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''"
                            x-bind:disabled="submitting" 
                        >
                            <span x-show="!submitting">Save</span>
                            <span x-show="submitting" style="display: none">Saving <span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>


         <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Academic Information</h3>
                </div>
                <form method="POST" action="{{ route('admin.dashboard.client.update', $client->id) }}" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">
                        
                        {{-- Program --}}
                        <x-ui.form-label class="mb-1" required>Program</x-ui.form-label>
                        <select name="program" class="select w-full validator" required>
                            <option disabled {{ !$client->program ? 'selected' : '' }} value="">Select a program</option>
                            <option value="BSIT" {{ $client->program == 'BSIT' ? 'selected' : '' }}>BS Information Technology</option>
                            <option value="BSCS" {{ $client->program == 'BSCS' ? 'selected' : '' }}>BS Computer Science</option>
                            <option value="BSHM" {{ $client->program == 'BSHM' ? 'selected' : '' }}>BS Hospitality Management</option>
                        </select>
                        <p class="validator-hint hidden">
                            Select a program
                        </p>

                        {{-- Enrollment Status --}}
                        <x-ui.form-label required>Enrollment Status:</x-ui.form-label>
                        <select name="enrollment_status" class="select w-full validator" required>
                            <option disabled {{ !$client->enrollment_status ? 'selected' : '' }} value="">Select an enrollment status</option>
                            <option value="Enrolled" {{ $client->enrollment_status == 'Enrolled' ? 'selected' : '' }}>Enrolled</option>
                            <option value="LOA" {{ $client->enrollment_status == 'LOA' ? 'selected' : '' }}>LOA</option>
                        </select>
                        <p class="validator-hint hidden">
                            Select a enrollment status
                        </p>

                        {{-- Academic Standing --}}
                        <x-ui.form-label class="mb-1" required>Academic Standing</x-ui.form-label>
                        <select name="academic_standing" class="select w-full validator" required>
                            <option disabled {{ !$client->academic_standing ? 'selected' : '' }} value="">Select an academic standing</option>
                            <option value="Regular" {{ $client->academic_standing == 'Regular' ? 'selected' : '' }}>Regular</option>
                            <option value="Irregular" {{ $client->academic_standing == 'Irregular' ? 'selected' : '' }}>Irregular</option>
                        </select>
                        <p class="validator-hint hidden">
                            Select a academic standing
                        </p>

                        <!-- Submit Button -->
                        <x-ui.button 
                            type="submit" 
                            color="primary" 
                            class="mt-4"
                            x-bind:disabled="submitting" 
                        >
                            <span x-show="!submitting">Update</span>
                            <span x-show="submitting" style="display: none">Updating <span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        {{-- Reactivate Account --}}
        <dialog id="my_modal_2" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-success mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Reactivate Account</h3>
                </div>
                <form method="POST" action="/admin/dashboard/client/{{ $client->id }}/activate" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">

                        <!-- Activate -->
                        <x-ui.form-input class="hidden" type="text" value="Offline" name="status" />

                        <p class="text-sm text-justify mb-2">Are you sure you want to reactivate this account? Only administrators are authorized to perform this action. The admin will regain full access to the system upon activation.</p>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-ui.button 
                                type="submit" 
                                variant="outline"
                                color="success" 
                                size="sm"
                                x-bind:disabled="submitting"
                            >
                                <span x-show="!submitting">Activate</span>
                                <span x-show="submitting" style="display: none">Activating <span class="loading loading-dots loading-xs"></span></span>
                            </x-ui.button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        {{-- Disable Account --}}
        <dialog id="my_modal_3" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-warning mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Disable Account</h3>
                </div>
                <form method="POST" action="/admin/dashboard/client/{{ $client->id }}/disabled" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">

                        <!-- Disabled -->
                        <x-ui.form-input class="hidden" type="text" value="Disabled" name="status" />

                        <p class="text-sm text-justify mb-2">Are you sure you want to disable this account? Only administrators are authorized to perform this action. The admin will not be able to access the system upon disabling.</p>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-ui.button 
                                type="submit" 
                                variant="outline"
                                color="warning" 
                                size="sm"
                                x-bind:disabled="submitting"
                            >
                                <span x-show="!submitting">Disable</span>
                                <span x-show="submitting" style="display: none">Disabling <span class="loading loading-dots loading-xs"></span></span>
                            </x-ui.button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        {{-- Delete Account --}}
        <dialog id="my_modal_4" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-error mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Delete Account</h3>
                </div>
                <form method="POST" action="/admin/dashboard/client/{{ $client->id }}/delete" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('DELETE')

                    <fieldset class="fieldset">

                        <p class="text-sm text-justify mb-2">Are you sure you want to delete this account? Only administrators are authorized to perform this action. Please proceed with caution, this cannot be undone.</p>

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

        {{-- What can you do here? --}}
        <dialog id="my_modal_5" class="modal font-outfit">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="flex items-center gap-3 mb-3">
                    <h3 class="text-xl font-bold">What can you do here?</h3>
                </div>
                <div class="text-sm">
                   This page allows the admin to manage student accounts by editing their academic information, 
                   specifically the Program, Enrollment Status, and Academic Standing, while other personal details 
                   remain editable only by the student on their user profile. The admin can also activate, disable, 
                   or delete user accounts as needed and view each student’s career assessment results, including 
                   the Personality Test, Soft Skills Test, Academic Performance, Personal Experience, and Skill Scale 
                   Test, as well as their job recommendations and overall employability status. This provides the 
                   admin with full control over client status and academic details while maintaining user data privacy.
                </div>
            </div>
        </dialog>

        {{-- How does each button work --}}
        <dialog id="my_modal_6" class="modal font-outfit">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="flex items-center gap-3 mb-3">
                    <h3 class="text-xl font-bold">How does each button work</h3>
                </div>
                <p class="mb-2 text-sm">
                    <span class="font-medium text-info">Back: </span> <br />
                    Returns to Admin Management page.
                </p>
                <p class="mb-2 text-sm">
                    <span class="font-medium text-primary">Edit: </span> <br />
                    Edit Academic information.
                </p>
                <p class="mb-2 text-sm">
                    <span class="font-medium text-success">Activate: </span> <br />
                    Reactivates a previously deactivated account.
                </p>
                <p class="mb-2 text-sm">
                    <span class="font-medium text-warning">Disabled: </span> <br />
                    Temporarily disables the admin’s account.
                </p>
                <p class="text-sm">
                    <span class="font-medium text-error">Delete: </span> <br />
                    Permanently removes the admin’s account and data.
                </p>
            </div>
        </dialog>
    </main>
</x-layout.app>