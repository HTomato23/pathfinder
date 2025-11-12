<footer x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="footer sm:footer-horizontal p-15 mt-10 sm:p-30">
    <nav>
        <h6 class="footer-title">Company</h6>
        <a href="{{ route('home') }}" class="transition-colors duration-300 hover:text-green-700 cursor-pointer font-outfit">Home</a>
        <a href="{{ route('about') }}" class="transition-colors duration-300 hover:text-green-700 cursor-pointer font-outfit">About</a>
        <a href="{{ route('contact') }}" class="transition-colors duration-300 hover:text-green-700 cursor-pointer font-outfit">Contact</a>
        <a href="{{ route('blogs') }}" class="transition-colors duration-300 hover:text-green-700 cursor-pointer font-outfit">Blogs</a>
    </nav>

    <nav>
        <h6 class="footer-title">Legal</h6>
        <a href="{{ route('terms') }}" target="_blank" class="transition-colors duration-300 hover:text-green-700 cursor-pointer font-outfit">Terms of Service</a>
        <a href="{{ route('privacy') }}" target="_blank" class="transition-colors duration-300 hover:text-green-700 cursor-pointer font-outfit">Privacy Policy</a>
    </nav>
    <nav>
        <h6 class="footer-title">Credits</h6>
        <p class="font-outfit">Illustrations by <a href="https://storyset.com/" target="_blank"
                class="hover:text-green-700 cursor-pointer">Storyset</a></p>
    </nav>
    <nav>
        <h6 class="footer-title">Social</h6>
        <div class="grid grid-flow-col gap-4">
            <a href="https://mail.google.com/mail/u/0/?source=mailto&to=inquiry@plpasig.edu.ph&fs=1&tf=cm" target="_blank"">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" version="1.1">
                    <path fill="currentColor" d="M30.996 7.824v17.381c0 0 0 0 0 0.001 0 1.129-0.915 2.044-2.044 2.044-0 0-0 0-0.001 0h-4.772v-11.587l-8.179 6.136-8.179-6.136v11.588h-4.772c0 0 0 0-0 0-1.129 0-2.044-0.915-2.044-2.044 0-0 0-0.001 0-0.001v0-17.381c0-0 0-0.001 0-0.001 0-1.694 1.373-3.067 3.067-3.067 0.694 0 1.334 0.231 1.848 0.619l-0.008-0.006 10.088 7.567 10.088-7.567c0.506-0.383 1.146-0.613 1.84-0.613 1.694 0 3.067 1.373 3.067 3.067v0z" />
                </svg>
            </a>
            <a href="https://www.youtube.com/@pamantasannglungsodngpasig8829" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                </svg>
            </a>
            <a href="https://www.facebook.com/pamantasannglungsodngpasig/" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
                </svg>
            </a>
        </div>
    </nav>
</footer>
