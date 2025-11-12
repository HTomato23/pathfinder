
<x-layout.client title="Blogs">
    <x-layout.client.navbar></x-layout.client.navbar>

    <div class="absolute right-0 top-0 -z-10 transform-gpu overflow-hidden blur-3xl sm:top-10" aria-hidden="true">
        <div class="relative left-[calc(50%-8rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[25deg] bg-gradient-to-tr from-[#34d399] to-[#65a30d] opacity-30 dark:opacity-20 sm:left-[calc(50%-26rem)] sm:w-[72rem]" style="clip-path: polygon(20% 10%, 40% 0%, 70% 15%, 85% 35%, 95% 60%, 80% 80%, 60% 90%, 30% 100%, 15% 80%, 5% 50%)"></div>
    </div>

    <!-- Header Text -->
    <div class="w-[85%] mx-auto py-40">
        <div class="reveal text-4xl sm:text-5xl lg:text-7xl text-center font-semibold font-poppins bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent p-3"> Your source for career tips, growth hacks, and guidance. </div>
    </div>

    <div class="w-[85%] mx-auto mb-10" x-data="blogTable()" x-init="init()">
        <div class="relative"> 
            <!-- Loading Overlay -->
            <div x-show="loading"
                class="absolute inset-0 bg-base-100/50 backdrop-blur-sm flex items-center justify-center z-50 rounded-sm"
                x-transition>
                <span class="loading loading-spinner loading-lg"></span>
            </div>

            <div class="flex flex-wrap justify-center gap-6 font-outfit">
                <template x-if="blogs.length === 0 && !loading">
                    <div class="flex flex-col items-center gap-2 w-full justify-center min-h-[400px]">
                        <x-heroicon-o-magnifying-glass class="w-12 h-12 text-primary" />
                        <p class="text-base-content/70 text-center">No results found</p>
                    </div>
                </template>

                <template x-for="blog in blogs" :key="blog.id">
                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal-stagger w-full max-w-sm shadow-sm rounded-sm flex flex-col transition-transform duration-300 hover:scale-105">
                        <div class="flex flex-col flex-1 mt-2 px-4 pt-2">
                            <h1 class="text-xl font-medium font-poppins line-clamp-2 min-h-[3rem]" x-text="blog.title"></h1>
                            <p class="text-sm mt-2 min-h-[4.5rem] text-gray-500 break-words"
                                x-text="(blog.description.split(' ').length > 20 ? blog.description.split(' ').slice(0, 20).join(' ') : blog.description).substring(0, 100) + (blog.description.length > 100 ? '...' : '')">
                            </p>
                            <hr class="" />
                            <div class="flex justify-between gap-3 py-5">
                                <div class="flex items-center gap-2 w-[70%]">
                                    <div class="avatar avatar-placeholder">
                                        <div class="bg-neutral text-neutral-content w-12 rounded-full">
                                            <span class="text-sm" x-text="blog.author ? (blog.author.first_name.charAt(0) + blog.author.last_name.charAt(0)).toUpperCase() : 'Unknown Author'"></span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="text-xs" x-text="blog.author.first_name + ' ' + blog.author.last_name">Author Name</div>
                                        <div class="text-xs" 
                                            x-text="new Date(blog.created_at).toLocaleDateString('en-US', { 
                                                year: 'numeric', 
                                                month: 'long', 
                                                day: 'numeric' 
                                            })">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end w-[30%]">
                                    <a :href="`/blogs/${blog.id}`" class="underline text-sm">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Pagination - Now INSIDE the Alpine component -->
        <div x-show="lastPage > 1" class="flex justify-center mt-8" x-cloak>
            <div class="join">
                <!-- Previous Button -->
                <button @click="loadPage(currentPage - 1)" 
                    :disabled="currentPage === 1"
                    :class="currentPage === 1 ? 'btn-disabled' : ''"
                    class="join-item btn btn-sm">«</button>

                <!-- Page Numbers -->
                <template x-for="page in pages" :key="page">
                    <button @click="loadPage(page)" 
                        :class="page === currentPage ? 'btn-active' : ''"
                        class="join-item btn btn-sm" 
                        x-text="page"></button>
                </template>

                <!-- Next Button -->
                <button @click="loadPage(currentPage + 1)" 
                    :disabled="currentPage >= lastPage"
                    :class="currentPage >= lastPage ? 'btn-disabled' : ''"
                    class="join-item btn btn-sm">»</button>
            </div>        
        </div>

        <!-- Debug Info (Optional - Remove in production) -->
        <div x-show="lastPage > 0" class="text-center text-sm text-gray-500 mt-5" x-cloak>
            Page <span x-text="currentPage"></span> of <span x-text="lastPage"></span>
            (<span x-text="blogs.length"></span> blogs on this page)
        </div>
    </div>

    {{-- Footer --}}
    <x-layout.client.footer></x-layout.client.footer>

    <script>
        function blogTable() {
            return {
                blogs: {!! json_encode($blogs->items(), JSON_UNESCAPED_SLASHES) !!},
                currentPage: parseInt({{ $blogs->currentPage() }}),
                lastPage: parseInt({{ $blogs->lastPage() }}),
                loading: false,
                searchTitle: '{{ request("title", "") }}',
                searchTimeout: null,

                get pages() {
                    const total = this.lastPage;
                    const current = this.currentPage;
                    const visible = 5; // Show 5 page numbers at a time

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
                    console.log('Total blogs on page:', this.blogs.length);
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
                    if (page < 1 || page > this.lastPage || this.loading) {
                        console.log('Navigation blocked:', { page, lastPage: this.lastPage, loading: this.loading });
                        return;
                    }

                    this.loading = true;

                    try {
                        const queryParams = this.buildQueryParams(page);
                        const response = await fetch(`{{ route('blogs') }}?${queryParams}`, {
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

                        this.blogs = data.data;
                        this.currentPage = parseInt(data.current_page);
                        this.lastPage = parseInt(data.last_page);

                        // Scroll to top smoothly
                        window.scrollTo({ top: 0, behavior: 'smooth' });

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
            }
        }
    </script>
</x-layout.client>