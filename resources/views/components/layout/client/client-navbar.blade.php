<div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
    class="navbar shadow-sm rounded-sm font-outfit">
    <div class="navbar-start">

        <div class="dropdown">
            {{-- Burger Menu --}}
            <div tabindex="0" role="button" class="btn btn-ghost xl:hidden">
                <x-heroicon-o-bars-3-bottom-left class="w-6 h-6"/>
            </div>

            <!-- Mobile Dropdown Menu -->
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-xl z-40 mt-5 w-52 p-2 shadow">

                {{-- Dashboard Link --}}
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                        <x-heroicon-o-cube class="w-4 h-4"/> Dashboard
                    </a>
                </li>

                {{-- Assessment Section --}}
                <li>
                    <span class="pointer-events-none">
                        <x-heroicon-o-newspaper class="w-4 h-4"/> Assessment
                    </span>
                    <ul class="p-2">
                        <li>
                            <a href="{{ route('dashboard.assessment') }}" class="{{ request()->routeIs('dashboard.assessment') ? 'menu-active' : '' }}">
                                Before You Start
                            </a>
                        </li>
                        <li class="{{ auth()->user()->is_personality_completed ? 'menu-disabled' : 'menu-disabled' }}">
                            <a href="{{ route('dashboard.assessment.personality') }}" class="{{ request()->routeIs('dashboard.assessment.personality') ? 'menu-active' : '' }}">
                                Personality Test
                                @if(auth()->user()->is_personality_completed)
                                    <span class="badge badge-success badge-xs">✓</span>
                                @endif
                            </a>
                        </li>
                        <li class="{{ (!auth()->user()->is_personality_completed || auth()->user()->is_softskill_completed) ? 'menu-disabled' : '' }}">
                            <a href="{{ route('dashboard.assessment.softskill') }}" class="{{ request()->routeIs('dashboard.assessment.softskill') ? 'menu-active' : '' }}">
                                Soft Skill Test
                                @if(auth()->user()->is_softskill_completed)
                                    <span class="badge badge-success badge-xs">✓</span>
                                @endif
                            </a>
                        </li>
                        <li class="{{ (!auth()->user()->is_softskill_completed || auth()->user()->is_academic_completed) ? 'menu-disabled' : '' }}">
                            <a href="{{ route('dashboard.assessment.academic') }}" class="{{ request()->routeIs('dashboard.assessment.academic') ? 'menu-active' : '' }}">
                                Academic
                                @if(auth()->user()->is_academic_completed)
                                    <span class="badge badge-success badge-xs">✓</span>
                                @endif
                            </a>
                        </li>
                        <li class="{{ (!auth()->user()->is_academic_completed || auth()->user()->is_personal_completed) ? 'menu-disabled' : '' }}">
                            <a href="{{ route('dashboard.assessment.personal') }}" class="{{ request()->routeIs('dashboard.assessment.personal') ? 'menu-active' : '' }}">
                                Personal Experience
                                @if(auth()->user()->is_personal_completed)
                                    <span class="badge badge-success badge-xs">✓</span>
                                @endif
                            </a>
                        </li>
                        <li class="{{ (!auth()->user()->is_personal_completed || auth()->user()->is_skill_completed) ? 'menu-disabled' : '' }}">
                            <a href="{{ route('dashboard.assessment.skill') }}" class="{{ request()->routeIs('dashboard.assessment.skill') ? 'menu-active' : '' }}">
                                Skill Scale
                                @if(auth()->user()->is_skill_completed)
                                    <span class="badge badge-success badge-xs">✓</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Consultations --}}
                <li>
                    <a href="{{ route('dashboard.consultation') }}" class="{{ request()->routeIs('dashboard.consultation') ? 'menu-active' : '' }}">
                        <x-heroicon-o-chat-bubble-left-right class="w-4 h-4"/> Consultations
                    </a>
                </li>

                {{-- Comment --}}
                <li>
                    <a href="{{ route('dashboard.comment') }}" class="{{ request()->routeIs('dashboard.comment') ? 'menu-active' : '' }}">
                        <x-heroicon-o-chat-bubble-bottom-center-text class="w-4 h-4"/> Comment
                    </a>
                </li>

                {{-- Browse Jobs --}}
                <li>
                    <a href="{{ route('browse.jobs') }}" class="{{ request()->routeIs('browse.jobs') ? 'menu-active' : '' }}">
                        <x-heroicon-o-briefcase class="w-4 h-4"/> Browse Jobs
                    </a>
                </li>

                {{-- Settings Section --}}
                <li>
                    <span class="pointer-events-none">
                        <x-heroicon-o-cog-8-tooth class="w-4 h-4" /> Settings
                    </span>
                    <ul class="p-2">
                        <li>
                            <a href="{{ route('dashboard.settings.profile') }}" class="{{ request()->routeIs('dashboard.settings.profile') ? 'menu-active' : '' }}">
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.settings.password') }}" class="{{ request()->routeIs('dashboard.settings.password') ? 'menu-active' : '' }}">
                                Change Password
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.settings.appearance') }}" class="{{ request()->routeIs('dashboard.settings.appearance') ? 'menu-active' : '' }}">
                                Appearance
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Log out --}}
                <li>
                    <button type="submit" form="logout-form" class="flex items-center gap-2 w-full">
                        <x-heroicon-o-arrow-right-start-on-rectangle class="w-4 h-4"/> Log out
                    </button>
                </li>
            </ul>
        </div>

        <!-- Logo / Title -->
        <a class="ml-5 text-lg font-outfit font-medium hidden xl:block">{{ $page }}</a>
    </div>
    
    @php
        $client = Auth::user();
        $initials = $client ? strtoupper(substr($client->first_name, 0, 1)) . strtoupper(substr($client->last_name, 0, 1)) : 'AD';
    @endphp

    <!-- Right Side -->
    <div class="navbar-end space-x-3">
        <span class="hidden sm:flex sm:text-sm">
            {{ $client ? $client->first_name . ' ' . $client->last_name  : 'Guest Client' }}
        </span>
        
        <a href="{{ route('dashboard.settings.profile') }}" class="mr-5">
            <div class="avatar avatar-online avatar-placeholder cursor-pointer">
                <div class="bg-neutral text-neutral-content w-10 rounded-full">
                    <span class="text-sm font-outfit">{{ $initials }}</span>
                </div>
            </div>
        </a>
    </div>
</div>

<form class="hidden" method="POST" id="logout-form" action="{{ route('logout') }}">
    @csrf      
</form>