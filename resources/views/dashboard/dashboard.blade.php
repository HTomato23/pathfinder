<x-layout.client title="Dashboard">
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

    @if (Auth::user()->is_completed)
        <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
        <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
            <x-layout.client.client-navbar page="Dashboard"></x-layout.client.client-navbar>

            @php
                $client = Auth::user();

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
                            'web application developer',
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
                                        'match_field' => 'cashier_match'
                                    ],
                                    [
                                        'id' => '02',
                                        'title' => 'Waiter',
                                        'field' => 'waiter',
                                        'match_field' => 'waiter_match'
                                    ],
                                    [
                                        'id' => '03',
                                        'title' => 'Bartender',
                                        'field' => 'bartender',
                                        'match_field' => 'bartender_match'
                                    ],
                                    [
                                        'id' => '04',
                                        'title' => 'Barista',
                                        'field' => 'barista',
                                        'match_field' => 'barista_match'
                                    ],
                                    [
                                        'id' => '05',
                                        'title' => 'Restaurant Supervisor',
                                        'field' => 'restaurant_supervisor',
                                        'match_field' => 'restaurant_supervisor_match'
                                    ],
                                    [
                                        'id' => '06',
                                        'title' => 'Commis Chef',
                                        'field' => 'commis_chef',
                                        'match_field' => 'commis_chef_match'
                                    ],
                                    [
                                        'id' => '07',
                                        'title' => 'Line Cook',
                                        'field' => 'line_cook',
                                        'match_field' => 'line_cook_match'
                                    ],
                                    [
                                        'id' => '08',
                                        'title' => 'Pastry Chef',
                                        'field' => 'pastry_chef',
                                        'match_field' => 'pastry_chef_match'
                                    ],
                                    [
                                        'id' => '09',
                                        'title' => 'Sous Chef',
                                        'field' => 'sous_chef',
                                        'match_field' => 'sous_chef_match'
                                    ],
                                    [
                                        'id' => '10',
                                        'title' => 'Head Chef',
                                        'field' => 'head_chef',
                                        'match_field' => 'head_chef_match'
                                    ],
                                    [
                                        'id' => '11',
                                        'title' => 'Room Attendant',
                                        'field' => 'room_attendant',
                                        'match_field' => 'room_attendant_match'
                                    ],
                                    [
                                        'id' => '12',
                                        'title' => 'Housekeeping Attendant',
                                        'field' => 'housekeeping_attendant',
                                        'match_field' => 'housekeeping_attendant_match'
                                    ],
                                    [
                                        'id' => '13',
                                        'title' => 'Floor Supervisor',
                                        'field' => 'floor_supervisor',
                                        'match_field' => 'floor_supervisor_match'
                                    ],
                                    [
                                        'id' => '14',
                                        'title' => 'Laundry Supervisor',
                                        'field' => 'laundry_supervisor',
                                        'match_field' => 'laundry_supervisor_match'
                                    ],
                                    [
                                        'id' => '15',
                                        'title' => 'Receptionist',
                                        'field' => 'receptionist',
                                        'match_field' => 'receptionist_match'
                                    ],
                                    [
                                        'id' => '16',
                                        'title' => 'Front Office Attendant',
                                        'field' => 'front_office_attendant',
                                        'match_field' => 'front_office_attendant_match'
                                    ],
                                    [
                                        'id' => '17',
                                        'title' => 'Concierge',
                                        'field' => 'concierge_crm',
                                        'match_field' => 'concierge_crm_match'
                                    ],
                                    [
                                        'id' => '18',
                                        'title' => 'Front Office Manager',
                                        'field' => 'front_office_manager',
                                        'match_field' => 'front_office_manager_match'
                                    ],
                                    [
                                        'id' => '19',
                                        'title' => 'Sales Representative',
                                        'field' => 'sales_representative',
                                        'match_field' => 'sales_representative_match'
                                    ],
                                    [
                                        'id' => '20',
                                        'title' => 'Events Planner',
                                        'field' => 'events_planner',
                                        'match_field' => 'events_planner_match'
                                    ],
                                    [
                                        'id' => '21',
                                        'title' => 'Marketing Manager',
                                        'field' => 'marketing_manager',
                                        'match_field' => 'marketing_manager_match'
                                    ],
                                ];
                            @endphp

                            @if ($isCompleted && $jobRecommendation)
                                @foreach ($jobs as $job)
                                    @php
                                        $titleValue = $jobRecommendation->{$job['field']} ?? 'N/A';
                                        $matchValue = $jobRecommendation->{$job['match_field']} ?? 0;
                                    @endphp

                                    <div x-show="jobSearch === '' || '{{ strtolower($job['title']) }}'.includes(jobSearch.toLowerCase())">
                                        <x-layout.client.client-job-recommendation
                                            id="{{ $job['id'] }}"
                                            title="{!! $titleValue !!}"
                                            match="{{ $matchValue }}"
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
                                        'match_field' => 'software_engineer_match'
                                    ],
                                    [
                                        'id' => '02',
                                        'title' => 'System Software Developer',
                                        'field' => 'systems_software_developer',
                                        'match_field' => 'systems_software_developer_match'
                                    ],
                                    [
                                        'id' => '03',
                                        'title' => 'Application Software Developer',
                                        'field' => 'applications_software_developer',
                                        'match_field' => 'applications_software_developer_match'
                                    ],
                                    [
                                        'id' => '04',
                                        'title' => 'Research & Development Computing',
                                        'field' => 'research_development_computing',
                                        'match_field' => 'research_development_computing_match'
                                    ],
                                    [
                                        'id' => '05',
                                        'title' => 'Computer Programmer',
                                        'field' => 'computer_programmer',
                                        'match_field' => 'computer_programmer_match'
                                    ],
                                    [
                                        'id' => '06',
                                        'title' => 'Web Application Developer',
                                        'field' => 'web_applications_developer',
                                        'match_field' => 'web_applications_developer_match'
                                    ],
                                    [
                                        'id' => '07',
                                        'title' => 'System Analyst',
                                        'field' => 'systems_analyst',
                                        'match_field' => 'systems_analyst_match'
                                    ],
                                    [
                                        'id' => '08',
                                        'title' => 'Data Analyst',
                                        'field' => 'data_analyst',
                                        'match_field' => 'data_analyst_match'
                                    ],
                                    [
                                        'id' => '09',
                                        'title' => 'Quality Assurance Specialist',
                                        'field' => 'quality_assurance_specialist',
                                        'match_field' => 'quality_assurance_specialist_match'
                                    ],
                                    [
                                        'id' => '10',
                                        'title' => 'Software Support Specialist',
                                        'field' => 'software_support_specialist',
                                        'match_field' => 'software_support_specialist_match'
                                    ],
                                    [
                                        'id' => '11',
                                        'title' => 'Technical Support Specialist',
                                        'field' => 'technical_support_specialist',
                                        'match_field' => 'technical_support_specialist_match'
                                    ],
                                    [
                                        'id' => '12',
                                        'title' => 'Junior Database Administrator',
                                        'field' => 'junior_database_administrator',
                                        'match_field' => 'junior_database_administrator_match'
                                    ],
                                    [
                                        'id' => '13',
                                        'title' => 'System Administrator',
                                        'field' => 'systems_administrator',
                                        'match_field' => 'systems_administrator_match'
                                    ],
                                    [
                                        'id' => '14',
                                        'title' => 'Network Engineer',
                                        'field' => 'network_engineer',
                                        'match_field' => 'network_engineer_match'
                                    ],
                                    [
                                        'id' => '15',
                                        'title' => 'Junior Information Security Administrator',
                                        'field' => 'junior_information_security_administrator',
                                        'match_field' => 'junior_information_security_administrator_match'
                                    ],
                                    [
                                        'id' => '16',
                                        'title' => 'System Integration Personnel',
                                        'field' => 'systems_integration_personnel',
                                        'match_field' => 'systems_integration_personnel_match'
                                    ],
                                    [
                                        'id' => '17',
                                        'title' => 'IT Audit Assistant',
                                        'field' => 'it_audit_assistant',
                                        'match_field' => 'it_audit_assistant_match'
                                    ],
                                ];
                            @endphp

                            @if ($isCompleted && $jobRecommendation)
                                @foreach ($jobs as $job)
                                    @php
                                        $titleValue = $jobRecommendation->{$job['field']} ?? 'N/A';
                                        $matchValue = $jobRecommendation->{$job['match_field']} ?? 0;
                                    @endphp

                                    <div x-show="jobSearch === '' || '{{ strtolower($job['title']) }}'.includes(jobSearch.toLowerCase())">
                                        <x-layout.client.client-job-recommendation
                                            id="{{ $job['id'] }}"
                                            title="{!! $titleValue !!}"
                                            match="{{ $matchValue }}"
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
        </main>
    @else
        <x-layout.client.client-fillout />
    @endif
</x-layout.client>