<x-layout.client title="Appearance">
    <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.client.client-navbar page="Appearance"></x-layout.client.client-navbar>

        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="shadow-sm rounded-sm p-10 w-full">
            <div class="flex flex-wrap gap-5 justify-between">
                <p class="font-outfit">
                    Adjust the appearance of Pathfinder to reduce glare and give your eyes a break.
                </p>
                <label class="flex cursor-pointer gap-2">
                    {{-- Sun --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5" />
                        <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
                    </svg>

                    {{-- Controller --}}
                    <input type="checkbox" class="toggle theme-controller" @change="$store.theme.toggle()" :checked="$store.theme.isDark()" />

                    {{-- Moon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </label>
            </div>
        </div>
    </main>
</x-layout.client>
