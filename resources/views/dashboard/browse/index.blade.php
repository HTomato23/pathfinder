<x-layout.client title="Browse Jobs">
    <x-layout.client.client-sidebar></x-layout.client.client-sidebar>
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]" x-data="jobTable()" x-init="init()">
        <x-layout.client.client-navbar page="Browse Jobs"></x-layout.client.client-navbar>

        <div class="relative">
            <!-- Loading Overlay -->
            <div x-show="loading"
                class="absolute inset-0 bg-base-100/80 backdrop-blur-sm flex items-center justify-center z-50 rounded-sm"
                x-transition>
                <span class="loading loading-spinner loading-lg"></span>
            </div>

            <ul x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                class="list rounded-box shadow-md w-full h-full overflow-hidden">

                <template x-if="jobs.length === 0 && !loading">
                    <li class="flex flex-col items-center gap-2 py-20">
                        <x-heroicon-o-magnifying-glass class="w-12 h-12 text-primary" />
                        <p class="text-base-content/70 text-center">No job portals found</p>
                    </li>
                </template>

                <template x-for="(job, index) in jobs" :key="job.id">
                    <li class="reveal-stagger list-row transition-transform duration-300 hover:text-white hover:bg-accent-content">
                        <div class="text-4xl font-thin opacity-30 tabular-nums" x-text="index + 1"></div>
                        <div class="list-col-grow">
                            <div class="" x-text="job.title"></div>
                            <div class="text-xs uppercase font-semibold opacity-60" x-text="job.description"></div>
                        </div>
                        <a x-bind:href="job.link" target="_blank" class="btn btn-ghost btn-square">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                        </a>
                    </li>
                </template>
            </ul>
        </div>

        <!-- Pagination -->
        <div x-show="lastPage > 1" class="flex justify-center mt-8" x-cloak>
            <div class="join">
                <!-- Previous Button -->
                <button @click="loadPage(currentPage - 1)" 
                    x-bind:disabled="currentPage === 1"
                    x-bind:class="currentPage === 1 ? 'btn-disabled' : ''"
                    class="join-item btn btn-sm">«</button>

                <!-- Page Numbers -->
                <template x-for="page in pages" :key="page">
                    <button @click="loadPage(page)" 
                        x-bind:class="page === currentPage ? 'btn-active' : ''"
                        class="join-item btn btn-sm" 
                        x-text="page"></button>
                </template>

                <!-- Next Button -->
                <button @click="loadPage(currentPage + 1)" 
                    x-bind:disabled="currentPage >= lastPage"
                    x-bind:class="currentPage >= lastPage ? 'btn-disabled' : ''"
                    class="join-item btn btn-sm">»</button>
            </div>        
        </div>

        <!-- Debug Info (Optional - Remove in production) -->
        <div x-show="lastPage > 0" class="text-center text-sm text-gray-500 mt-5" x-cloak>
            Page <span x-text="currentPage"></span> of <span x-text="lastPage"></span>
            (<span x-text="jobs.length"></span> job portals on this page)
        </div>
    </main>

    <script>
        function jobTable() {
            return {
                jobs: {!! json_encode($jobs->items(), JSON_UNESCAPED_SLASHES) !!},
                currentPage: parseInt({{ $jobs->currentPage() }}),
                lastPage: parseInt({{ $jobs->lastPage() }}),
                loading: false,

                get pages() {
                    const total = this.lastPage;
                    const current = this.currentPage;
                    const visible = 5;

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
                    console.log('Initialized - Current Page:', this.currentPage, 'Last Page:', this.lastPage);
                    console.log('Total jobs on page:', this.jobs.length);
                },

                buildQueryParams(page) {
                    const params = new URLSearchParams();
                    params.append('page', page);
                    return params.toString();
                },

                async loadPage(page) {
                    if (page < 1 || page > this.lastPage || this.loading) {
                        console.log('Navigation blocked:', { page, lastPage: this.lastPage, loading: this.loading });
                        return;
                    }

                    this.loading = true;

                    try {
                        const queryParams = this.buildQueryParams(page);
                        const response = await fetch(`{{ route('browse.jobs') }}?${queryParams}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        this.jobs = data.data;
                        this.currentPage = parseInt(data.current_page);
                        this.lastPage = parseInt(data.last_page);

                        console.log('Page loaded:', this.currentPage, 'of', this.lastPage);
                        console.log('Jobs loaded:', this.jobs.length);

                        // Scroll to top smoothly
                        window.scrollTo({ top: 0, behavior: 'smooth' });

                    } catch (error) {
                        console.error('Error loading page:', error);
                        alert('Failed to load page. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</x-layout.client>