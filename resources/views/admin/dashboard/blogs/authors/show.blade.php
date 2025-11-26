<x-layout.app title="Authors">
    <x-layout.admin.admin-sidebar />
    <main class="flex flex-col gap-6 p-5 xl:ml-[256px]" x-data="authorTable()" x-init="init()">
        <x-layout.admin.admin-navbar page="Authors" />

        @php
            $initials = $author ? strtoupper(substr($author->first_name, 0, 1)) . strtoupper(substr($author->last_name, 0, 1)) : 'AT';
        @endphp

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

        <div class="flex justify-between flex-col xl:flex-row gap-2 font-outfit">
            <div class="flex flex-col gap-y-2 w-full">
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                    class="flex justify-center sm:justify-between rounded-sm shadow-sm p-5">
                    <div class="flex items-center justify-center gap-5">
                        <div class="avatar avatar-placeholder">
                            <div class="bg-neutral text-neutral-content w-24 rounded-full">
                                <span class="text-3xl">{{ $initials }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm">{{ $author->first_name }} {{ $author->last_name }}</span>
                            <span class="text-xs text-gray-500">Author</span>
                        </div>
                    </div>
                    <div class="hidden sm:flex sm:justify-center sm:items-center sm:p-3"">
                        <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="hidden md:block" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
                    </div>
                </div>

                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"  
                    class="flex flex-col gap-y-5 rounded-sm shadow-sm p-5">
                    <h1 class="font-medium text-md">General Information</h1>
                    <div class="flex flex-col md:flex-row">
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">ID</label>
                                <p class="text-sm">{{ $author->id }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">First Name</label>
                                <p class="text-sm">{{ $author->first_name }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Last Name</label>
                                <p class="text-sm">{{ $author->last_name }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-3 w-full">
                            <div>
                                <label class="text-gray-600 text-sm">Blogs</label>
                                <p class="text-sm">{{ $author->blogs_count }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Email address</label>
                                <p class="text-sm">{{ $author->email }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 text-sm">Socials</label>
                                <div class="flex items-center space-x-3">
                                    <a href="https://mail.google.com/mail/u/0/?source=mailto&to={{ $author->email }}&fs=1&tf=cm" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" version="1.1">
                                            <path fill="currentColor" d="M30.996 7.824v17.381c0 0 0 0 0 0.001 0 1.129-0.915 2.044-2.044 2.044-0 0-0 0-0.001 0h-4.772v-11.587l-8.179 6.136-8.179-6.136v11.588h-4.772c0 0 0 0-0 0-1.129 0-2.044-0.915-2.044-2.044 0-0 0-0.001 0-0.001v0-17.381c0-0 0-0.001 0-0.001 0-1.694 1.373-3.067 3.067-3.067 0.694 0 1.334 0.231 1.848 0.619l-0.008-0.006 10.088 7.567 10.088-7.567c0.506-0.383 1.146-0.613 1.84-0.613 1.694 0 3.067 1.373 3.067 3.067v0z" />
                                        </svg>
                                    </a>
                                    <a href="{{ $author->facebook }}" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 512 512" xml:space="preserve">
                                            <path fill="currentColor" d="M283.122,122.174c0,5.24,0,22.319,0,46.583h83.424l-9.045,74.367h-74.379   c0,114.688,0,268.375,0,268.375h-98.726c0,0,0-151.653,0-268.375h-51.443v-74.367h51.443c0-29.492,0-50.463,0-56.302   c0-27.82-2.096-41.02,9.725-62.578C205.948,28.32,239.308-0.174,297.007,0.512c57.713,0.711,82.04,6.263,82.04,6.263   l-12.501,79.257c0,0-36.853-9.731-54.942-6.263C293.539,83.238,283.122,94.366,283.122,122.174z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ $author->instagram }}" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30">
                                            <path fill="currentColor" d="M349.33 69.33H162.67C108.69 69.33 69.33 108.69 69.33 162.67v186.67c0 53.98 39.36 93.34 93.34 93.34h186.67c53.98 0 93.34-39.36 93.34-93.34V162.67c0-53.98-39.36-93.34-93.34-93.34zM464 162.67v186.67c0 63.7-51.63 115.33-115.33 115.33H162.67C98.97 464 47.33 412.37 47.33 348.67V162.67C47.33 98.97 98.97 47.33 162.67 47.33h186.67C412.37 47.33 464 98.97 464 162.67zM256 170.67a85.33 85.33 0 1 0 85.33 85.33A85.33 85.33 0 0 0 256 170.67zm0 138.66a53.33 53.33 0 1 1 53.33-53.33 53.33 53.33 0 0 1-53.33 53.33zm106.67-173.33a21.33 21.33 0 1 1-21.34 21.33 21.33 21.33 0 0 1 21.34-21.33z" stroke="currentColor" stroke-width="15" />
                                        </svg>
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex w-full">
                <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'"  
                    class="flex flex-col gap-y-2 rounded-sm shadow-sm p-5 h-full w-full">
                    <h1 class="font-medium text-2xl text-center sm:text-start">Blogs</h1>
                    <div class="overflow-x-auto h-[300px]">
                        <table class="table font-outfit">
                            <thead class="sticky top-0 bg-base-300 z-40">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($author->blogs->isNotEmpty())
                                    @foreach ($author->blogs as $blog)
                                        <tr>
                                            <td>{{ $blog->id }}</td>
                                            <td>{{ $blog->title }}</td>
                                            <td>
                                                @if ($blog->status === 'Draft')
                                                    <x-ui.badge color="warning" size="sm">{{ $blog->status ??  'Unknown'}}</x-ui.badge>
                                                @elseif ($blog->status === 'Published')
                                                    <x-ui.badge color="success" size="sm">{{ $blog->status ??  'Unknown'}}</x-ui.badge>
                                                @elseif ($blog->status === 'Archived')
                                                    <x-ui.badge color="default" size="sm">{{ $blog->status ??  'Unknown'}}</x-ui.badge>
                                                @endif
                                            </td>
                                            <td>{{ $blog->created_at->format('F d, Y') }}</td>
                                        </tr>
                                    @endforeach   
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-gray-500">
                                            This author has no blogs yet.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <x-ui.button x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" class="block sm:hidden" color="primary" onclick="my_modal_1.showModal()">Edit</x-ui.button>
        </div>

        <div x-cloak class="alert alert-vertical sm:alert-horizontal">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h3 class="font-bold">Delete author</h3>
                <div class="text-xs">This action will permanently delete the author information, including all the blogs and progress. This cannot be undone.</div>
            </div>
            <x-ui.button x-cloak x-bind:class="$store.theme.isDark() ? 'btn-soft' : ''" color="error"
                size="sm" onclick="my_modal_2.showModal()">Delete</x-ui.button>
        </div>

        <dialog id="my_modal_1" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Update Author</h3>
                </div>
                <form method="POST" action="/admin/dashboard/blogs/authors/{{ $author->id }}/update" 
                    x-data="{ submitting: false, firstName: '{{ $author->first_name }}', lastName: '{{ $author->last_name }}', sanitizeName(input){ return input.replace(/[^a-zA-ZñÑ\s.'-]/g, ''); } }" 
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('PATCH')

                    <fieldset class="fieldset">

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
                        <x-ui.form-input class="validator" value="{{ $author->email }}" type="email" name="email" placeholder="mail@site.com" required>
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Enter valid email address
                        </p>

                        <!-- Facebook -->
                        <x-ui.form-label>Facebook:</x-ui.form-label>
                        <x-ui.form-input class="validator" value="{{ $author->facebook }}" type="text" name="facebook" placeholder="Facebook" pattern="https:\/\/(www\.)?facebook\.com\/.*">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Enter valid facebook address
                        </p>

                        <!-- Facebook -->
                        <x-ui.form-label>Instagram:</x-ui.form-label>
                        <x-ui.form-input class="validator" value="{{ $author->instagram }}" type="text" name="instagram" placeholder="Instagram" pattern="https:\/\/(www\.)?instagram\.com\/.*">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </g>
                            </svg>
                        </x-ui.form-input>
                        <p class="validator-hint hidden">
                            Enter valid instagram address
                        </p>

                        <!-- Submit Button -->
                        <x-ui.button 
                            type="submit" 
                            color="accent" 
                            class="mt-4"
                            x-bind:disabled="submitting" 
                        >
                            <span x-show="!submitting">Update</span>
                            <span x-show="submitting" style="display: none">Updating <span class="loading loading-dots loading-xs"></span></span>
                        </x-ui.button>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        {{-- Delete Account --}}
        <dialog id="my_modal_2" class="modal">
            <div class="modal-box font-outfit">
                <div class="flex items-center gap-2 text-error mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-bold">Are you sure?</h3>
                </div>
                <form method="POST" action="/admin/dashboard/blogs/authors/{{ $author->id }}/delete" 
                    x-data="{ submitting: false }"
                    @submit.prevent="if (!submitting) { submitting = true; $el.submit(); }">

                    @csrf
                    @method('DELETE')

                    <fieldset class="fieldset">

                        <p class="text-sm text-justify mb-2">Are you sure you want to delete this author? Only administrators are authorized to perform this action. Please proceed with caution, this cannot be undone.</p>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-ui.button 
                                type="submit" 
                                variant="outline"
                                color="error" 
                                size="sm"
                                x-bind:disabled="submitting"                  
                            >
                                <span x-show="!submitting">Delete</span>
                                <span x-show="submitting" style="display: none">Deleting <span class="loading loading-dots loading-xs"></span></span>
                            </x-ui.button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </main>
</x-layout.app>
