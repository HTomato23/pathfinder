<aside class="fixed top-0 h-full w-3xs shadow-sm transform -translate-x-full lg:translate-x-0 transition-all duration-200 ease hidden xl:block p-2 overflow-y-auto">
    <nav class="menu menu-sm w-full font-sans space-y-2">

        {{-- Pathfinder Logo --}}
        <li class="mb-5">
            <a href="{{ route('dashboard') }}">
                <div class="avatar">
                    <div class="w-10 rounded-full">
                        <img src="{{ asset('images/plp-logo.png') }}" />
                    </div>
                </div>
                <span class="text-lg font-medium">Pathfinder</span>
            </a>
        </li>

        {{-- Dashboard Link --}}
        <li>
            <x-ui.nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <x-heroicon-o-cube class="w-5 h-5"/>
                <span>Dashboard</span>
            </x-ui.nav-link>
        </li>

        <!-- Assessment -->
        <li>
            <details {{ request()->routeIs([
                'dashboard.assessment',
                'dashboard.assessment.personality',
                'dashboard.assessment.softskill',
                'dashboard.assessment.academic',
                'dashboard.assessment.personal',
                'dashboard.assessment.skill',
            ]) ? 'open' : '' }}>
                <summary class="font-medium">
                    <x-heroicon-o-newspaper class="w-4 h-4"/>
                    Assessment
                </summary>
                <ul>
                    <li>
                        <x-ui.nav-link href="{{ route('dashboard.assessment') }}" :active="request()->routeIs('dashboard.assessment')">
                            <span>Before You Start</span>
                        </x-ui.nav-link>
                    </li>
                    
                    <!-- Personality Test -->
                    <li {{ auth()->user()->is_personality_completed ? 'class=menu-disabled' : 'class=menu-disabled' }}>
                        <x-ui.nav-link href="{{ route('dashboard.assessment.personality') }}" :active="request()->routeIs('dashboard.assessment.personality')">
                            <span>Personality Test</span>
                            @if(auth()->user()->is_personality_completed)
                                <span class="badge badge-success badge-xs">✓</span>
                            @endif
                        </x-ui.nav-link>
                    </li>
                    
                    <!-- Soft Skill Test -->
                    <li {{ (!auth()->user()->is_personality_completed || auth()->user()->is_softskill_completed) ? 'class=menu-disabled' : '' }}>
                        <x-ui.nav-link href="{{ route('dashboard.assessment.softskill') }}" :active="request()->routeIs('dashboard.assessment.softskill')">
                            <span>Soft Skill Test</span>
                            @if(auth()->user()->is_softskill_completed)
                                <span class="badge badge-success badge-xs">✓</span>
                            @endif
                        </x-ui.nav-link>
                    </li>
                    
                    <!-- Academic -->
                    <li {{ (!auth()->user()->is_softskill_completed || auth()->user()->is_academic_completed) ? 'class=menu-disabled' : '' }}>
                        <x-ui.nav-link href="{{ route('dashboard.assessment.academic') }}" :active="request()->routeIs('dashboard.assessment.academic')">
                            <span>Academic</span>
                            @if(auth()->user()->is_academic_completed)
                                <span class="badge badge-success badge-xs">✓</span>
                            @endif
                        </x-ui.nav-link>
                    </li>
                    
                    <!-- Personal Experience -->
                    <li {{ (!auth()->user()->is_academic_completed || auth()->user()->is_personal_completed) ? 'class=menu-disabled' : '' }}>
                        <x-ui.nav-link href="{{ route('dashboard.assessment.personal') }}" :active="request()->routeIs('dashboard.assessment.personal')">
                            <span>Personal Experience</span>
                            @if(auth()->user()->is_personal_completed)
                                <span class="badge badge-success badge-xs">✓</span>
                            @endif
                        </x-ui.nav-link>
                    </li>
                    
                    <!-- Skill Scale -->
                    <li {{ (!auth()->user()->is_personal_completed || auth()->user()->is_skill_completed) ? 'class=menu-disabled' : '' }}>
                        <x-ui.nav-link href="{{ route('dashboard.assessment.skill') }}" :active="request()->routeIs('dashboard.assessment.skill')">
                            <span>Skill Scale</span>
                            @if(auth()->user()->is_skill_completed)
                                <span class="badge badge-success badge-xs">✓</span>
                            @endif
                        </x-ui.nav-link>
                    </li>
                </ul>
            </details>
        </li>

        {{-- Consultations --}}
        <li>
            <x-ui.nav-link href="{{ route('dashboard.consultation') }}" :active="request()->routeIs('dashboard.consultation')">
                 <x-heroicon-o-chat-bubble-left-right class="w-5 h-5"/>
                <span>Consultations</span>
            </x-ui.nav-link>
        </li>

        {{-- Comments --}}
        <li>
            <x-ui.nav-link href="{{ route('dashboard.comment') }}" :active="request()->routeIs('dashboard.comment')">
                 <x-heroicon-o-chat-bubble-bottom-center-text class="w-5 h-5"/>
                <span>Comments</span>
            </x-ui.nav-link>
        </li>

        {{-- Feedback --}}
        <li>
            <x-ui.nav-link href="{{ route('dashboard.feedback') }}" :active="request()->routeIs('dashboard.feedback') || request()->is('dashboard/feedback/*')">
                 <x-heroicon-o-star class="w-5 h-5"/>
                <span>Feedback</span>
            </x-ui.nav-link>
        </li>

        {{-- Browse Jobs --}}
        <li>
            <x-ui.nav-link href="{{ route('browse.jobs') }}" :active="request()->routeIs('browse.jobs')">
                <x-heroicon-o-briefcase class="w-5 h-5" />
                <span>Browse Jobs</span>
            </x-ui.nav-link>
        </li>


        {{-- Divider --}}
        <div class="divider mt-10"></div>

         <!-- Settings -->
        <li>
            <details {{ request()->routeIs([
                'dashboard.settings.profile',
                'dashboard.settings.password',
                'dashboard.settings.appearance',
            ]) ? 'open' : '' }}>
                <summary class="font-medium">
                    <x-heroicon-o-cog-8-tooth class="w-5 h-5" />
                    Settings
                </summary>
                <ul>
                    <li>
                        <x-ui.nav-link href="{{ route('dashboard.settings.profile') }}" :active="request()->routeIs('dashboard.settings.profile')">
                            <span>Profile</span>
                        </x-ui.nav-link>
                    </li>
                    <li>
                        <x-ui.nav-link href="{{ route('dashboard.settings.password') }}" :active="request()->routeIs('dashboard.settings.password')">
                            <span>Change Password</span>
                        </x-ui.nav-link>
                    </li>
                    <li>
                        <x-ui.nav-link href="{{ route('dashboard.settings.appearance') }}" :active="request()->routeIs('dashboard.settings.appearance')">
                            <span>Appearance</span>
                        </x-ui.nav-link>
                    </li>
                </ul>
            </details>
        </li>

        {{-- Log out Link --}}
        <li>
            <button type="submit" form="logout-form" class="flex items-center gap-2 font-medium w-full">
                <x-heroicon-o-arrow-right-start-on-rectangle class="w-5 h-5"/>
                <span>Log out</span>
            </button>      
        </li>

    </nav>
</aside>

<form method="POST" id="logout-form" action="{{ route('logout') }}">
    @csrf      
</form>    
