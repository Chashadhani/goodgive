<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Join Our Staff - {{ config('app.name', 'GoodGive') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-white">
    <x-navbar />
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-indigo-600 to-purple-600 py-20 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Join Our<br>
                        Staff Network
                    </h1>
                    <div class="border-b-4 border-yellow-400 w-24 mb-6"></div>
                    
                    <p class="text-xl text-indigo-100 mb-8 leading-relaxed">
                        Are you an NGO or organization looking to streamline your donation management? Partner with GoodGive and amplify your impact through our verified platform.
                    </p>

                    <div class="space-y-3 mb-8">
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                            <span class="text-white font-medium">Verified NGO Network</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                            <span class="text-white font-medium">Free Platform Access</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                            <span class="text-white font-medium">Real-Time Management</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="#application" class="bg-yellow-400 hover:bg-yellow-500 text-indigo-900 px-8 py-3 rounded-full font-semibold transition shadow-lg hover:shadow-xl">
                            Apply Now →
                        </a>
                        <a href="{{ route('how-it-works') }}" class="bg-white hover:bg-gray-100 text-indigo-600 px-8 py-3 rounded-full font-semibold transition shadow-lg">
                            Learn More
                        </a>
                    </div>
                </div>

                <!-- Right Content - Benefits Card -->
                <div class="bg-white rounded-2xl shadow-2xl p-8 text-gray-900">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-xl">🏢</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Partner Benefits</h3>
                            <p class="text-sm text-gray-500">Everything you need to succeed</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-3 p-3 bg-indigo-50 rounded-lg">
                            <span class="text-2xl">📊</span>
                            <div>
                                <div class="font-bold text-gray-900">Dashboard Access</div>
                                <div class="text-sm text-gray-600">Complete donation management</div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg">
                            <span class="text-2xl">✓</span>
                            <div>
                                <div class="font-bold text-gray-900">Verified Badge</div>
                                <div class="text-sm text-gray-600">Build donor trust instantly</div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg">
                            <span class="text-2xl">🎯</span>
                            <div>
                                <div class="font-bold text-gray-900">Smart Matching</div>
                                <div class="text-sm text-gray-600">AI-powered donor connections</div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg">
                            <span class="text-2xl">🚀</span>
                            <div>
                                <div class="font-bold text-gray-900">Zero Commission</div>
                                <div class="text-sm text-gray-600">100% of donations go to you</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Partner Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Partner with GoodGive?</h2>
                <p class="text-gray-600 text-lg">Discover the advantages of joining our trusted network</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Benefit 1 -->
                <div class="bg-gradient-to-br from-indigo-50 to-white rounded-xl shadow-lg p-8 hover:shadow-xl transition border-t-4 border-indigo-500">
                    <div class="text-5xl mb-4">🌐</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Wider Reach</h3>
                    <p class="text-gray-600 mb-4">Connect with thousands of verified donors actively looking to make a difference in your community.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Access to donor network
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Increased visibility
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Regular campaigns
                        </li>
                    </ul>
                </div>

                <!-- Benefit 2 -->
                <div class="bg-gradient-to-br from-green-50 to-white rounded-xl shadow-lg p-8 hover:shadow-xl transition border-t-4 border-green-500">
                    <div class="text-5xl mb-4">⚡</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Efficiency</h3>
                    <p class="text-gray-600 mb-4">Streamline your donation process with automated matching, tracking, and reporting tools.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Automated workflows
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Real-time updates
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Easy reporting
                        </li>
                    </ul>
                </div>

                <!-- Benefit 3 -->
                <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl shadow-lg p-8 hover:shadow-xl transition border-t-4 border-orange-500">
                    <div class="text-5xl mb-4">🔒</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Trust & Security</h3>
                    <p class="text-gray-600 mb-4">Build credibility with our verification badge and secure, transparent donation tracking system.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Verified status badge
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Secure transactions
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Photo verification
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works for NGOs Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Your Journey with GoodGive</h2>
                <p class="text-gray-600 text-lg">Simple steps to get started and make an impact</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Step 1 -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Apply Online</h3>
                    <p class="text-sm text-gray-600">Submit your organization details and documents</p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Verification</h3>
                    <p class="text-sm text-gray-600">We verify your NGO credentials and certifications</p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Get Approved</h3>
                    <p class="text-sm text-gray-600">Receive approval and access to your dashboard</p>
                </div>

                <!-- Step 4 -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl font-bold text-white">4</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Create Campaigns</h3>
                    <p class="text-sm text-gray-600">Post your needs and start receiving donations</p>
                </div>

                <!-- Step 5 -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl font-bold text-white">5</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Make Impact</h3>
                    <p class="text-sm text-gray-600">Distribute donations and share impact reports</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Requirements Section -->
    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Eligibility Requirements</h2>
                <p class="text-gray-600 text-lg">What you need to join our verified network</p>
            </div>

            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl shadow-xl p-8 md:p-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Required Documents -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="text-2xl mr-3">📄</span>
                            Required Documents
                        </h3>
                        <ul class="space-y-4">
                            <li class="flex items-start space-x-3">
                                <span class="text-green-500 mt-1">✓</span>
                                <div>
                                    <div class="font-semibold text-gray-900">NGO Registration Certificate</div>
                                    <div class="text-sm text-gray-600">Valid government-issued registration</div>
                                </div>
                            </li>
                            <li class="flex items-start space-x-3">
                                <span class="text-green-500 mt-1">✓</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Tax Exemption Certificate</div>
                                    <div class="text-sm text-gray-600">Proof of non-profit status</div>
                                </div>
                            </li>
                            <li class="flex items-start space-x-3">
                                <span class="text-green-500 mt-1">✓</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Director/Founder ID Proof</div>
                                    <div class="text-sm text-gray-600">Government-issued identification</div>
                                </div>
                            </li>
                            <li class="flex items-start space-x-3">
                                <span class="text-green-500 mt-1">✓</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Bank Account Details</div>
                                    <div class="text-sm text-gray-600">For donation transfers</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Eligibility Criteria -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="text-2xl mr-3">✅</span>
                            Eligibility Criteria
                        </h3>
                        <ul class="space-y-4">
                            <li class="flex items-start space-x-3">
                                <span class="text-indigo-500 mt-1">•</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Registered NGO/Non-Profit</div>
                                    <div class="text-sm text-gray-600">Must be legally registered organization</div>
                                </div>
                            </li>
                            <li class="flex items-start space-x-3">
                                <span class="text-indigo-500 mt-1">•</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Active Operations</div>
                                    <div class="text-sm text-gray-600">Minimum 6 months operational history</div>
                                </div>
                            </li>
                            <li class="flex items-start space-x-3">
                                <span class="text-indigo-500 mt-1">•</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Clear Mission</div>
                                    <div class="text-sm text-gray-600">Defined social impact goals</div>
                                </div>
                            </li>
                            <li class="flex items-start space-x-3">
                                <span class="text-indigo-500 mt-1">•</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Transparency Commitment</div>
                                    <div class="text-sm text-gray-600">Willing to share impact reports</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 p-6 bg-white rounded-xl border-l-4 border-indigo-500">
                    <div class="flex items-start space-x-3">
                        <span class="text-2xl">💡</span>
                        <div>
                            <div class="font-bold text-gray-900 mb-1">Processing Time</div>
                            <p class="text-sm text-gray-600">Applications are typically reviewed within 3-5 business days. You'll receive email updates throughout the verification process.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Success Stories</h2>
                <p class="text-gray-600 text-lg">Hear from NGOs already making an impact with GoodGive</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Story 1 -->
                <div class="bg-white rounded-xl p-8 shadow-lg border-t-4 border-indigo-500">
                    <div class="flex text-yellow-400 mb-4">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <p class="text-gray-700 mb-6 italic">"GoodGive transformed how we connect with donors. We've seen a 300% increase in donations and the platform makes everything so transparent and easy!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            ET
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Education Trust</div>
                            <div class="text-sm text-gray-500">Partner since 2023</div>
                        </div>
                    </div>
                </div>

                <!-- Story 2 -->
                <div class="bg-white rounded-xl p-8 shadow-lg border-t-4 border-green-500">
                    <div class="flex text-yellow-400 mb-4">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <p class="text-gray-700 mb-6 italic">"The verification badge instantly boosted our credibility. Donors trust us more, and we can focus on our mission instead of fundraising logistics."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            HF
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Health Foundation</div>
                            <div class="text-sm text-gray-500">Partner since 2024</div>
                        </div>
                    </div>
                </div>

                <!-- Story 3 -->
                <div class="bg-white rounded-xl p-8 shadow-lg border-t-4 border-orange-500">
                    <div class="flex text-yellow-400 mb-4">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <p class="text-gray-700 mb-6 italic">"The smart matching system connects us with donors who care about our cause. It's like having a dedicated fundraising team!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            SS
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Shelter Support</div>
                            <div class="text-sm text-gray-500">Partner since 2024</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form CTA Section -->
    <section id="application" class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Join Our Network?</h2>
            <p class="text-xl mb-8 text-indigo-100">Submit your application today and start maximizing your impact</p>
            
            <div class="bg-white rounded-2xl p-8 md:p-12 text-gray-900 shadow-2xl">
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Application Process</h3>
                    <p class="text-gray-600">Complete the form below to begin your verification</p>
                </div>

                <form class="space-y-6 text-left">
                    <!-- Organization Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Organization Name *</label>
                        <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Enter your NGO/Organization name">
                    </div>

                    <!-- Registration Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Registration Number *</label>
                        <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Your official registration number">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Official Email *</label>
                        <input type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="organization@example.com">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone *</label>
                        <input type="tel" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="+1 (555) 000-0000">
                    </div>

                    <!-- Focus Area -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Primary Focus Area *</label>
                        <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Select your focus area</option>
                            <option>Education</option>
                            <option>Healthcare</option>
                            <option>Shelter & Housing</option>
                            <option>Food Security</option>
                            <option>Child Welfare</option>
                            <option>Elderly Care</option>
                            <option>Disaster Relief</option>
                            <option>Environment</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <!-- Years Operating -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Years in Operation *</label>
                        <input type="number" required min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Number of years">
                    </div>

                    <!-- Website -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Website (Optional)</label>
                        <input type="url" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="https://yourorganization.org">
                    </div>

                    <!-- Brief Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Brief Description *</label>
                        <textarea required rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Tell us about your organization and mission..."></textarea>
                    </div>

                    <!-- File Upload Note -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <span class="text-blue-600 text-xl">📎</span>
                            <div class="text-sm text-blue-900">
                                <div class="font-semibold mb-1">Document Upload</div>
                                <p>After submission, you'll receive an email with instructions to upload your registration certificate, tax exemption documents, and ID proofs securely.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" required class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label class="text-sm text-gray-700">
                            I agree to the <a href="#" class="text-indigo-600 hover:underline">Terms & Conditions</a> and confirm that all information provided is accurate and verifiable.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition shadow-lg hover:shadow-xl">
                            Submit Application →
                        </button>
                        <p class="text-center text-sm text-gray-500 mt-4">
                            We'll review your application within 3-5 business days
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600 text-lg">Got questions? We've got answers</p>
            </div>

            <div class="space-y-6">
                <!-- FAQ 1 -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-indigo-500">
                    <h3 class="font-bold text-gray-900 mb-2">Is there any fee to join GoodGive?</h3>
                    <p class="text-gray-600">No! GoodGive is completely free for NGOs. We don't charge any registration fees, monthly fees, or take any commission from donations. 100% of donations go directly to your organization.</p>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-green-500">
                    <h3 class="font-bold text-gray-900 mb-2">How long does verification take?</h3>
                    <p class="text-gray-600">The verification process typically takes 3-5 business days. We thoroughly review all documentation to ensure our platform maintains the highest standards of trust and credibility.</p>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-blue-500">
                    <h3 class="font-bold text-gray-900 mb-2">What if my organization is new?</h3>
                    <p class="text-gray-600">We require a minimum of 6 months operational history. This helps us maintain quality standards and protect donors. If you're just starting out, we encourage you to reapply once you meet this requirement.</p>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-orange-500">
                    <h3 class="font-bold text-gray-900 mb-2">Can international NGOs apply?</h3>
                    <p class="text-gray-600">Currently, we're focused on local organizations, but we're expanding internationally. Contact us at partners@goodgive.org to express your interest, and we'll notify you when we launch in your region.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-between items-center">
                <div class="text-sm">© 2025 GoodGive. All rights reserved.</div>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="hover:text-white transition">Privacy</a>
                    <a href="#" class="hover:text-white transition">Terms</a>
                    <a href="#" class="hover:text-white transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
