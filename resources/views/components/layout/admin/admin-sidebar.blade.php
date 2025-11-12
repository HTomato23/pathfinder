<aside class="fixed top-0 h-full w-3xs shadow-sm transform -translate-x-full lg:translate-x-0 transition-all duration-200 ease hidden xl:block p-2 overflow-y-auto">
    <nav class="menu menu-sm w-full font-sans space-y-2">

        {{-- Pathfinder Logo --}}
        <li class="mb-5">
            <a>
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
            <x-ui.nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                <x-heroicon-o-cube class="w-5 h-5"/>
                <span>Dashboard</span>
            </x-ui.nav-link>
        </li>

        {{-- Model Configuration Link --}}
        <li>
            <x-ui.nav-link href="{{ route('admin.dashboard.model') }}" :active="request()->routeIs('admin.dashboard.model')">
                <x-heroicon-o-arrow-path class="w-5 h-5"/>
                <span>Model Configuration</span>
            </x-ui.nav-link>
        </li>

        {{-- Admin Management Link --}}
        <li>
            <x-ui.nav-link href="{{ route('admin.dashboard.control') }}" :active="request()->routeIs('admin.dashboard.control') || request()->is('admin/dashboard/control/*')">
                <x-heroicon-o-shield-check class="w-5 h-5"/>
                <span>Control</span>
            </x-ui.nav-link>
        </li>

        {{-- User Management Link --}}
        <li>
            <x-ui.nav-link href="{{ route('admin.dashboard.client') }}" :active="request()->routeIs('admin.dashboard.client') || request()->is('admin/dashboard/client/*')">
                <x-heroicon-o-users class="w-5 h-5"/>
                <span>Client</span>
            </x-ui.nav-link>
        </li>

        {{-- Consulatations Management Link --}}
        <li>
            <x-ui.nav-link href="{{ route('admin.dashboard.consultation') }}" :active="request()->routeIs('admin.dashboard.consultation') || request()->is('admin/dashboard/consultation/*')">
                <x-heroicon-o-chat-bubble-left-right class="w-5 h-5"/>
                <span>Consultations</span>
            </x-ui.nav-link>
        </li>

        {{-- Predict & Analysis Link --}}
        <li>
            <x-ui.nav-link href="{{ route('admin.dashboard.predict') }}" :active="request()->routeIs('admin.dashboard.predict')">
                <x-heroicon-o-chart-pie class="w-5 h-5"/>
                <span>Predict & Analysis</span>
            </x-ui.nav-link>
        </li>

        {{-- Blogs Management Link --}}
        <li>
            <details {{
                (
                    request()->routeIs([
                        'admin.dashboard.blogs',
                        'admin.dashboard.blogs.create',
                        'admin.dashboard.blogs.authors',
                    ]) 
                    || (request()->is('admin/dashboard/blogs/*') && !request()->is('admin/dashboard/blogs/authors*'))
                    || request()->is('admin/dashboard/blogs/authors*')
                ) ? 'open' : ''
            }}>
                <summary class="font-medium">
                    <x-heroicon-o-paper-clip class="w-5 h-5"/>
                    Blogs
                </summary>
                <ul>
                    <li>
                        <x-ui.nav-link 
                            href="{{ route('admin.dashboard.blogs') }}" 
                            :active="(request()->is('admin/dashboard/blogs*') && !request()->is('admin/dashboard/blogs/authors*'))">
                            <span>Blog</span>
                        </x-ui.nav-link>
                    </li>
                    <li>
                        <x-ui.nav-link  
                            href="{{ route('admin.dashboard.blogs.authors') }}" 
                            :active="request()->is('admin/dashboard/blogs/authors*')">
                            <span>Author</span>
                        </x-ui.nav-link>
                    </li>
                </ul>
            </details>
        </li>

        {{-- Job Portal --}}
        <li>
            <x-ui.nav-link href="{{ route('admin.dashboard.jobs') }}" :active="request()->routeIs('admin.dashboard.jobs') || request()->is('admin/dashboard/jobs/*')">
                <x-heroicon-o-briefcase class="w-5 h-5"/>
                <span>Job Portal</span>
            </x-ui.nav-link>
        </li>


        {{-- Divider --}}
        <div class="divider mt-10"></div>

         <!-- Settings -->
        <li>
            <details {{ request()->routeIs([
                'admin.dashboard.settings.profile',
                'admin.dashboard.settings.password',
                'admin.dashboard.settings.activitylog',
                'admin.dashboard.settings.appearance',
            ]) ? 'open' : '' }}>
                <summary class="font-medium">
                    <x-heroicon-o-cog-8-tooth class="w-5 h-5" />
                    Settings
                </summary>
                <ul>
                    <li>
                        <x-ui.nav-link href="{{ route('admin.dashboard.settings.profile') }}" :active="request()->routeIs('admin.dashboard.settings.profile')">
                            <span>Profile</span>
                        </x-ui.nav-link>
                    </li>
                    <li>
                        <x-ui.nav-link href="{{ route('admin.dashboard.settings.password') }}" :active="request()->routeIs('admin.dashboard.settings.password')">
                            <span>Change Password</span>
                        </x-ui.nav-link>
                    </li>
                    <li>
                        <x-ui.nav-link href="{{ route('admin.dashboard.settings.activitylog') }}" :active="request()->routeIs('admin.dashboard.settings.activitylog')">
                            <span>Activity Log</span>
                        </x-ui.nav-link>
                    </li>
                    <li>
                        <x-ui.nav-link href="{{ route('admin.dashboard.settings.appearance') }}" :active="request()->routeIs('admin.dashboard.settings.appearance')">
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

<form method="POST" id="logout-form" action="{{ route('admin.logout') }}">
    @csrf      
</form>    
