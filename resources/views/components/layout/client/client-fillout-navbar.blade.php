<div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
    class="navbar shadow-sm rounded-sm font-outfit">
    <div class="navbar-start">
        <!-- Logo / Title -->
        <a class="ml-5 text-lg font-outfit font-medium">{{ $page }}</a>
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
        
        <div class="dropdown dropdown-end mr-5">
            <div tabindex="0" role="button" class="avatar avatar-online avatar-placeholder cursor-pointer">
                <div class="bg-neutral text-neutral-content w-10 rounded-full">
                    <span class="text-sm font-outfit">{{ $initials }}</span>
                </div>
            </div>
            <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-200 rounded-box z-1 mt-5 w-52 p-2 shadow">
                <li>
                     <button type="submit" form="logout-form" class="flex items-center gap-2 font-medium w-full">
                        <x-heroicon-o-arrow-right-start-on-rectangle class="w-5 h-5"/>
                        <span>Log out</span>
                    </button>     
                </li>
            </ul>
        </div>
    </div>

    <form method="POST" id="logout-form" action="{{ route('logout') }}">
        @csrf      
    </form>  
</div>


  
