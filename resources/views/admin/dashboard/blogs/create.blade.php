<x-layout.app title="Create Blog">
    <x-layout.admin.admin-sidebar />
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]" x-init="init()">
        <x-layout.admin.admin-navbar page="Create Blog" />

        {{-- Get all errors --}}
        @if ($errors->any())
            <div class="fixed bottom-4 right-4 z-50 space-y-2 w-[90%] sm:max-w-md">
                @foreach ($errors->all() as $error)
                    <x-ui.alert type="error" message="{{ $error }}" class="mb-2" />
                @endforeach
            </div>
        @endif

        <form class="flex flex-col gap-6 font-outfit" method="POST" action="{{ route('admin.dashboard.blogs.store') }}"
            enctype="multipart/form-data"
            x-data="{ submitting: false }" 
            @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">
            @csrf

            <div class="flex flex-col lg:flex-row gap-4">
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="shadow-sm rounded-sm p-5 w-full">
                    <h1 class="font-medium text-primary">General</h1>
                    <div class="flex flex-col p-2">
                        {{-- Blog Author --}}
                        <fieldset class="fieldset w-full">
                            <legend class="fieldset-legend">Author <span class="text-red-700">*</span></legend>
                            <select name="author_id" class="select select-primary w-full validator" required>
                                <option disabled selected value="">Select an author</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</option>
                                @endforeach
                            </select>
                            <p class="text-gray-500">An author must be selected to properly assign credit for the blog post.</p>
                        </fieldset>
                        {{-- Blog Status --}}
                        <fieldset class="fieldset w-full">
                            <legend class="fieldset-legend">Status <span class="text-red-700">*</span></legend>
                            <select name="status" class="select select-primary w-full validator" required>
                                <option disabled selected value="">Select a status</option>
                                <option value="Draft">Draft</option>
                                <option value="Published">Publish</option>
                                <option value="Archived">Archive</option>
                            </select>
                            <p class="text-gray-500">A status is required and recommended.</p>
                        </fieldset>
                    </div>
                </div>

                 <!-- Blog Title & Description -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="shadow-sm rounded-sm p-5 w-full">
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">Title <span class="text-red-700">*</span></legend>
                        <x-ui.form-input class="validator input-primary" name="title" type="text" minlength="3" maxlength="150" placeholder="Title" required />
                        <p class="text-gray-500">Set a title for the blog.</p>
                    </fieldset>
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">Description <span class="text-red-700">*</span></legend>
                        <textarea class="textarea textarea-primary w-full resize-none" minlength="1" name="description" placeholder="Description..." "></textarea>
                        <p class="text-gray-500">Set a description to the blog for better visibility.</p>
                    </fieldset>
                </div>
            </div>

            <!-- 1st & 2nd Header Content -->

            <div class="flex flex-col lg:flex-row gap-4">
                <!-- 1st Header Content -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="shadow-sm rounded-sm p-5 w-full">
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">1st Header</legend>
                        <x-ui.form-input class="validator input-primary" name="header_1" type="text" minlength="3" placeholder="header" />
                        <p class="text-gray-500">Provide a clear and concise title for this section of your blog.</p>
                    </fieldset>
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">1st Content</legend>
                        <textarea class="textarea textarea-primary w-full h-[200px] resize-none" minlength="1" name="content_1" placeholder="Content..."></textarea>
                        <p class="text-gray-500">Write the introduction or opening content for this section.</p>
                    </fieldset>
                </div>
                <!-- 2nd Header Content -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="shadow-sm rounded-sm p-5 w-full">
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">2nd Header</legend>
                        <x-ui.form-input class="validator input-primary" name="header_2" type="text" minlength="3" placeholder="header" />
                        <p class="text-gray-500">Use this title to introduce the next part of your content.</p>
                    </fieldset>
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">2nd Content</legend>
                        <textarea class="textarea textarea-primary w-full h-[200px] resize-none" name="content_2" placeholder="Content..."></textarea>
                        <p class="text-gray-500">Expand on your topic with valuable insights or details here.</p>
                    </fieldset>
                </div>
            </div>

            <!-- 3rd & 4th Header Content -->

            <div class="flex flex-col lg:flex-row gap-4">
                <!-- 3rd Header Content -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="shadow-sm rounded-sm p-5 w-full">
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">3rd Header</legend>
                        <x-ui.form-input class="validator input-primary" name="header_3" type="text" minlength="3" placeholder="header" />
                        <p class="text-gray-500">This section header should reflect the theme of the following paragraph.</p>
                    </fieldset>
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">3rd Content</legend>
                        <textarea class="textarea textarea-primary w-full h-[200px] resize-none" name="content_3" placeholder="Content..."></textarea>
                        <p class="text-gray-500">Use this area to explain or elaborate on the previous section title.</p>
                    </fieldset>
                </div>
                <!-- 4th Header Content -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="shadow-sm rounded-sm p-5 w-full">
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">4th Header</legend>
                        <x-ui.form-input class="validator input-primary" name="header_4" type="text" minlength="3" placeholder="header" />
                        <p class="text-gray-500">Add a descriptive label that sums up this section.</p>
                    </fieldset>
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">4th Content</legend>
                        <textarea class="textarea textarea-primary w-full h-[200px] resize-none" name="content_4" placeholder="Content..."></textarea>
                        <p class="text-gray-500">Continue your blog story or provide supporting information.</p>
                    </fieldset>
                </div>
            </div>

            <!-- 5th & 6th Header Content -->

            <div class="flex flex-col lg:flex-row gap-4">
                <!-- 5th Header Content -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="shadow-sm rounded-sm p-5 w-full">
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">5th Header</legend>
                        <x-ui.form-input class="validator input-primary" name="header_5" type="text" minlength="3" placeholder="header" />
                        <p class="text-gray-500">Keep it short and relevant to the content that follows.</p>
                    </fieldset>
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">5th Content</legend>
                        <textarea class="textarea textarea-primary w-full h-[200px] resize-none" name="content_5" placeholder="Content..."></textarea>
                        <p class="text-gray-500">Add depth or examples to strengthen your blog message.</p>
                    </fieldset>
                </div>
                <!-- 6hh Header Content -->
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="shadow-sm rounded-sm p-5 w-full">
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">6th Header</legend>
                        <x-ui.form-input class="validator input-primary" name="header_6" type="text" minlength="3" placeholder="header" />
                        <p class="text-gray-500">Title this part of the blog to guide your readers smoothly.</p>
                    </fieldset>
                    <fieldset class="fieldset w-full">
                        <legend class="fieldset-legend">6th Content</legend>
                        <textarea class="textarea textarea-primary w-full h-[200px] resize-none" name="content_6" placeholder="Content..."></textarea>
                        <p class="text-gray-500">Wrap up this section with a conclusion or transition.</p>
                    </fieldset>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 items-center justify-end lg:flex-row">
                {{-- Back Button --}}
                <x-ui.button href="{{ route('admin.dashboard.blogs') }}" x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="default">Back</x-ui.button>

                <!-- Submit Button -->
                <x-ui.button 
                    type="submit" 
                    color="primary" 
                    x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''"
                    x-bind:disabled="submitting" 
                >
                    <span x-show="!submitting">Create</span>
                    <span x-show="submitting" style="display: none">Creating <span class="loading loading-dots loading-xs"></span></span>
                </x-ui.button>
            </div>
        </form>
</x-layout.app>

