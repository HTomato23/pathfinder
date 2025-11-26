<x-layout.client title="Feedbacks">
    <x-layout.client.navbar />

    <div class="absolute right-0 top-0 -z-10 transform-gpu overflow-hidden blur-3xl sm:top-10" aria-hidden="true">
        <div class="relative left-[calc(50%-8rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[25deg] bg-gradient-to-tr from-[#34d399] to-[#65a30d] opacity-30 dark:opacity-20 sm:left-[calc(50%-26rem)] sm:w-[72rem]" style="clip-path: polygon(20% 10%, 40% 0%, 70% 15%, 85% 35%, 95% 60%, 80% 80%, 60% 90%, 30% 100%, 15% 80%, 5% 50%)"></div>
    </div>

    <!-- Header Text -->
    <div class="w-[85%] mx-auto py-40">
        <div class="reveal text-4xl sm:text-5xl lg:text-7xl text-center font-semibold font-poppins bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent p-3">
            What Our Users Say
        </div>
        <p class="reveal text-center text-base sm:text-lg opacity-70 mt-4 max-w-3xl mx-auto">
            Real experiences from students who found their path with Pathfinder
        </p>
    </div>

    <div class="w-[85%] mx-auto mb-10" x-data="feedbackTable()" x-init="init()">
        <div class="relative">
            <!-- Loading Overlay -->
            <div x-show="loading"
                class="absolute inset-0 bg-base-100/50 backdrop-blur-sm flex items-center justify-center z-50 rounded-sm"
                x-transition>
                <span class="loading loading-spinner loading-lg"></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 font-outfit">
                <template x-if="feedbacks.length === 0 && !loading">
                    <div class="col-span-full flex flex-col items-center gap-2 w-full justify-center min-h-[400px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-base-content/70 text-center text-xl font-semibold">No feedback found</p>
                        <p class="text-base-content/50 text-center text-sm">Be the first to share your experience!</p>
                    </div>
                </template>

                <template x-for="feedback in feedbacks" :key="feedback.id">
                    <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                         class="reveal-stagger card bg-base-100 shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105">
                        <div class="card-body">
                            <!-- User Info -->
                            <div class="flex items-center gap-3 mb-3">
                                <div class="avatar avatar-placeholder">
                                    <div class="bg-green-700 text-white w-12 rounded-full">
                                        <span class="text-sm" 
                                              x-text="feedback.user ? (feedback.user.first_name.charAt(0) + feedback.user.last_name.charAt(0)).toUpperCase() : 'NA'">
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm truncate" 
                                       x-text="feedback.user ? feedback.user.first_name + ' ' + feedback.user.last_name : 'Anonymous'">
                                    </p>
                                    <p class="text-xs opacity-60" 
                                       x-text="new Date(feedback.created_at).toLocaleDateString('en-US', { 
                                           year: 'numeric', 
                                           month: 'short', 
                                           day: 'numeric' 
                                       })">
                                    </p>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="flex items-center gap-2 mb-3">
                                <div class="rating rating-sm">
                                    <template x-for="i in 5" :key="i">
                                        <input 
                                            type="radio" 
                                            :name="'rating-' + feedback.id" 
                                            class="mask mask-star-2 bg-orange-400" 
                                            :checked="i === feedback.rating"
                                            disabled 
                                        />
                                    </template>
                                </div>
                                <span class="text-xs font-semibold" x-text="'(' + feedback.rating + '/5)'"></span>
                            </div>

                            <!-- Comment -->
                            <p class="text-sm leading-relaxed" 
                                x-text="feedback.comment">
                            </p>

                            <!-- Time Badge -->
                            <div class="card-actions justify-end mt-3">
                                <div class="badge badge-ghost badge-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span x-text="getTimeAgo(feedback.created_at)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Pagination -->
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

        <!-- Page Info -->
        <div x-show="lastPage > 0" class="text-center text-sm text-gray-500 mt-5" x-cloak>
            Page <span x-text="currentPage"></span> of <span x-text="lastPage"></span>
            (<span x-text="feedbacks.length"></span> feedbacks on this page)
        </div>
    </div>

    {{-- Footer --}}
    <x-layout.client.footer />

    <script>
        function feedbackTable() {
            return {
                feedbacks: {!! json_encode($feedbacks->items(), JSON_UNESCAPED_SLASHES) !!},
                currentPage: parseInt({{ $feedbacks->currentPage() }}),
                lastPage: parseInt({{ $feedbacks->lastPage() }}),
                loading: false,

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
                    console.log('Total feedbacks on page:', this.feedbacks.length);
                },

                async loadPage(page) {
                    if (page < 1 || page > this.lastPage || this.loading) {
                        console.log('Navigation blocked:', { page, lastPage: this.lastPage, loading: this.loading });
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await fetch(`{{ route('feedbacks') }}?page=${page}`, {
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

                        this.feedbacks = data.data;
                        this.currentPage = parseInt(data.current_page);
                        this.lastPage = parseInt(data.last_page);

                        // Scroll to top smoothly
                        window.scrollTo({ top: 0, behavior: 'smooth' });

                    } catch (error) {
                        console.error('Error loading page:', error);
                        alert('Failed to load feedbacks. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                },

                getTimeAgo(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const seconds = Math.floor((now - date) / 1000);

                    const intervals = {
                        year: 31536000,
                        month: 2592000,
                        week: 604800,
                        day: 86400,
                        hour: 3600,
                        minute: 60
                    };

                    for (const [unit, secondsInUnit] of Object.entries(intervals)) {
                        const interval = Math.floor(seconds / secondsInUnit);
                        if (interval >= 1) {
                            return interval === 1 ? `1 ${unit} ago` : `${interval} ${unit}s ago`;
                        }
                    }

                    return 'just now';
                }
            }
        }
    </script>
</x-layout.client>