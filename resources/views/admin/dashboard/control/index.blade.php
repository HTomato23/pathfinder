<x-layout.app title="Control">
    <x-layout.admin.admin-sidebar></x-layout.admin.admin-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]" x-data="adminTable()" x-init="init()">
        <x-layout.admin.admin-navbar page="Control"></x-layout.admin.admin-navbar>

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

        <!-- Admin Statistics -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
            class="stats font-outfit shadow-sm rounded-sm w-full">
            <!-- Online -->
            <div class="stat">
                <div class="stat-figure text-success">
                    <x-heroicon-o-chart-bar class="w-8 h-8" />
                </div>
                <div class="stat-title">Online</div>
                <div class="stat-value text-success">{{ $statistics['online']['count'] }}</div>
                <div class="stat-desc">{{ $statistics['online']['percentage'] }}% of users are actively online at the moment.</div>
            </div>

            <!-- Offline -->
            <div class="stat">
                <div class="stat-figure text-error">
                    <x-heroicon-o-chart-bar class="w-8 h-8" />
                </div>
                <div class="stat-title">Offline</div>
                <div class="stat-value text-error">{{ $statistics['offline']['count'] }}</div>
                <div class="stat-desc">{{ $statistics['offline']['percentage'] }}% of users are not active at the moment.</div>
            </div>

            <!-- Disabled -->
            <div class="stat">
                <div class="stat-figure text-warning">
                    <x-heroicon-o-chart-bar class="w-8 h-8" />
                </div>
                <div class="stat-title">Disabled</div>
                <div class="stat-value text-warning">{{ $statistics['disabled']['percentage'] }}</div>
                <div class="stat-desc">{{ $statistics['disabled']['percentage'] }}% of user accounts have been disabled.</div>
            </div>
        </div>

        <!-- Search Account & Action Button -->
        <div class="flex flex-col gap-y-4 xl:flex-row xl:gap-x-2 justify-between">
            <div :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                class="p-5 w-full xl:w-2xl shadow-sm rounded-sm">
                <fieldset :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
                    class="fieldset border-base-300 rounded-box w-full border p-4">
                    <legend class="fieldset-legend">Search Account</legend>
                    <form @submit.prevent="searchByEmail" class="w-full">
                        <input 
                            type="text" 
                            class="input w-full join-item" 
                            placeholder="Enter email address" 
                            x-model="searchEmail"
                            @input="debounceSearch"
                        />
                    </form>
                    <div x-show="searchEmail.length > 0" class="mt-2">
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
                                size="xs" onclick="my_modal_1.showModal()">Create account</x-ui.button>
                            <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="accent"
                                size="xs" @click="window.open(`{{ route('admin.dashboard.control.print') }}?status=${statusFilter}`)">Print Table</x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Account -->
        <div class="flex flex-col gap-y-4 xl:flex-row xl:gap-x-2">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-5 w-full shadow-sm rounded-sm">
                <h1 class="mb-2 font-medium flex items-center gap-2"><x-heroicon-o-funnel class="w-5 h-5" />Role</h1>
                <div class="filter">
                    <input class="btn filter-reset" type="radio" name="metaframeworks1" aria-label="X" @change="clearRoleFilter" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-info mb-1" type="radio"
                        name="metaframeworks1" aria-label="Administrator" @change="filterByRole('Administrator')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-neutral text-white mb-1" type="radio" 
                        name="metaframeworks1" aria-label="Consultant" @change="filterByRole('Consultant')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-default mb-1" type="radio" 
                        name="metaframeworks1" aria-label="Blog Moderator" @change="filterByRole('Blog Moderator')" />
                </div>
            </div>

            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-5 w-full shadow-sm rounded-sm">
                <h1 class="mb-2 font-medium flex items-center gap-2"><x-heroicon-o-funnel class="w-5 h-5" />Status</h1>
                <div class="filter">
                    <input class="btn filter-reset" type="radio" name="metaframeworks2" aria-label="X" @change="clearStatusFilter" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-success mb-1" type="radio"
                        name="metaframeworks2" aria-label="Online" @change="filterByStatus('Online')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-error" type="radio"
                        name="metaframeworks2" aria-label="Offline" @change="filterByStatus('Offline')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-warning" type="radio"
                        name="metaframeworks2" aria-label="Disabled" @change="filterByStatus('Disabled')" />
                </div>
            </div>
        </div>

        <!-- Admin Table Wrapper with Fixed Loading Overlay -->
        <div class="relative">
            <!-- Loading Overlay - Now OUTSIDE the scrollable container -->
            <div x-show="loading"
                class="absolute inset-0 bg-base-100/80 backdrop-blur-sm flex items-center justify-center z-50 rounded-sm"
                x-transition>
                <span class="loading loading-spinner loading-lg"></span>
            </div>

            <!-- Admin Table -->
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"
                class="overflow-x-auto shadow-sm rounded-sm h-[500px]"
                x-ref="tableContainer">

                <table class="table font-outfit">
                    <thead x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"  class="sticky top-0 z-40">
                        <tr>
                            <th>ID</th>
                            <th>Details</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-if="admins.length === 0 && !loading">
                            <tr>
                                <td colspan="6" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-2">
                                        <x-heroicon-o-magnifying-glass class="w-12 h-12 text-primary" />
                                        <p class="text-base-content/70">No results found</p>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-for="admin in admins" :key="admin.admin_id">
                            <tr>
                                <td x-text="admin.admin_id"></td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar avatar-placeholder no-print">
                                            <div class="bg-neutral text-neutral-content w-12 rounded-full">
                                                <span class="text-sm"
                                                    x-text="(admin.first_name.charAt(0) + admin.last_name.charAt(0)).toUpperCase()">>
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm" x-text="admin.first_name"></div>
                                            <div class="text-sm" x-text="admin.last_name"></div>
                                        </div>
                                    </div>
                                </td>
                                <td x-text="admin.email"></td>
                                <td x-text="admin.role"></td>
                                <td>
                                    <x-ui.badge
                                        x-bind:class="[
                                            $store.theme.isDark() ? 'badge-soft' : '',
                                            admin.status === 'Online' ? 'badge-success' :
                                            admin.status === 'Offline' ? 'badge-error' :
                                            admin.status === 'Disabled' ? 'badge-warning' : ''
                                        ].join(' ')"
                                        size="sm"
                                        x-text="admin.status">
                                    </x-ui.badge>
                                </td>
                                <td>
                                    <a :href="`/admin/dashboard/control/${admin.admin_id}`" :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-primary btn-sm">View</a>
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

        {{-- Create Account --}}
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Create Account</h3>
                </div>
                <form method="POST" action="{{ route('admin.dashboard.control.store') }}" 
                    x-data="{ submitting: false, firstName: '', lastName: '', sanitizeName(input){ return input.replace(/[^a-zA-ZñÑ\s.'-]/g, ''); } }" 
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf

                    <fieldset x-data="{ show: false }" class="fieldset">

                        <!-- First Name -->
                        <x-ui.form-label required>First Name:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="text" name="first_name" x-model="firstName" @input="firstName = sanitizeName(firstName)" placeholder="First Name" maxlength="50" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Max length of characters is 50
                        </p>

                        <!-- Last Name -->
                        <x-ui.form-label required>Last Name:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="text" name="last_name" x-model="lastName" @input="lastName = sanitizeName(lastName)" placeholder="Last Name" maxlength="50" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Max length of characters is 50
                        </p>

                        <!-- Email -->
                        <x-ui.form-label required>Email:</x-ui.form-label>
                        <x-ui.form-input class="validator" type="email" name="email" placeholder="mail@plpasig.edu.ph" pattern=".*@plpasig\.edu\.ph$"  title="Email must end with @plpasig.edu.ph" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Email must end with @plpasig.edu.ph
                        </p>

                        {{-- Role --}}
                        <x-ui.form-label required>Select a role:</x-ui.form-label>
                        <select name="role" class="select w-full validator" required>
                            <option disabled selected value="">Select a role</option>
                            <option value="Administrator">Administrator</option>
                            <option value="Consultant">Consultant</option>
                            <option value="Blog Moderator">Blog Moderator</option>
                        </select>
                        <p class="validator-hint hidden">
                            Please select a role
                        </p>

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
        function adminTable() {
            return {
                admins: @json($admins->items()),
                currentPage: {{ $admins->currentPage() }},
                lastPage: {{ $admins->lastPage() }},
                loading: false,
                searchEmail: '{{ request("email", "") }}',
                roleFilter: '{{ request("role", "") }}',
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
                    
                    if (this.searchEmail.trim()) {
                        params.append('email', this.searchEmail.trim());
                    }
                    
                    if (this.roleFilter) {
                        params.append('role', this.roleFilter);
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
                        const response = await fetch(`{{ route('admin.dashboard.control') }}?${queryParams}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        this.admins = data.data;
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
                        this.searchByEmail();
                    }, 500);
                },

                searchByEmail() {
                    this.currentPage = 1;
                    this.loadPage(1);
                },

                clearSearch() {
                    this.searchEmail = '';
                    this.searchByEmail();
                },

                filterByRole(role) {
                    this.roleFilter = role;
                    this.currentPage = 1;
                    this.loadPage(1);
                },

                clearRoleFilter() {
                    this.roleFilter = '';
                    this.currentPage = 1;
                    this.loadPage(1);
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