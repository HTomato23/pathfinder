<x-layout.client title="Privacy Policy">
    <x-layout.client.navbar />

    <div class="flex min-h-full items-center justify-center p-3">
        <div x-cloak :class="$store.theme.isDark() ? 'bg-base-200' : ''" class="max-w-4xl p-10 mt-20">
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold mb-4">Privacy Policy</h1>
                <p class="leading-relaxed">
                    Pathfinder respects and values your right to privacy. This Privacy Policy explains how we collect, process, 
                    and protect your personal data in accordance with the Data Privacy Act of 2012 (Republic Act No. 10173) and 
                    the regulations set by the National Privacy Commission (NPC) of the Philippines.
                </p>
            </div>

            <div class="space-y-8">
                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">1. Data We Collect</h2>
                    <p class="leading-relaxed mb-4">
                        When you use Pathfinder, we collect the following information:
                    </p>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold mb-2">a. Personal Information</h3>
                            <ul class="space-y-1 pl-4">
                                <li>• First Name and Last Name</li>
                                <li>• Sex</li>
                                <li>• Age</li>
                                <li>• Civil Status</li>
                                <li>• Institutional Email Address</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-2">b. Academic Information</h3>
                            <ul class="space-y-1 pl-4">
                                <li>• Student ID Number</li>
                                <li>• Program and Year Level</li>
                                <li>• Section</li>
                                <li>• Enrollment Status</li>
                                <li>• Academic Standing</li>
                                <li>• Batch Year and Expected Graduation Year</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-2">c. Assessment Data</h3>
                            <ul class="space-y-1 pl-4">
                                <li>• Personality Test responses</li>
                                <li>• Soft Skills Test results</li>
                                <li>• Academic Evaluation answers</li>
                                <li>• Personal Experience responses</li>
                                <li>• Skill Scale ratings</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">2. Purpose of Data Collection</h2>
                    <p class="leading-relaxed mb-3">Your information is collected for the following purposes:</p>
                    <ul class="space-y-2 pl-4">
                        <li>• To generate your career assessment results.</li>
                        <li>• To provide personalized insights and recommendations for career development.</li>
                        <li>• To assist PLP staff in evaluating employability patterns and academic support needs.</li>
                        <li>• To maintain your account, verify identity, and secure access to the system.</li>
                        <li>• To improve Pathfinder's analytics and overall user experience.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">3. Data Processing and Storage</h2>
                    <p class="leading-relaxed">
                        All personal data are processed fairly and lawfully, stored in secure databases, and accessed only by 
                        authorized Pathfinder administrators. Access logs are monitored for security.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">4. Data Sharing and Disclosure</h2>
                    <p class="leading-relaxed">
                        Your personal data will not be sold, shared, or disclosed to third parties without your consent.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">5. Data Retention and Disposal</h2>
                    <p class="leading-relaxed">
                        Your data will be retained only as long as necessary to fulfill the purposes stated above. Once your 
                        account becomes inactive or no longer needed, your information will be securely deleted or anonymized 
                        according to institutional policy.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">6. Rights of Data Subjects</h2>
                    <p class="leading-relaxed mb-3">
                        Under the Data Privacy Act of 2012, you have the right to:
                    </p>
                    <ol class="space-y-2 pl-4">
                        <li>1. Be informed about how your data is collected and used;</li>
                        <li>2. Access your personal data upon request;</li>
                        <li>3. Correct or update inaccurate information;</li>
                        <li>4. Withdraw consent to data processing;</li>
                        <li>5. Object to data sharing;</li>
                        <li>6. File a complaint with the National Privacy Commission (NPC) if your rights are violated.</li>
                    </ol>
                    <p class="leading-relaxed mt-3">
                        Requests may be sent to the Data Protection Officer (see contact below).
                    </p>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">7. Security Measures</h2>
                    <p class="leading-relaxed mb-3">
                        We implement appropriate technical, organizational, and physical safeguards, such as:
                    </p>
                    <ul class="space-y-2 pl-4">
                        <li>• Password encryption</li>
                        <li>• Secure user authentication</li>
                        <li>• Restricted administrative access</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl sm:text-2xl font-semibold mb-3">8. Updates to this Policy</h2>
                    <p class="leading-relaxed">
                        We may update this Privacy Policy from time to time. Any changes will be posted within the system and 
                        announced through your registered email.
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