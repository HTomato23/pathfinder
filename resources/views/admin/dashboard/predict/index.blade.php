<x-layout.app title="Predict & Analysis">
    <x-layout.admin.admin-sidebar></x-layout.admin.admin-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]" x-data="clientTable()" x-init="init()">
        <x-layout.admin.admin-navbar page="Predict & Analysis"></x-layout.admin.admin-navbar>
        
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

        {{-- Employability Standardization --}}
        <div class="flex flex-col xl:flex-row gap-2">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="stats shadow w-full">
                <div class="stat text-success">
                    <div class="stat-figure">
                        <x-heroicon-o-user-plus class="w-8 h-8" />
                    </div>
                    <div class="stat-title">High Probability</div>
                    <div class="stat-value">75% - 100%</div>
                    <div class="stat-desc">{{ $statistics['high']['count'] }} Students</div>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"class="stats shadow w-full">
                <div class="stat text-warning">
                    <div class="stat-figure">
                        <x-heroicon-o-user class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Medium Probability</div>
                    <div class="stat-value">50% - 74%</div>
                    <div class="stat-desc">{{ $statistics['medium']['count'] }} Students</div>
                </div>
            </div>
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="stats shadow w-full">
                <div class="stat text-error">
                    <div class="stat-figure">
                        <x-heroicon-o-user-minus class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Low Probability</div>
                    <div class="stat-value">0% - 49%</div>
                    <div class="stat-desc">{{ $statistics['low']['count'] }} Students</div>
                </div>
            </div>
        </div>

        <!-- Search Account & Action Button -->
        <div class="flex flex-col gap-y-4 xl:flex-row xl:gap-x-2 justify-between">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                class="p-5 w-full xl:w-2xl shadow-sm rounded-sm">
                <fieldset :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
                    class="fieldset border-base-300 rounded-box w-full border p-4">
                    <legend class="fieldset-legend">Search Student ID</legend>
                   <form @submit.prevent="searchByStudentId" class="w-full">
                        <input 
                            type="text" 
                            class="input w-full join-item" 
                            placeholder="e.g 22-00632" 
                            x-model="studentId"
                            maxlength="8"
                            @input="studentId = sanitizeStudentId($event.target.value); debounceSearch()"
                        />
                    </form>
                    <div x-show="studentId.length > 0" class="mt-2">
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
                        <p>Easily manage your data, perform essential actions, and maintain smoother, more efficient
                            workflows across your system—all with just a few simple clicks.</p>
                        <div class="card-actions justify-start">
                            <x-ui.button x-cloak @click="loadPage(currentPage)"
                                x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="primary"
                                size="xs">Reload Table</x-ui.button>
                            <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="secondary"
                                size="xs" @click="window.open('{{ route('admin.dashboard.predict.report') }}')">Print Report</x-ui.button>
                            <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="accent"
                                size="xs" @click="window.open(`{{ route('admin.dashboard.predict.print') }}?program=${programFilter}&year=${yearFilter}&employable=${employableFilter}`)">Print Table</x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Account -->
        <div class="flex flex-col gap-y-4 xl:flex-row xl:gap-x-2">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-5 w-full shadow-sm rounded-sm">
                <h1 class="mb-2 font-medium flex items-center gap-2"><x-heroicon-o-funnel class="w-5 h-5" />Program</h1>
               <div class="filter">
                    <input class="btn filter-reset" type="radio" name="programFilter" aria-label="X" @change="clearProgramFilter" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-secondary mb-1" type="radio" name="programFilter" aria-label="BSHM" @change="filterByProgram('BSHM')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-neutral text-white" type="radio" name="programFilter" aria-label="BSIT" @change="filterByProgram('BSIT')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-default" type="radio" name="programFilter" aria-label="BSCS" @change="filterByProgram('BSCS')" />
                </div>
            </div>

            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-5 w-full shadow-sm rounded-sm">
                <h1 class="mb-2 font-medium flex items-center gap-2"><x-heroicon-o-funnel class="w-5 h-5" />Year Level</h1>
                <div class="filter">
                    <input class="btn filter-reset" type="radio" name="metaframeworks1" aria-label="X" @change="clearYearFilter" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-info mb-1" type="radio" name="metaframeworks1" aria-label="1st Year" @change="filterByYear('1st Year')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-warning mb-1" type="radio" name="metaframeworks1" aria-label="2nd Year" @change="filterByYear('2nd Year')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-accent mb-1" type="radio" name="metaframeworks1" aria-label="3rd Year" @change="filterByYear('3rd Year')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-primary mb-1" type="radio" name="metaframeworks1" aria-label="4th Year" @change="filterByYear('4th Year')" />
                </div>
            </div>
            
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-5 w-full shadow-sm rounded-sm">
                <h1 class="mb-2 font-medium flex items-center gap-2"><x-heroicon-o-funnel class="w-5 h-5" />Employability</h1>
                <div class="filter">
                    <input class="btn filter-reset" type="radio" name="employableFilter" aria-label="X" @change="clearEmployableFilter" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-success mb-1" type="radio" name="employableFilter" aria-label="Employable" @change="filterByEmployable('Employable')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-error" type="radio" name="employableFilter" aria-label="Not Employable" @change="filterByEmployable('Not Employable')" />
                </div>
            </div>
        </div>

        <!-- Client Table Wrapper with Fixed Loading Overlay -->
        <div class="relative">
            <!-- Loading Overlay - Now OUTSIDE the scrollable container -->
            <div x-show="loading"
                class="absolute inset-0 bg-base-100/80 backdrop-blur-sm flex items-center justify-center z-50 rounded-sm"
                x-transition>
                <span class="loading loading-spinner loading-lg"></span>
            </div>

            <!-- Client Table -->
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
                class="overflow-x-auto shadow-sm rounded-sm h-[500px]"
                x-ref="tableContainer">

                <table class="table font-outfit">
                    <thead x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="sticky top-0 z-40">
                        <tr>
                            <th>ID</th>
                            <th>Student ID</th>
                            <th>Details</th>
                            <th>Program</th>
                            <th>Year Level</th>
                            <th>Employability</th>
                            <th>Probability</th>
                            <th>Employment Rate</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-if="clients.length === 0 && !loading">
                            <tr>
                                <td colspan="9" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-2">
                                        <x-heroicon-o-magnifying-glass class="w-12 h-12 text-primary" />
                                        <p class="text-base-content/70">No results found</p>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-for="client in clients" :key="client.id">
                            <tr>
                                <td x-text="client.id"></td>
                                <td x-text="client.student_id"></td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar avatar-placeholder no-print">
                                            <div class="bg-neutral text-neutral-content w-12 rounded-full">
                                                <span class="text-sm"
                                                    x-text="(client.first_name.charAt(0) + client.last_name.charAt(0)).toUpperCase()">>
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm" x-text="client.first_name"></div>
                                            <div class="text-sm" x-text="client.last_name"></div>
                                        </div>
                                    </div>
                                </td>
                                <td x-text="client.program"></td>
                                <td x-text="client.year_level"></td>
                                <td>
                                   <x-ui.badge
                                        class="whitespace-nowrap"
                                        x-bind:class="[
                                            $store.theme.isDark() ? 'badge-soft' : '',
                                            client.employability === 'Employable' ? 'badge-success' : 'badge-error'
                                        ].join(' ')"
                                        size="sm"
                                        x-text="client.employability">
                                    </x-ui.badge>
                                </td>
                                <td x-text="client.employability_probability"></td>
                                <td x-text="client.predicted_employment_rate"></td>
                                <td>
                                    <a :href="`/admin/dashboard/client/${client.id}`" :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-primary btn-sm">View</a>
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

        <script>
            function clientTable() {
                return {
                    clients: @json($clients->items()),
                    currentPage: {{ $clients->currentPage() }},
                    lastPage: {{ $clients->lastPage() }},
                    loading: false,
                    studentId: '{{ request("student_id", "") }}',
                    programFilter: '{{ request("program", "") }}',
                    yearFilter: '{{ request("year", "") }}',
                    employableFilter: '{{ request("employable", "") }}',
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

                    sanitizeStudentId(input) {
                        input = input.replace(/[^0-9]/g, '');
                        if (input.length > 2) {
                            input = input.slice(0, 2) + '-' + input.slice(2);
                        }
                        return input.slice(0, 8);
                    },

                    init() {
                        // Initial load complete
                    },

                    buildQueryParams(page) {
                        const params = new URLSearchParams();
                        params.append('page', page);
                        
                        if (this.studentId.trim()) {
                            params.append('student_id', this.studentId.trim());
                        }

                        if (this.programFilter) {
                            params.append('program', this.programFilter);
                        }

                        if (this.yearFilter) {
                            params.append('year', this.yearFilter);
                        }

                        if (this.employableFilter) {
                            params.append('employable', this.employableFilter);
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
                            const response = await fetch(`{{ route('admin.dashboard.predict') }}?${queryParams}`, {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await response.json();

                            this.clients = data.data;
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
                            this.searchByStudentId();
                        }, 500);
                    },

                    searchByStudentId() {
                        this.currentPage = 1;
                        this.loadPage(1);
                    },

                    clearSearch() {
                        this.studentId = '';
                        this.searchByStudentId();
                    },

                    filterByProgram(program) {
                        this.programFilter = program;
                        this.currentPage = 1;
                        this.loadPage(1);
                    },

                    clearProgramFilter() {
                        this.programFilter = '';
                        this.currentPage = 1;
                        this.loadPage(1);
                    },

                    filterByYear(year) {
                        this.yearFilter = year;
                        this.currentPage = 1;
                        this.loadPage(1);
                    },

                    clearYearFilter() {
                        this.yearFilter = '';
                        this.currentPage = 1;
                        this.loadPage(1);
                    },

                    filterByEmployable(employable) {
                        this.employableFilter = employable;
                        this.currentPage = 1;
                        this.loadPage(1);
                    },

                    clearEmployableFilter() {
                        this.employableFilter = '';
                        this.currentPage = 1;
                        this.loadPage(1);
                    }
                }
            }
        </script>
    </main>
</x-layout.app>