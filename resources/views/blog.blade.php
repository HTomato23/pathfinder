<x-layout.client title="Blog">
    <x-layout.client.navbar></x-layout.client.navbar>

    @php
        $initials = $blog->author ? strtoupper(substr($blog->author->first_name, 0, 1)) . strtoupper(substr($blog->author->last_name, 0, 1)) : 'AT';
    @endphp

    <div class="w-[85%] mx-auto py-40">
        <div class="reveal text-4xl text-center font-medium font-poppins"> {{ $blog->title }} </div>
    </div>

    <div class="bg-base-200">
        <div class="w-[85%] mx-auto py-10 flex gap-5 font-outfit">
            <div class="flex flex-col justify-evenly gap-7 w-full py-5">
                <div class="flex flex-col gap-5">
                    <div class="reveal-stagger text-2xl text-center sm:text-start font-medium font-poppins italic">{{ $blog->header_1 }}</div>
                    <div class="reveal-stagger font-light text-justify">{{ $blog->content_1 }}</div>
                </div>
                <div class="flex flex-col lg:flex-row">
                    <div class="flex flex-col lg:flex-row items-center gap-2 w-full lg:w-[70%]">
                        <div class="reveal-stagger avatar avatar-placeholder">
                            <div class="bg-neutral text-neutral-content w-24 rounded-full">
                                <span class="text-3xl">{{ $initials }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center lg:items-start">
                            <div class="reveal-stagger text-lg font-medium">{{ $blog->author->first_name }} {{ $blog->author->last_name }}</div>
                            <div class="reveal-stagger text-sm font-light">{{ $blog->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center lg:items-start gap-2 w-full lg:w-[30%]">
                        <h1 class="reveal-stagger text-lg font-medium">Socials:</h1>
                        <div class="flex items-center gap-2">
                            <a href="https://mail.google.com/mail/u/0/?source=mailto&to={{ $blog->author->email }}&fs=1&tf=cm" target="_blank" class="reveal-stagger transition-colors duration-300 hover:text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 32 32" version="1.1">
                                    <path fill="currentColor" d="M30.996 7.824v17.381c0 0 0 0 0 0.001 0 1.129-0.915 2.044-2.044 2.044-0 0-0 0-0.001 0h-4.772v-11.587l-8.179 6.136-8.179-6.136v11.588h-4.772c0 0 0 0-0 0-1.129 0-2.044-0.915-2.044-2.044 0-0 0-0.001 0-0.001v0-17.381c0-0 0-0.001 0-0.001 0-1.694 1.373-3.067 3.067-3.067 0.694 0 1.334 0.231 1.848 0.619l-0.008-0.006 10.088 7.567 10.088-7.567c0.506-0.383 1.146-0.613 1.84-0.613 1.694 0 3.067 1.373 3.067 3.067v0z" />
                                </svg>
                            </a>
                            <a href="{{ $blog->author->instagram }}" target="_blank" class="reveal-stagger transition-colors duration-300 hover:text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30">
                                    <path fill="currentColor" d="M349.33 69.33H162.67C108.69 69.33 69.33 108.69 69.33 162.67v186.67c0 53.98 39.36 93.34 93.34 93.34h186.67c53.98 0 93.34-39.36 93.34-93.34V162.67c0-53.98-39.36-93.34-93.34-93.34zM464 162.67v186.67c0 63.7-51.63 115.33-115.33 115.33H162.67C98.97 464 47.33 412.37 47.33 348.67V162.67C47.33 98.97 98.97 47.33 162.67 47.33h186.67C412.37 47.33 464 98.97 464 162.67zM256 170.67a85.33 85.33 0 1 0 85.33 85.33A85.33 85.33 0 0 0 256 170.67zm0 138.66a53.33 53.33 0 1 1 53.33-53.33 53.33 53.33 0 0 1-53.33 53.33zm106.67-173.33a21.33 21.33 0 1 1-21.34 21.33 21.33 21.33 0 0 1 21.34-21.33z" stroke="currentColor" stroke-width="15" />
                                </svg>
                            </a>
                            <a href="{{ $blog->author->facebook }}" target="_blank" class="reveal-stagger transition-colors duration-300 hover:text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="22" height="22" viewBox="0 0 512 512" xml:space="preserve">
                                    <path fill="currentColor" d="M283.122,122.174c0,5.24,0,22.319,0,46.583h83.424l-9.045,74.367h-74.379   c0,114.688,0,268.375,0,268.375h-98.726c0,0,0-151.653,0-268.375h-51.443v-74.367h51.443c0-29.492,0-50.463,0-56.302   c0-27.82-2.096-41.02,9.725-62.578C205.948,28.32,239.308-0.174,297.007,0.512c57.713,0.711,82.04,6.263,82.04,6.263   l-12.501,79.257c0,0-36.853-9.731-54.942-6.263C293.539,83.238,283.122,94.366,283.122,122.174z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <div class="w-[85%] mx-auto py-10">
        <div class="reveal-stagger text-2xl text-center sm:text-start font-medium font-poppins italic">{{ $blog->header_2 }}</div>
        <div class="reveal-stagger text-justify font-light mt-5 w-full lg:w-4xl">{{ $blog->content_2 }}</div>
    </div>

    <div class="w-[85%] mx-auto py-10">
        <div class="reveal-stagger text-2xl text-center sm:text-start font-medium font-poppins italic">{{ $blog->header_3 }}</div>
        <div class="reveal-stagger text-justify font-light mt-5 w-full lg:w-4xl">{{ $blog->content_3 }}</div>
    </div>

    <div class="w-[85%] mx-auto py-10">
        <div class="reveal-stagger text-2xl text-center sm:text-start font-medium font-poppins italic">{{ $blog->header_4 }}</div>
        <div class="reveal-stagger text-justify font-light mt-5 w-full lg:w-4xl">{{ $blog->content_4 }}</div>
    </div>

    <div class="w-[85%] mx-auto py-10">
        <div class="reveal-stagger text-2xl text-center sm:text-start font-medium font-poppins italic">{{ $blog->header_4 }}</div>
        <div class="reveal-stagger text-justify font-light mt-5 w-full lg:w-4xl">{{ $blog->content_4 }}</div>
    </div>

    <div class="w-[85%] mx-auto py-10">
        <div class="reveal-stagger text-2xl text-center sm:text-start font-medium font-poppins italic">{{ $blog->header_6 }}</div>
        <div class="reveal-stagger text-justify font-light mt-5 w-full lg:w-4xl">{{ $blog->content_5 }}</div>
    </div>

    {{-- Footer --}}
    <x-layout.client.footer></x-layout.client.footer>
</x-layout.client>