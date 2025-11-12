<div x-data="{ isScrolled: false }" 
     @scroll.window="isScrolled = window.scrollY > 0"
     :class="isScrolled ? 'backdrop-blur-md bg-base-100/80' : 'bg-transparent'"
     class="navbar fixed top-0 z-999 font-outfit px-5 transition-all duration-300">
    <div class="navbar-start">
        {{-- Pathfinder Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="avatar">
                <div class="w-10 rounded-full">
                    <img src="{{ Vite::asset('resources/images/plp-logo.png') }}" />
                </div>
            </div>
            <div class="font-poppins text-lg font-medium">Pathfinder</div>
        </a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 space-x-2">
            <li>
                <x-ui.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-ui.nav-link>
            </li>
            <li>
                <x-ui.nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">About</x-ui.nav-link>
            </li>
            <li>
                <x-ui.nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact</x-ui.nav-link>
            </li>
            <li>
                <x-ui.nav-link href="{{ route('blogs') }}" :active="request()->routeIs('blogs')">Blogs</x-ui.nav-link>
            </li>
        </ul>
    </div>
    <div class="navbar-end">
        {{-- Small Screen Menu --}}
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <x-heroicon-o-bars-3 class="w-5 h-5"/>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li>
                <x-ui.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-ui.nav-link>
                </li>
                <li>
                    <x-ui.nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">About</x-ui.nav-link>
                </li>
                <li>
                    <x-ui.nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact</x-ui.nav-link>
                </li>
                <li>
                    <x-ui.nav-link href="{{ route('blogs') }}" :active="request()->routeIs('blogs')">Blogs</x-ui.nav-link>
                </li>
                <li>
                    <x-ui.nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">Sign in</x-ui.nav-link>
                </li>
                <li>
                    <x-ui.nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">Register</x-ui.nav-link>
                </li>
            </ul> 
        </div>
        {{-- Larger Screen Menu --}}
        <div class="hidden items-center gap-3 lg:flex">
            <a href="{{ route('show.loginClient') }}" class="text-sm">Sign in</a>
            <x-ui.button href="{{ route('show.registerClient') }}" color="neutral" class="!bg-green-800 border-0 hover:opacity-90" size="sm">Register</x-button>
        </div>
    </div>
</div>
