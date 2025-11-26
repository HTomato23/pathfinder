<x-layout.client title="About">
    <x-layout.client.navbar />
    
    {{-- Background gradient bubbles --}}
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-[25deg] bg-gradient-to-tr from-[#34d399] to-[#65a30d] opacity-30 dark:opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72rem]" style="clip-path: polygon(20% 10%, 40% 0%, 70% 15%, 85% 35%, 95% 60%, 80% 80%, 60% 90%, 30% 100%, 15% 80%, 5% 50%)"></div>
    </div>

    <div class="absolute right-0 top-20 -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[32rem]" aria-hidden="true">
        <div class="relative aspect-[1155/678] w-[36rem] rotate-[35deg] bg-gradient-to-tr from-[#166534] to-[#4ade80] opacity-30 dark:opacity-20 sm:w-[72rem]" style="clip-path: polygon(80% 0%, 100% 20%, 95% 45%, 85% 65%, 70% 80%, 50% 90%, 30% 80%, 20% 60%, 15% 40%, 20% 10%)"></div>
    </div>

    {{-- About header --}}
    <div class="w-[85%] mx-auto py-40">
        <div class="reveal text-4xl sm:text-5xl lg:text-7xl text-center font-semibold font-poppins bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 bg-clip-text text-transparent p-3"> Discover fresh opportunities in your career journey. </div>
    </div>

    {{-- About us --}}
    <div class="w-[85%] mx-auto py-10">
        <div class="reveal-stagger text-4xl text-center sm:text-start font-semibold font-outfit uppercase">about us</div>
        <div class="reveal-stagger text-justify font-light mt-5">
            Pathfinder is a web-based career assessment and development platform dedicated to empowering students to make informed and 
            confident decisions about their future careers. Designed specifically for non-board program students of Pamantasan ng 
            Lungsod ng Pasig (PLP), Pathfinder bridges the gap between education and employment by providing data-driven insights into 
            students’ strengths, skills, and career readiness.
        </div>
        <div class="reveal-stagger text-justify font-light mt-5">
            Through a comprehensive assessment process, Pathfinder evaluates students across multiple test - personality traits, soft skills, 
            academic performance, personal experiences, and skill proficiency levels. These key indicators are carefully analyzed to generate 
            a personalized career profile, helping each learner understand their unique potential and how it aligns with real-world opportunities.
        </div>
        <div class="reveal-stagger text-justify font-light mt-5">
            Our system uses guided assessments and modern technology to offer a holistic approach to career planning. Students gain not only 
            an understanding of their professional capabilities but also the confidence to pursue pathways that best match their interests 
            and abilities.
        </div>
        <div class="reveal-stagger text-justify font-light mt-5">
            At its core, Pathfinder seeks to empower, guide, and prepare students for life beyond the classroom. By transforming self-awareness 
            into actionable insights, we ensure that every non-board PLP student can take the next step in their journey with clarity, confidence, 
            and purpose.
        </div>
    </div>

    {{-- Our history --}}
    <div class="w-[85%] mx-auto py-10">
        <div class="reveal-stagger text-4xl text-center sm:text-start font-semibold font-outfit uppercase"> our history </div>
        <div class="reveal-stagger text-justify font-light mt-5">Pathfinder began as a Capstone project by a group of passionate 3rd year BSIT students from Pamantasan ng Lungsod ng Pasig in 2025. Motivated by their shared goal to make a real impact before entering their final year, the group identified a common problem among their peers—many were unsure of what careers matched their strengths and passions. What started as a simple academic requirement quickly transformed into a meaningful mission: to guide fellow students toward purposeful and informed career decisions using technology.</div>
        <div class="reveal-stagger text-justify font-light mt-5">Throughout their college year, the team collaborated closely with faculty mentors, IT professionals, and fellow students to refine their system. They integrated personality-based assessments, interactive dashboards, and smart career recommendations—all built with accessibility, ease of use, and relevance in mind. The system gained attention not just as a technical accomplishment, but as a solution that resonated deeply with the needs of the student community. Pathfinder became more than just a school project—it became a platform students could trust.</div>
        <div class="reveal-stagger text-justify font-light mt-5">Today, Pathfinder stands as a testament to what student innovation can achieve. It continues to evolve as a helpful career companion for PLP students and beyond—empowering users to discover opportunities, understand their strengths, and take confident steps toward the future. What began as a Capstone idea now serves as a digital bridge between education and employment, proving that with the right vision, even student projects can shape meaningful change.</div>
    </div>

    {{-- Mission & Vision --}}
    <div class="w-[85%] mx-auto py-10">
        <div class="text-4xl text-center sm:text-start font-semibold font-outfit uppercase">institutional statement</div>
        <div class="flex flex-col lg:flex-row gap-5 mt-5">
            <div :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal p-10 rounded-sm shadow-sm w-full transform transition-all duration-300 hover:bg-green-700 hover:text-white">
                <h3 class="text-2xl font-poppins font-semibold uppercase">mission</h3>
                <p class="text-justify font-light mt-5">To provide an inclusive and transformative education that empowers students to succeed in an ever-changing world. Through community engagement, we foster a culturally diverse and globally aware learning environment equipping students with the knowledge, skills, and values necessary for total human development.</p>
            </div>
            <div :class="$store.theme.isDark() ? 'bg-base-200' : 'bg-base-100'" class="reveal p-10 rounded-sm shadow-sm w-full transform transition-all duration-300 hover:bg-green-700 hover:text-white">
                <h3 class="text-2xl font-poppins font-semibold uppercase">vision</h3>
                <p class="text-justify font-light mt-5">An empowered Pasig Community through excellent education focused on future-proofed student success and improved quality of life anchored on the common good in a multicultural world.</p>
            </div>
        </div>
    </div>

    {{-- Meet the team --}}
    <div class="w-[85%] mx-auto py-10">
        <div class="text-4xl text-center md:text-start font-semibold font-outfit uppercase">meet the team</div>
        <ul class="list bg-base-100 rounded-box mt-5">
            <li class="reveal-stagger list-row flex flex-col md:flex-row font-outfit transition-transform duration-300 hover:scale-105 hover:bg-base-200 rounded-lg">
                <div class="text-4xl font-thin tabular-nums w-full text-center md:text-start">01</div>
                <div class="avatar avatar-placeholder flex justify-center md:justify-start w-full">
                    <div class="bg-neutral text-neutral-content w-18 md:w-10 rounded-full">
                        <span>LB</span>
                    </div>
                </div>
                <div class="list-col-grow w-full">
                    <div class="font-medium text-center md:text-start">Lanz Bautista</div>
                    <div class="text-xs uppercase font-semibold opacity-60 text-center md:text-start">Full Stack Developer</div>
                </div>
                <div class="flex justify-center items-center md:justify-evenly gap-2 w-full">
                    <a href="https://mail.google.com/mail/u/0/?source=mailto&to=bautistalanz0423@gmail.com&fs=1&tf=cm" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" version="1.1">
                            <path fill="currentColor" d="M30.996 7.824v17.381c0 0 0 0 0 0.001 0 1.129-0.915 2.044-2.044 2.044-0 0-0 0-0.001 0h-4.772v-11.587l-8.179 6.136-8.179-6.136v11.588h-4.772c0 0 0 0-0 0-1.129 0-2.044-0.915-2.044-2.044 0-0 0-0.001 0-0.001v0-17.381c0-0 0-0.001 0-0.001 0-1.694 1.373-3.067 3.067-3.067 0.694 0 1.334 0.231 1.848 0.619l-0.008-0.006 10.088 7.567 10.088-7.567c0.506-0.383 1.146-0.613 1.84-0.613 1.694 0 3.067 1.373 3.067 3.067v0z" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/htomato23/" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30">
                            <path fill="currentColor" d="M349.33 69.33H162.67C108.69 69.33 69.33 108.69 69.33 162.67v186.67c0 53.98 39.36 93.34 93.34 93.34h186.67c53.98 0 93.34-39.36 93.34-93.34V162.67c0-53.98-39.36-93.34-93.34-93.34zM464 162.67v186.67c0 63.7-51.63 115.33-115.33 115.33H162.67C98.97 464 47.33 412.37 47.33 348.67V162.67C47.33 98.97 98.97 47.33 162.67 47.33h186.67C412.37 47.33 464 98.97 464 162.67zM256 170.67a85.33 85.33 0 1 0 85.33 85.33A85.33 85.33 0 0 0 256 170.67zm0 138.66a53.33 53.33 0 1 1 53.33-53.33 53.33 53.33 0 0 1-53.33 53.33zm106.67-173.33a21.33 21.33 0 1 1-21.34 21.33 21.33 21.33 0 0 1 21.34-21.33z" stroke="currentColor" stroke-width="15" />
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/omaenaguts.kon" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 512 512" xml:space="preserve">
                            <path fill="currentColor" d="M283.122,122.174c0,5.24,0,22.319,0,46.583h83.424l-9.045,74.367h-74.379   c0,114.688,0,268.375,0,268.375h-98.726c0,0,0-151.653,0-268.375h-51.443v-74.367h51.443c0-29.492,0-50.463,0-56.302   c0-27.82-2.096-41.02,9.725-62.578C205.948,28.32,239.308-0.174,297.007,0.512c57.713,0.711,82.04,6.263,82.04,6.263   l-12.501,79.257c0,0-36.853-9.731-54.942-6.263C293.539,83.238,283.122,94.366,283.122,122.174z"></path>
                        </svg>
                    </a>
                </div>
            </li>
            <li class="reveal-stagger list-row flex flex-col md:flex-row font-outfit transition-transform duration-300 hover:scale-105 hover:bg-base-200 rounded-lg">
                <div class="text-4xl font-thin tabular-nums w-full text-center md:text-start">02</div>
                <div class="avatar avatar-placeholder flex justify-center md:justify-start w-full">
                    <div class="bg-neutral text-neutral-content w-18 md:w-10 rounded-full">
                        <span>FC</span>
                    </div>
                </div>
                <div class="list-col-grow w-full">
                    <div class="font-medium text-center md:text-start">Florence Cariño</div>
                    <div class="text-xs uppercase font-semibold opacity-60 text-center md:text-start">Backend Developer</div>
                </div>
                <div class="flex justify-center items-center md:justify-evenly gap-2 w-full">
                    <a href="https://mail.google.com/mail/u/0/?source=mailto&to=florencecarino769@gmail.com&fs=1&tf=cm" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" version="1.1">
                            <path fill="currentColor" d="M30.996 7.824v17.381c0 0 0 0 0 0.001 0 1.129-0.915 2.044-2.044 2.044-0 0-0 0-0.001 0h-4.772v-11.587l-8.179 6.136-8.179-6.136v11.588h-4.772c0 0 0 0-0 0-1.129 0-2.044-0.915-2.044-2.044 0-0 0-0.001 0-0.001v0-17.381c0-0 0-0.001 0-0.001 0-1.694 1.373-3.067 3.067-3.067 0.694 0 1.334 0.231 1.848 0.619l-0.008-0.006 10.088 7.567 10.088-7.567c0.506-0.383 1.146-0.613 1.84-0.613 1.694 0 3.067 1.373 3.067 3.067v0z" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/g15ie/" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30">
                            <path fill="currentColor" d="M349.33 69.33H162.67C108.69 69.33 69.33 108.69 69.33 162.67v186.67c0 53.98 39.36 93.34 93.34 93.34h186.67c53.98 0 93.34-39.36 93.34-93.34V162.67c0-53.98-39.36-93.34-93.34-93.34zM464 162.67v186.67c0 63.7-51.63 115.33-115.33 115.33H162.67C98.97 464 47.33 412.37 47.33 348.67V162.67C47.33 98.97 98.97 47.33 162.67 47.33h186.67C412.37 47.33 464 98.97 464 162.67zM256 170.67a85.33 85.33 0 1 0 85.33 85.33A85.33 85.33 0 0 0 256 170.67zm0 138.66a53.33 53.33 0 1 1 53.33-53.33 53.33 53.33 0 0 1-53.33 53.33zm106.67-173.33a21.33 21.33 0 1 1-21.34 21.33 21.33 21.33 0 0 1 21.34-21.33z" stroke="currentColor" stroke-width="15" />
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/florence.carino.98/" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 512 512" xml:space="preserve">
                            <path fill="currentColor" d="M283.122,122.174c0,5.24,0,22.319,0,46.583h83.424l-9.045,74.367h-74.379   c0,114.688,0,268.375,0,268.375h-98.726c0,0,0-151.653,0-268.375h-51.443v-74.367h51.443c0-29.492,0-50.463,0-56.302   c0-27.82-2.096-41.02,9.725-62.578C205.948,28.32,239.308-0.174,297.007,0.512c57.713,0.711,82.04,6.263,82.04,6.263   l-12.501,79.257c0,0-36.853-9.731-54.942-6.263C293.539,83.238,283.122,94.366,283.122,122.174z"></path>
                        </svg>
                    </a>
                </div>
            </li>
            <li class="reveal-stagger list-row flex flex-col md:flex-row font-outfit transition-transform duration-300 hover:scale-105 hover:bg-base-200 rounded-lg">
                <div class="text-4xl font-thin tabular-nums w-full text-center md:text-start">03</div>
                <div class="avatar avatar-placeholder flex justify-center md:justify-start w-full">
                    <div class="bg-neutral text-neutral-content w-18 md:w-10 rounded-full">
                        <span>TB</span>
                    </div>
                </div>
                <div class="list-col-grow w-full">
                    <div class="font-medium text-center md:text-start">Trixcy Bucad</div>
                    <div class="text-xs uppercase font-semibold opacity-60 text-center md:text-start">UI | UX Designer</div>
                </div>
                <div class="flex justify-center items-center md:justify-evenly gap-2 w-full">
                    <a href="https://mail.google.com/mail/u/0/?source=mailto&to=bucadtrixcy6@gmail.com&fs=1&tf=cm" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" version="1.1">
                            <path fill="currentColor" d="M30.996 7.824v17.381c0 0 0 0 0 0.001 0 1.129-0.915 2.044-2.044 2.044-0 0-0 0-0.001 0h-4.772v-11.587l-8.179 6.136-8.179-6.136v11.588h-4.772c0 0 0 0-0 0-1.129 0-2.044-0.915-2.044-2.044 0-0 0-0.001 0-0.001v0-17.381c0-0 0-0.001 0-0.001 0-1.694 1.373-3.067 3.067-3.067 0.694 0 1.334 0.231 1.848 0.619l-0.008-0.006 10.088 7.567 10.088-7.567c0.506-0.383 1.146-0.613 1.84-0.613 1.694 0 3.067 1.373 3.067 3.067v0z" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/trixxlvr/" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30">
                            <path fill="currentColor" d="M349.33 69.33H162.67C108.69 69.33 69.33 108.69 69.33 162.67v186.67c0 53.98 39.36 93.34 93.34 93.34h186.67c53.98 0 93.34-39.36 93.34-93.34V162.67c0-53.98-39.36-93.34-93.34-93.34zM464 162.67v186.67c0 63.7-51.63 115.33-115.33 115.33H162.67C98.97 464 47.33 412.37 47.33 348.67V162.67C47.33 98.97 98.97 47.33 162.67 47.33h186.67C412.37 47.33 464 98.97 464 162.67zM256 170.67a85.33 85.33 0 1 0 85.33 85.33A85.33 85.33 0 0 0 256 170.67zm0 138.66a53.33 53.33 0 1 1 53.33-53.33 53.33 53.33 0 0 1-53.33 53.33zm106.67-173.33a21.33 21.33 0 1 1-21.34 21.33 21.33 21.33 0 0 1 21.34-21.33z" stroke="currentColor" stroke-width="15" />
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/BucadTrixcyRed20" target="_blank" class="transition-colors duration-300 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 512 512" xml:space="preserve">
                            <path fill="currentColor" d="M283.122,122.174c0,5.24,0,22.319,0,46.583h83.424l-9.045,74.367h-74.379   c0,114.688,0,268.375,0,268.375h-98.726c0,0,0-151.653,0-268.375h-51.443v-74.367h51.443c0-29.492,0-50.463,0-56.302   c0-27.82-2.096-41.02,9.725-62.578C205.948,28.32,239.308-0.174,297.007,0.512c57.713,0.711,82.04,6.263,82.04,6.263   l-12.501,79.257c0,0-36.853-9.731-54.942-6.263C293.539,83.238,283.122,94.366,283.122,122.174z"></path>
                        </svg>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    {{-- Footer --}}
    <x-layout.client.footer />
</x-layout.client>