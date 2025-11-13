<x-layout.app title="Dashboard">
    <x-layout.admin.admin-sidebar></x-layout.admin.admin-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]">
        <x-layout.admin.admin-navbar page="Dashboard"></x-layout.admin.admin-navbar>

        {{-- Success message --}}
        @if (session('success'))
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                <x-ui.alert type="success" message="{{ session('success') }}" class="mb-3" />
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-2 justify-between">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-3 p-5 w-full rounded-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <h1 class="text-md font-medium">Control Management</h1>
                </div>
                <div class="flex lg:h-[70px]">
                    <p class="text-sm text-gray-500">Manage and monitor all admin accounts within the system. Super Admins have the authority to create and control other admin users.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.dashboard.control') }}" class="btn btn-sm btn-outline btn-primary">Manage</a>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-3 p-5 w-full rounded-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <h1 class="text-md font-medium">Client Management</h1>
                </div>
                <div class="flex lg:h-[70px]">
                    <p class="text-sm text-gray-500">Oversee and manage all student accounts efficiently. Monitor their career assessment results, information, and system engagement.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.dashboard.client') }}" class="btn btn-sm btn-outline btn-primary">Manage</a>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-3 p-5 w-full rounded-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <h1 class="text-md font-medium">Blog Management</h1>
                </div>
                <div class="flex lg:h-[70px]">
                    <p class="text-sm text-gray-500">Oversee products, track orders, manage inventory, and handle transactions — to store running efficiently.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.dashboard.blogs') }}" class="btn btn-sm btn-outline btn-primary">Manage</a>
                </div>
            </div>
        </div>

        <!-- Dashboard Statistics -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
            class="stats font-outfit shadow-sm rounded-sm w-full">

            <!-- Total User -->
            <div class="stat">
                <div class="stat-figure text-success">
                    <x-heroicon-o-user-group class="w-8 h-8" />
                </div>
                <div class="stat-title">Total Users</div>
                <div class="stat-value text-success">{{ $totalUsers }}</div>
                <div class="stat-desc">Number of registered users in the system.</div>
            </div>

            <!-- Total Admin -->
            <div class="stat">
                <div class="stat-figure text-error">
                    <x-heroicon-o-shield-check class="w-8 h-8" />
                </div>
                <div class="stat-title">Total Admins</div>
                <div class="stat-value text-error">{{ $totalAdmins }}</div>
                <div class="stat-desc">Admins managing the system.</div>
            </div>

            <!-- Total Blog -->
            <div class="stat">
                <div class="stat-figure text-warning">
                    <x-heroicon-o-newspaper class="w-8 h-8" />
                </div>
                <div class="stat-title">Total Blogs</div>
                <div class="stat-value text-warning">{{ $totalBlogs }}</div>
                <div class="stat-desc">Total number of published blog articles.</div>
            </div>
        </div>

        <div class="flex flex-wrap justify-between gap-2">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col flex-1 w-full gap-2 h-[300px] rounded-sm shadow-sm p-4">
                <h1 class="font-medium text-primary">Users Overview</h1>
                <div class="w-full h-full">
                    <canvas id="myUsersChart" data-users='@json($usersPerYear)'></canvas>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col flex-1 w-full gap-2 h-[300px] rounded-sm shadow-sm p-4">
                <h1 class="font-medium text-primary">Predicted Employment Rate</h1>
                <div class="w-full h-full">
                    <canvas id="myPredictedEmploymentRate" data-employment='@json($employmentRatePerYear)'></canvas>
                </div>
            </div>
        </div>
    </main>
</x-layout.app>