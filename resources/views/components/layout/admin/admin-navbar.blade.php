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

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'menu-active' : '' }}">
                        <x-heroicon-o-cube class="w-4 h-4"/> Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard.model') }}" class="{{ request()->routeIs('admin.dashboard.model') ? 'menu-active' : '' }}">
                        <x-heroicon-o-arrow-path class="w-4 h-4"/> Model Configuration
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard.control') }}" class="{{ request()->routeIs('admin.dashboard.control') || request()->is('admin/dashboard/control/*') ? 'menu-active' : '' }}">
                        <x-heroicon-o-shield-check class="w-4 h-4"/> Control
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard.client') }}" class="{{ request()->routeIs('admin.dashboard.client') || request()->is('admin/dashboard/client/*') ? 'menu-active' : '' }}">
                        <x-heroicon-o-users class="w-4 h-4"/> Client
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard.consultation') }}" class="{{ request()->routeIs('admin.dashboard.consultation') || request()->is('admin/dashboard/consultation/*') ? 'menu-active' : '' }}">
                        <x-heroicon-o-chat-bubble-left-right class="w-4 h-4"/> Consultations
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard.predict') }}" class="{{ request()->routeIs('admin.dashboard.predict') ? 'menu-active' : '' }}">
                        <x-heroicon-o-chart-pie class="w-4 h-4"/> Predict & Analysis
                    </a>
                </li>

                <li>
                    <span class="pointer-events-none">
                        <x-heroicon-o-paper-clip class="w-4 h-4"/> Blogs
                    </span>
                    <ul class="p-2">
                        <li>
                            <a href="{{ route('admin.dashboard.blogs') }}" class="{{ (request()->is('admin/dashboard/blogs*') && !request()->is('admin/dashboard/blogs/authors*')) ? 'menu-active' : '' }}">
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard.blogs.authors') }}" class="{{ request()->is('admin/dashboard/blogs/authors*') ? 'menu-active' : '' }}">
                                Author
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <span class="pointer-events-none">
                        <x-heroicon-o-cog-8-tooth class="w-4 h-4" /> Settings
                    </span>
                    <ul class="p-2">
                        <li>
                            <a href="{{ route('admin.dashboard.settings.profile') }}" class="{{ request()->routeIs('admin.dashboard.settings.profile') ? 'menu-active' : '' }}">
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard.settings.password') }}" class="{{ request()->routeIs('admin.dashboard.settings.password') ? 'menu-active' : '' }}">
                                Change Password
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard.settings.activitylog') }}" class="{{ request()->routeIs('admin.dashboard.settings.activitylog') ? 'menu-active' : '' }}">
                                Activity Log
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard.settings.appearance') }}" class="{{ request()->routeIs('admin.dashboard.settings.appearance') ? 'menu-active' : '' }}">
                                Appearance
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <button type="submit" form="logout-form" class="flex items-center gap-2 w-full text-left">
                        <x-heroicon-o-arrow-right-start-on-rectangle class="w-4 h-4"/>
                        <span>Log out</span>
                    </button>
                </li>
            </ul>
        </div>

        <!-- Logo / Title -->
        <a class="ml-5 text-lg font-outfit font-medium hidden lg:block">{{ $page }}</a>
    </div>
    
    @php
        $admin = Auth::guard('admin')->user();
        $initials = $admin ? strtoupper(substr($admin->first_name, 0, 1)) . strtoupper(substr($admin->last_name, 0, 1)) : 'AD';
    @endphp

    <!-- Right Side -->
    <div class="navbar-end space-x-3">
        <span class="hidden sm:flex sm:text-sm">
            {{ $admin ? $admin->first_name . ' ' . $admin->last_name  : 'Guest Admin' }}
        </span>
        
        <a href="{{ route('admin.dashboard.settings.profile') }}" class="mr-5">
            <div class="avatar avatar-online avatar-placeholder cursor-pointer">
                <div class="bg-neutral text-neutral-content w-10 rounded-full">
                    <span class="text-sm font-outfit">{{ $initials }}</span>
                </div>
            </div>
        </a>
    </div>
</div>

<form class="hidden" method="POST" id="logout-form" action="{{ route('admin.logout') }}">
    @csrf      
</form>