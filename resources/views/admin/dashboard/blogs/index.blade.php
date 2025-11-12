<x-layout.app title="Blogs">
    <x-layout.admin.admin-sidebar></x-layout.admin.admin-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]" x-data="blogTable()" x-init="init()">
        <x-layout.admin.admin-navbar page="Blogs"></x-layout.admin.admin-navbar>

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

         <!-- Blog Statistics -->
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
            class="stats font-outfit shadow-sm rounded-sm w-full">
            <!-- Published -->
            <div class="stat">
                <div class="stat-figure text-success">
                    <x-heroicon-o-chart-bar class="w-8 h-8" />
                </div>
                <div class="stat-title">Published</div>
                <div class="stat-value text-success">{{ $statistics['published']['count'] }}</div>
                <div class="stat-desc">{{ $statistics['published']['percentage'] }}% of blogs are currently Published and visible online.</div>
            </div>

            <!-- Draft -->
            <div class="stat">
                <div class="stat-figure text-warning">
                    <x-heroicon-o-chart-bar class="w-8 h-8" />
                </div>
                <div class="stat-title">Draft</div>
                <div class="stat-value text-warning">{{ $statistics['draft']['count'] }}</div>
                <div class="stat-desc">{{ $statistics['draft']['percentage'] }}% of blogs are currently in Draft status.</div>
            </div>

            <!-- Archived -->
            <div class="stat">
                <div class="stat-figure text-default">
                    <x-heroicon-o-chart-bar class="w-8 h-8" />
                </div>
                <div class="stat-title">Archived</div>
                <div class="stat-value text-default">{{ $statistics['archived']['count'] }}</div>
                <div class="stat-desc">{{ $statistics['archived']['percentage'] }}% of blogs are currently Archived and no longer active.</div>
            </div>
        </div>

        <!-- Search Account & Action Button -->
        <div class="flex flex-col gap-y-4 xl:flex-row xl:gap-x-2 justify-between">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                class="p-5 w-full xl:w-2xl shadow-sm rounded-sm">
                <fieldset x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="fieldset border-base-300 rounded-box w-full border p-4">
                    <legend class="fieldset-legend">Search Blog</legend>
                    <form @submit.prevent="searchByTitle" class="w-full">
                        <input 
                            type="text" 
                            class="input w-full join-item" 
                            placeholder="Enter title" 
                            x-model="searchTitle"
                            @input="debounceSearch"
                        />
                    </form>
                    <div x-show="searchTitle.length > 0" class="mt-2">
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
                        <p>Easily manage your data, perform essential actions, and maintain smoother, more efficient workflows across your system—all with just a few simple clicks.</p>
                        <div class="card-actions justify-start">
                            <x-ui.button 
                                @click="reloadBlogs" 
                                x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" 
                                color="primary" 
                                size="xs">
                                Reload Blogs
                            </x-ui.button>
                            <x-ui.button href="{{ route('admin.dashboard.blogs.create') }}" x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="secondary" size="xs">Create blog</x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Blog -->
        <div class="flex flex-col gap-y-4 xl:flex-row xl:gap-x-2">
            <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="p-5 w-full shadow-sm rounded-sm">
                <h1 class="mb-2 font-medium flex items-center gap-2"><x-heroicon-o-funnel class="w-5 h-5" />Status</h1>
                <div class="filter">
                    <input class="btn filter-reset" type="radio" name="metaframeworks2" aria-label="X" @change="clearStatusFilter()" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-success mb-1" type="radio"
                        name="metaframeworks2" aria-label="Published" @change="filterByStatus('Published')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-warning" type="radio"
                        name="metaframeworks2" aria-label="Draft"  @change="filterByStatus('Draft')" />
                    <input x-cloak :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-default" type="radio"
                        name="metaframeworks2" aria-label="Archive"  @change="filterByStatus('Archived')" />
                </div>
            </div>
        </div>

        <div class="relative min-h-[500px]"> 
            <!-- Loading Overlay -->
            <div x-show="loading"
                class="absolute inset-0 bg-base-100/50 backdrop-blur-sm flex items-center justify-center z-50 rounded-sm"
                x-transition>
                <span class="loading loading-spinner loading-lg"></span>
            </div>

            <!-- Blog Cards -->
            <div class="flex flex-wrap justify-center lg:justify-start gap-6 font-outfit">
                <template x-if="blogs.length === 0 && !loading">
                    <div class="flex flex-col items-center gap-2 w-full justify-center min-h-[400px]">
                        <x-heroicon-o-magnifying-glass class="w-12 h-12 text-primary" />
                        <p class="text-base-content/70 text-center">No results found</p>
                    </div>
                </template>
                
                <template x-for="blog in blogs" :key="blog.id">
                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                        class="w-full max-w-sm shadow-sm rounded-sm flex flex-col">

                        <!-- Blog content -->
                        <div class="flex flex-col flex-1 mt-2 px-4 pt-2">
                            <h1 class="text-xl font-medium line-clamp-2 min-h-[3rem]" x-text="blog.title"></h1>
                            <p class="text-sm mt-2 line-clamp-3 min-h-[4.5rem] text-gray-500" 
                                x-text="(blog.description.split(' ').length > 20 ? blog.description.split(' ').slice(0, 20).join(' ') : blog.description).substring(0, 100) + (blog.description.length > 100 ? '...' : '')"></p>
                            <p class="text-xs" x-text="blog.author ? blog.author.first_name + ' ' + blog.author.last_name : 'Unknown Author'"></p>
                        </div>

                        <!-- View button -->
                        <div class="flex justify-between items-center p-4">
                            <x-ui.badge
                                x-bind:class="[
                                    $store.theme.isDark() ? 'badge-soft' : '',
                                    blog.status === 'Published' ? 'badge-success' :
                                    blog.status === 'Draft' ? 'badge-warning' :
                                    blog.status === 'Archived' ? 'badge-default' : ''
                                ].join(' ')"
                                size="sm"
                                x-text="blog.status">
                            </x-ui.badge>
                            <a :href="`/admin/dashboard/blogs/${blog.id}`" :class="$store.theme.isDark() ? 'btn-soft' : ''" class="btn btn-primary btn-sm">View</a>
                        </div>
                    </div>
                </template>
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
    </main>

    <script>
        function blogTable() {
            return {
                blogs: {!! json_encode($blogs->items(), JSON_UNESCAPED_SLASHES) !!},
                currentPage: {{ $blogs->currentPage() }},
                lastPage: {{ $blogs->lastPage() }},
                loading: false,
                searchTitle: '{{ request("title", "") }}',
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
                    
                    if (this.searchTitle.trim()) {
                        params.append('title', this.searchTitle.trim());
                    }
                    
                    if (this.statusFilter) {
                        params.append('status', this.statusFilter);
                    }
                    
                    return params.toString();
                },

                async loadPage(page) {
                    if (page < 1 || page > this.lastPage || this.loading) return;

                    this.loading = true;

                    try {
                        const queryParams = this.buildQueryParams(page);
                        const response = await fetch(`{{ route('admin.dashboard.blogs') }}?${queryParams}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        this.blogs = data.data;
                        this.currentPage = data.current_page;
                        this.lastPage = data.last_page;

                    } catch (error) {
                        console.error('Error loading page:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                debounceSearch() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.searchByTitle();
                    }, 500);
                },

                searchByTitle() {
                    this.currentPage = 1;
                    this.loadPage(1);
                },

                clearSearch() {
                    this.searchTitle = '';
                    this.searchByTitle();
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
                },

                reloadBlogs() {
                    // Clear all filters
                    this.searchTitle = '';
                    this.statusFilter = '';
                    
                    // Reset radio buttons
                    const radios = document.querySelectorAll('input[name="metaframeworks2"]');
                    radios.forEach(radio => radio.checked = false);
                    
                    // Reload first page
                    this.currentPage = 1;
                    this.loadPage(1);
                }
            }
        }
    </script>
</x-layout.app>