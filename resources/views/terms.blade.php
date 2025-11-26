<x-layout.client title="Terms of Service">
    <x-layout.client.navbar />

    <div class="flex min-h-full items-center justify-center p-3">
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : ''" class="max-w-4xl p-10 mt-20">
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold mb-4">Terms of Service</h1>
                <p class="leading-relaxed">
                    Welcome to Pathfinder, a web-based career assessment and development platform designed for the students of 
                    Pamantasan ng Lungsod ng Pasig (PLP). By creating an account or using this system, you agree to comply with 
                    these Terms of Service and acknowledge that your personal data will be processed in accordance with our Privacy 
                    Policy and the Data Privacy Act of 2012 (Republic Act No. 10173).
                </p>
            </div>

            <div class="space-y-8">
                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">1. Purpose of the System</h2>
                    <p class="leading-relaxed">
                        Pathfinder helps students assess their career readiness and employability through personality tests, soft 
                        skills evaluation, and academic insights. The results serve as guidance tools and do not represent official 
                        certification of employment or academic standing.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">2. Eligibility</h2>
                    <p class="leading-relaxed">
                        Only officially enrolled PLP students and authorized school staff may use Pathfinder. By registering, you 
                        confirm that the information you provide is accurate and truthful.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">3. Account Responsibilities</h2>
                    <div class="space-y-3">
                        <p class="leading-relaxed">
                            You are responsible for maintaining the confidentiality of your account credentials. Do not share your 
                            login details with others.
                        </p>
                        <p class="leading-relaxed">
                            You agree to notify the administrator immediately if you suspect unauthorized access or misuse of your account.
                        </p>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">4. Data Collection and Use</h2>
                    <p class="leading-relaxed mb-4">
                        By using Pathfinder, you agree that the system may collect, store, and process the following types of information:
                    </p>
                    <ul class="space-y-3">
                        <li class="flex flex-col gap-2">
                            <span class="font-semibold">Personal Information:</span>
                            <span>first name, last name, sex, age, civil status, institutional email.</span>
                        </li>
                        <li class="flex flex-col gap-2">
                            <span class="font-semibold">Academic Information:</span>
                            <span>student ID, program, year level, section, enrollment status, academic standing, batch year, and expected graduation year.</span>
                        </li>
                        <li class="flex flex-col gap-2">
                            <span class="font-semibold">Assessment Data:</span>
                            <span>personality test results, soft skills test results, academic evaluation, personal experience responses, and skill scale assessments.</span>
                        </li>
                    </ul>
                    <p class="leading-relaxed mt-4">
                        These data are collected solely for educational, analytical, and career development purposes within the university.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">5. Prohibited Actions</h2>
                    <p class="leading-relaxed mb-3">You agree not to:</p>
                    <ul class="space-y-2 list-disc list-inside pl-4">
                        <li>Access or attempt to access data belonging to other users.</li>
                        <li>Alter, reverse-engineer, or damage the system in any way.</li>
                        <li>Upload malicious content or falsify academic information.</li>
                    </ul>
                    <p class="leading-relaxed mt-3">
                        Violations may result in account suspension or legal action under applicable laws.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">6. Intellectual Property</h2>
                    <div class="space-y-3">
                        <p class="leading-relaxed">
                            All system content, design, and materials are owned by the Pathfinder Development Team and Pamantasan 
                            ng Lungsod ng Pasig.
                        </p>
                        <p class="leading-relaxed">
                            You may not copy, redistribute, or modify any part of Pathfinder without prior permission.
                        </p>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">7. Limitation of Liability</h2>
                    <p class="leading-relaxed">
                        Pathfinder provides guidance based on data entered by users and does not guarantee employment outcomes. 
                        The developers and PLP shall not be held liable for damages arising from the use or inability to use the system.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">8. Modification of Terms</h2>
                    <p class="leading-relaxed">
                        The developers may update these Terms of Service as needed. Users will be notified of any significant 
                        changes through email or system announcements.
                    </p>
                </section>
            </div>

            <div class="mt-12 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-600 text-center">
                    Last updated: November 03, 2025
                </p>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <x-layout.client.footer />
</x-layout.client>