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

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-2">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-3 p-5 rounded-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <h1 class="text-md font-medium">Control Management</h1>
                </div>
                <div class="flex min-h-[70px]">
                    <p class="text-sm text-gray-500">Manage and monitor all admin accounts within the system. Super Admins have the authority to create and control other admin users.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.dashboard.control') }}" class="btn btn-sm btn-outline btn-primary">Manage</a>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-3 p-5 rounded-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <h1 class="text-md font-medium">Client Management</h1>
                </div>
                <div class="flex min-h-[70px]">
                    <p class="text-sm text-gray-500">Oversee and manage all student accounts efficiently. Monitor their career assessment results, information, and system engagement.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.dashboard.client') }}" class="btn btn-sm btn-outline btn-primary">Manage</a>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-3 p-5 rounded-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <h1 class="text-md font-medium">Blog Management</h1>
                </div>
                <div class="flex min-h-[70px]">
                    <p class="text-sm text-gray-500">Oversee products, track orders, manage inventory, and handle transactions — to store running efficiently.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.dashboard.blogs') }}" class="btn btn-sm btn-outline btn-primary">Manage</a>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="flex flex-col gap-3 p-5 rounded-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <h1 class="text-md font-medium">System Demo</h1>
                </div>
                <div class="flex min-h-[70px]">
                    <p class="text-sm text-gray-500">Watch a comprehensive video tutorial on how to use and navigate the admin dashboard effectively.</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="admin_video_modal.showModal()" class="btn btn-sm btn-outline btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Watch Demo
                    </button>
                </div>
            </div>
        </div>

        {{-- Admin Video Modal --}}
        <dialog id="admin_video_modal" class="modal">
            <div class="modal-box max-w-4xl w-full">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="font-bold text-lg mb-4">Admin Dashboard Tutorial</h3>
                <div class="aspect-video w-full">
                    <video id="admin_demo_video" class="w-full h-full rounded-lg" controls>
                        <source src="{{ asset('videos/admin.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button onclick="document.getElementById('admin_demo_video').pause();">close</button>
            </form>
        </dialog>

        <script>
            // Pause video when modal is closed
            document.getElementById('admin_video_modal').addEventListener('close', function() {
                document.getElementById('admin_demo_video').pause();
            });
        </script>

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