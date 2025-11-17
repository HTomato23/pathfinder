<x-layout.client title="Home">
    <x-layout.client.navbar></x-layout.client.navbar>

    {{-- Background gradient bubbles - FIXED --}}
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[25deg] bg-gradient-to-tr from-[#34d399] to-[#65a30d] opacity-30 dark:opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72rem]" style="clip-path: polygon(20% 10%, 40% 0%, 70% 15%, 85% 35%, 95% 60%, 80% 80%, 60% 90%, 30% 100%, 15% 80%, 5% 50%)"></div>
    </div>

    <div class="absolute inset-x-0 -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[32rem]" aria-hidden="true">
        <div class="relative left-[calc(50%+15rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[35deg] bg-gradient-to-tr from-[#166534] to-[#4ade80] opacity-30 dark:opacity-20 sm:left-[calc(50%+30rem)] sm:w-[72rem]" style="clip-path: polygon(80% 0%, 100% 20%, 95% 45%, 85% 65%, 70% 80%, 50% 90%, 30% 80%, 20% 60%, 15% 40%, 20% 10%)"></div>
    </div>

    <div class="absolute inset-x-0 -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[90rem]" aria-hidden="true">
        <div class="relative left-[calc(50%-15rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[35deg] bg-gradient-to-tr from-[#166534] to-[#4ade80] opacity-30 dark:opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72rem]" style="clip-path: polygon(80% 0%, 100% 20%, 95% 45%, 85% 65%, 70% 80%, 50% 90%, 30% 80%, 20% 60%, 15% 40%, 20% 10%)"></div>
    </div>

    <!-- Hero Section -->
    <main class="flex min-h-screen">
        <div class="reveal w-[85%] mx-auto py-10 flex flex-col lg:flex-row gap-5 mt-20 lg:mt-0">
            <div class="flex flex-col justify-center w-full gap-3 font-outfit">
                <h1 class="text-3xl font-semibold md:text-4xl"><span class="bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent">Pathfinder: </span>Guiding You Toward a Clearer Path and Success.</h1>
                <p>Explore future possibilities with confidence. Pathfinder helps you visualize goals, align skills, and unlock opportunities made for you.</p>
                <a href="{{ route('login') }}" class="btn text-white !bg-green-800 hover:opacity-90 rounded-full border-0 w-full md:w-1/2 lg:w-1/3 xl:w-1/4"> Get Started <span aria-hidden="true">&rarr;</span> </a>
            </div>
            <div class="reveal flex items-center w-full">
                <img src="{{ asset('images/svg/education.svg') }}" alt="educationSVG" />
            </div>
        </div>
    </main>

    <!-- How it works? -->
    <div>
        <div class="w-[85%] mx-auto py-10">
            <div class="flex flex-col justify-center gap-5">
                <div class="text-3xl sm:text-5xl text-center font-semibold font-poppins uppercase bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent">how it works?</div>
                <div class="flex justify-center flex-col lg:flex-row gap-2">
                    <div class="reveal-stagger card w-full lg:w-96 font-outfit">
                        <figure>
                            <img src="{{ asset('images/svg/Dashboard-amico.svg') }}" alt="DashboardSVG" />
                        </figure>
                        <div class="card-body">
                            <h2 class="font-semibold text-lg text-center">Get Started in Seconds</h2>
                            <p class="text-center">Sign up quickly and set up your profile to begin your journey toward a more guided and confident future.</p>
                        </div>
                    </div>
                    <div class="reveal-stagger card w-full lg:w-96 font-outfit">
                        <figure>
                            <img src="{{ asset('images/svg/Exams-rafiki.svg') }}" alt="ExamsSVG" />
                        </figure>
                        <div class="card-body">
                            <h2 class="font-semibold text-lg text-center">Discover Your Strengths</h2>
                            <p class="text-center">Answer a quick and simple assessment to uncover your skills, and ideal career directions.</p>
                        </div>
                    </div>
                    <div class="reveal-stagger card w-full lg:w-96 font-outfit">
                        <figure>
                            <img src="{{ asset('images/svg/Progress overview-cuate.svg') }}" alt="ProgressSVG" />
                        </figure>
                        <div class="card-body">
                            <h2 class="font-semibold text-lg text-center">Track Your Growth</h2>
                            <p class="text-center">View your progress, skill development, and learning milestones—all in one personalized dashboard.</p>
                        </div>
                    </div>
                    <div class="reveal-stagger card w-full lg:w-96 font-outfit">
                        <figure>
                            <img src="{{ asset('images/svg/Job hunt-bro.svg') }}" alt="JobSVG" />
                        </figure>
                        <div class="card-body">
                            <h2 class="font-semibold text-lg text-center">Find Your Best Path</h2>
                            <p class="text-center">Receive tailored career insights and recommendations to help you choose the right path with clarity and purpose.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Join the community -->
    <div>
        <div class="w-[85%] mx-auto py-10">
            <div class="reveal flex flex-col lg:flex-row gap-5">
                <div class="flex flex-col justify-center w-full">
                    <h1 class="text-3xl sm:text-4xl text-center lg:text-start font-semibold font-poppins bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent">Step into your path and we're here to guide you.</h1>
                    <div class="flex flex-col gap-5 mt-10">
                        <li class="flex items-center gap-2">                
                            <x-heroicon-o-chevron-double-right class="w-5 h-5"/> Discover the right career path for your goals and interests
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-chevron-double-right class="w-5 h-5"/> Connect with mentors  and professionals
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-chevron-double-right class="w-5 h-5"/> Be part of a growing network focused on real progress
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-chevron-double-right class="w-5 h-5"/> Get support, feedback, and guidance from the community
                        </li>
                    </div>
                </div>
                <div class="w-full">
                    <img src="{{ asset('images/svg/Group Chat-amico.svg') }}" alt="GroupChat" />
                </div>
            </div>
        </div>
    </div>

    <!-- Why choose us? -->
    <div>
        <div class="w-[85%] mx-auto py-10">
            <div class="flex flex-col justify-center gap-5">
                <div class="text-3xl sm:text-5xl text-center font-semibold font-poppins uppercase bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent">why choose us?</div>
                <div class="flex justify-around flex-col lg:flex-row gap-5">
                    <div :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal-stagger card w-full lg:w-96 shadow-sm font-outfit transform transition-transform duration-300 hover:scale-105">
                        <figure>
                            <img src="{{ asset('images/statistics.png') }}" alt="statistics" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">Personalized Career Dashboard</h2>
                            <p>Gain insights into your skills and interests to discover the ideal career path tailored just for you.</p>
                        </div>
                    </div>
                    <div :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal-stagger card w-full lg:w-96 shadow-sm font-outfit transform transition-transform duration-300 hover:scale-105">
                        <figure>
                            <img src="{{ asset('images/future.png') }}" alt="future" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">Your Future Starts Here</h2>
                            <p>We help you discover your strengths and unlock your true professional potential.</p>
                        </div>
                    </div>
                    <div :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal-stagger card w-full lg:w-96 shadow-sm font-outfit transform transition-transform duration-300 hover:scale-105">
                        <figure>
                            <img src="{{ asset('images/support.png') }}" alt="support" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">Support You Can Trust</h2>
                            <p>Get the encouragement, advice, and guidance you need—right when you need it most.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Have more question? -->
    <div class="w-[85%] mx-auto py-10">
        <div class="flex flex-col justify-center gap-5">
            <h1 class="text-3xl sm:text-5xl text-center font-semibold font-poppins uppercase bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent">have more question?</h1>
            <div class="join join-vertical bg-base-100 max-w-5xl w-full mx-auto">
                <div class="reveal-stagger collapse collapse-arrow join-item border-base-300 border-b">
                    <input type="radio" name="faq" />
                    <div class="collapse-title font-semibold">What is Pathfinder?</div>
                    <div class="collapse-content text-sm">Pathfinder is a platform designed to help students and job seekers discover career paths, take skill assessments, and access personalized growth tools.</div>
                </div>

                <div class="reveal-stagger collapse collapse-arrow join-item border-base-300 border-b">
                    <input type="radio" name="faq" />
                    <div class="collapse-title font-semibold">Is Pathfinder free to use?</div>
                    <div class="collapse-content text-sm">Yes, Pathfinder offers core features for free, including account creation, assessments, and basic career insights.</div>
                </div>

                <div class="reveal-stagger collapse collapse-arrow join-item border-base-300 border-b">
                    <input type="radio" name="faq" />
                    <div class="collapse-title font-semibold">How do I take an assessment?</div>
                    <div class="collapse-content text-sm">After signing up, simply go to your dashboard and click "Start Assessment" to begin your personalized career quiz.</div>
                </div>

                <div class="reveal-stagger collapse collapse-arrow join-item border-base-300 border-b">
                    <input type="radio" name="faq" />
                    <div class="collapse-title font-semibold">What happens after I take the assessment?</div>
                    <div class="collapse-content text-sm">You'll receive tailored recommendations, including career suggestions, learning paths, and your skill profile.</div>
                </div>

                <div class="reveal-stagger collapse collapse-arrow join-item border-base-300 border-b">
                    <input type="radio" name="faq" />
                    <div class="collapse-title font-semibold">Can I retake the assessment?</div>
                    <div class="collapse-content text-sm">Yes, you can retake the assessment anytime to reflect your growth or changing interests.</div>
                </div>

                <div class="reveal-stagger collapse collapse-arrow join-item border-base-300 border-b">
                    <input type="radio" name="faq" />
                    <div class="collapse-title font-semibold">How do I track my progress?</div>
                    <div class="collapse-content text-sm">Your dashboard includes a progress section that visualizes your learning milestones and career readiness indicators.</div>
                </div>
            </div>
        </div>
    </div>

     <!-- User Feedback Section -->
    <div class="w-[85%] mx-auto py-10">
        <div class="flex flex-col justify-center gap-5">
            <div class="text-3xl sm:text-5xl text-center font-semibold font-poppins uppercase bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent">
                What Our Users Say
            </div>
            <p class="text-center text-sm sm:text-base opacity-70 max-w-2xl mx-auto">
                Real experiences from students who found their path with Pathfinder
            </p>

            @if($feedbacks->isEmpty())
                <!-- Empty State -->
                <div class="reveal flex flex-col items-center justify-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 opacity-30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="text-xl font-bold">No Feedback Yet</h3>
                    <p class="text-sm opacity-70 max-w-md mt-2 text-center">
                        Be the first to share your experience with Pathfinder!
                    </p>
                </div>
            @else
                <!-- Feedback Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">
                    @foreach($feedbacks->take(6) as $feedback)
                        <div :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" 
                            class="reveal-stagger card bg-base-100 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105 font-outfit">
                            <div class="card-body">
                                <!-- User Info -->
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="avatar avatar-placeholder">
                                        <div class="bg-green-700 text-white w-12 rounded-full">
                                            <span class="text-sm">{{ substr($feedback->user->first_name, 0, 1) }}{{ substr($feedback->user->last_name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm">{{ $feedback->user->first_name }} {{ $feedback->user->last_name }}</p>
                                        <p class="text-xs opacity-60">{{ $feedback->created_at->format('M j, Y') }}</p>
                                    </div>
                                </div>

                                <!-- Rating -->
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="rating rating-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input 
                                                type="radio" 
                                                name="rating-{{ $feedback->id }}" 
                                                class="mask mask-star-2 bg-orange-400" 
                                                {{ $feedback->rating == $i ? 'checked' : '' }}
                                                disabled 
                                            />
                                        @endfor
                                    </div>
                                    <span class="text-xs font-semibold">({{ $feedback->rating }}/5)</span>
                                </div>

                                <!-- Comment -->
                                <p class="text-sm leading-relaxed line-clamp-4">
                                    "{{ $feedback->comment }}"
                                </p>

                                <!-- Time Badge -->
                                <div class="card-actions justify-end mt-3">
                                    <div class="badge badge-ghost badge-sm">
                                        {{ $feedback->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- View All Button (if more than 6 feedbacks) -->
                @if($feedbacks->count() > 6)
                    <div class="flex justify-center mt-8">
                        <a href="{{ route('feedbacks') }}" class="btn btn-outline btn-success rounded-full">
                            View All Feedback
                             <x-heroicon-o-arrow-long-right class="w-5 h-5"/>
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Footer --}}
    <x-layout.client.footer></x-layout.client.footer>
</x-layout.client>