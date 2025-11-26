<x-layout.app title="Job Portal">
    <x-layout.admin.admin-sidebar />
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]" x-data="jobPortalTable()" x-init="init()">
        <x-layout.admin.admin-navbar page="Job Portal" />

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

        <!-- Statistics -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
            class="stats font-outfit shadow-sm rounded-sm w-full">
            <!-- Active -->
            <div class="stat">
                <div class="stat-figure text-success">
                    <x-heroicon-o-chart-bar class="w-8 h-8" />
                </div>
                <div class="stat-title">Active</div>
                <div class="stat-value text-success">{{ $statistics['active'] }}</div>
                <div class="stat-desc">Active job listings</div>
            </div>

            <!-- Inactive -->
            <div class="stat">
                <div class="stat-figure text-error">
                    <x-heroicon-o-chart-bar class="w-8 h-8" />
                </div>
                <div class="stat-title">Inactive</div>
                <div class="stat-value text-error">{{ $statistics['inactive'] }}</div>
                <div class="stat-desc">Inactive job listings</div>
            </div>
        </div>

        <!-- Search & Action Button -->
        <div class="flex flex-col gap-y-4 xl:flex-row xl:gap-x-2 justify-between">
            <div :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                class="p-5 w-full xl:w-2xl shadow-sm rounded-sm">
                <fieldset :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
                    class="fieldset border-base-300 rounded-box w-full border p-4">
                    <legend class="fieldset-legend">Search Job Portal</legend>
                    <form @submit.prevent="searchJobs" class="w-full">
                        <input 
                            type="text" 
                            class="input w-full join-item" 
                            placeholder="Search by title or description" 
                            x-model="searchQuery"
                            @input="debounceSearch"
                        />
                    </form>
                    <div x-show="searchQuery.length > 0" class="mt-2">
                        <button @click="clearSearch" class="btn btn-ghost btn-xs">
                            Clear Search
                        </button>
                    </div>
                </fieldset>
            </div>

            <div class="w-full">
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
                    class="card font-outfit shadow-sm rounded-sm w-full">
                    <div class="card-body">
                        <h2 class="card-title">Action</h2>
                        <p>Manage job portals, add new listings, and maintain efficient workflows across your system.</p>
                        <div class="card-actions justify-start">
                            <x-ui.button x-cloak @click="loadPage(currentPage)"
                                x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="primary"
                                size="xs">Reload Table</x-ui.button>
                            <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="secondary"
                                size="xs" onclick="my_modal_1.showModal()">Create Job Portal</x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-5 w-full shadow-sm rounded-sm">
            <h1 class="mb-2 font-medium flex items-center gap-2"><x-heroicon-o-funnel class="w-5 h-5" />Status</h1>
            <div class="filter">
                <input class="btn filter-reset" type="radio" name="metaframeworks2" aria-label="X" @change="clearStatusFilter" />
                <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-success mb-1" type="radio"
                    name="metaframeworks2" aria-label="Active" @change="filterByStatus('Active')" />
                <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-error" type="radio"
                    name="metaframeworks2" aria-label="Inactive" @change="filterByStatus('Inactive')" />
            </div>
        </div>

        <!-- Table Wrapper with Loading Overlay -->
        <div class="relative">
            <!-- Loading Overlay -->
            <div x-show="loading"
                class="absolute inset-0 bg-base-100/80 backdrop-blur-sm flex items-center justify-center z-50 rounded-sm"
                x-transition>
                <span class="loading loading-spinner loading-lg"></span>
            </div>

            <!-- Job Portal Table -->
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
                class="overflow-x-auto shadow-sm rounded-sm h-[500px]"
                x-ref="tableContainer">

                <table class="table font-outfit">
                    <thead x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="sticky top-0 z-40">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-if="jobs.length === 0 && !loading">
                            <tr>
                                <td colspan="6" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-2">
                                        <x-heroicon-o-magnifying-glass class="w-12 h-12 text-primary" />
                                        <p class="text-base-content/70">No job portals found</p>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-for="job in jobs" :key="job.id">
                            <tr>
                                <td x-text="job.id"></td>
                                <td x-text="job.title"></td>
                                <td>
                                    <x-ui.badge
                                        x-bind:class="[
                                            $store.theme.isDark() ? 'badge-soft' : '',
                                            job.status === 'Active' ? 'badge-success' : 'badge-error'
                                        ].join(' ')"
                                        size="sm"
                                        x-text="job.status">
                                    </x-ui.badge>
                                </td>
                                <td>
                                    <a :href="`/admin/dashboard/jobs/${job.id}`" 
                                       :class="$store.theme.isDark() ? 'btn-soft' : ''" 
                                       class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div x-cloak class="flex justify-end">
            <div class="join">
                <!-- Previous Button -->
                <button @click="loadPage(currentPage - 1)" :disabled="currentPage === 1"
                    class="join-item btn btn-sm">«</button>

                <!-- Page Numbers -->
                <template x-for="page in pages" :key="page">
                    <button @click="loadPage(page)" :class="page === currentPage ? 'btn-active' : ''"
                        class="join-item btn btn-sm" x-text="page"></button>
                </template>

                <!-- Next Button -->
                <button @click="loadPage(currentPage + 1)" :disabled="currentPage === lastPage"
                    class="join-item btn btn-sm">»</button>
            </div>        
        </div>

        {{-- Create Job Portal Modal --}}
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Add Job Portal</h3>
                </div>
                <form method="POST" action="{{ route('admin.dashboard.jobs.store') }}" 
                    x-data="{ submitting: false }" 
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf

                    <fieldset class="fieldset">
                        <!-- Title -->
                        <x-ui.form-label required>Title:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="text" name="title" placeholder="Job Portal Title" maxlength="100" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M4 7h16M4 12h16M4 17h10"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Max length of characters is 100
                        </p>

                        <!-- Description -->
                        <x-ui.form-label required>Description:</x-ui.form-label>
                        <textarea name="description" class="textarea textarea-bordered w-full" placeholder="Brief description" maxlength="500" required></textarea>
                        <p class="validator-hint hidden">
                            Max length of characters is 500
                        </p>

                        <!-- Link -->
                        <x-ui.form-label required>Link:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="url" name="link" placeholder="https://example.com" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>

                        <!-- Status -->
                        <x-ui.form-label required>Status:</x-ui.form-label>
                        <select name="status" class="select w-full validator" required>
                            <option disabled selected value="">Select status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>

                        <!-- Submit Button -->
                        <x-ui.button 
                            type="submit" 
                            color="primary" 
                            class="mt-4"
                            x-bind:disabled="submitting" 
                        >
                            <span x-show="!submitting">Create</span>
                            <span x-show="submitting" style="display: none">Creating <span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </main>

    <script>
        function jobPortalTable() {
            return {
                jobs: @json($jobs->items()),
                currentPage: {{ $jobs->currentPage() }},
                lastPage: {{ $jobs->lastPage() }},
                loading: false,
                searchQuery: '{{ request("search", "") }}',
                statusFilter: '{{ request("status", "") }}',
                searchTimeout: null,

                get pages() {
                    const total = this.lastPage;
                    const current = this.currentPage;
                    const visible = 3;

                    let start = Math.max(current - Math.floor(visible / 2), 1);
                    let end = start + visible - 1;

                    if (end > total) {
                        end = total;
                        start = Math.max(end - visible + 1, 1);
                    }

                    const pages = [];
                    for (let i = start; i <= end; i++) {
                        pages.push(i);
                    }

                    return pages;
                },

                init() {
                    // Initial load complete
                },

                buildQueryParams(page) {
                    const params = new URLSearchParams();
                    params.append('page', page);
                    
                    if (this.searchQuery.trim()) {
                        params.append('search', this.searchQuery.trim());
                    }
                    
                    if (this.statusFilter) {
                        params.append('status', this.statusFilter);
                    }
                    
                    return params.toString();
                },

                async loadPage(page) {
                    if (page < 1 || page > this.lastPage || this.loading) return;

                    // Scroll table to top BEFORE showing loading
                    if (this.$refs.tableContainer) {
                        this.$refs.tableContainer.scrollTop = 0;
                    }

                    this.loading = true;

                    try {
                        const queryParams = this.buildQueryParams(page);
                        const response = await fetch(`{{ route('admin.dashboard.jobs') }}?${queryParams}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        this.jobs = data.data;
                        this.currentPage = data.current_page;
                        this.lastPage = data.last_page;

                    } catch (error) {
                        console.error('Error loading page:', error);
                        alert('Failed to load page. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                },

                debounceSearch() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.searchJobs();
                    }, 500);
                },

                searchJobs() {
                    this.currentPage = 1;
                    this.loadPage(1);
                },

                clearSearch() {
                    this.searchQuery = '';
                    this.searchJobs();
                },

                filterByStatus(status) {
                    this.statusFilter = status;
                    this.currentPage = 1;
                    this.loadPage(1);
                },

                clearStatusFilter() {
                    this.statusFilter = '';
                    this.currentPage = 1;
                    this.loadPage(1);
                }
            }
        }
    </script>
</x-layout.app>