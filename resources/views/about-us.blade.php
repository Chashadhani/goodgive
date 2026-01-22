<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - {{ config('app.name', 'GoodGive') }}</title>

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
    <section class="bg-gradient-to-br from-gray-50 to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                About GoodGive
            </h1>
            <div class="border-b-4 border-orange-500 w-24 mx-auto mb-6"></div>
            
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Transforming the way people give, connecting hearts with hands, and building a more compassionate world through transparent, verified donations.
            </p>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Mission -->
                <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-2xl p-8 border-t-4 border-orange-500 shadow-lg">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center mb-6 shadow-lg">
                        <span class="text-3xl">🎯</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        To create a transparent, efficient, and trustworthy platform that bridges the gap between those who want to help and those who need it most.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        We empower donors, NGOs, and beneficiaries through technology, ensuring every donation makes the maximum impact and reaches the right hands at the right time.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-8 border-t-4 border-indigo-500 shadow-lg">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mb-6 shadow-lg">
                        <span class="text-3xl">🌟</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Vision</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        A world where giving is simple, transparent, and impactful—where every person in need has access to essential resources through a verified network of compassionate donors and dedicated organizations.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        We envision building the largest trusted giving community that transforms lives and strengthens communities globally.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Story</h2>
                <div class="border-b-4 border-blue-500 w-24 mx-auto mb-6"></div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 leading-relaxed mb-6">
                        GoodGive was born from a simple observation: traditional charity processes often lack transparency, making donors unsure if their contributions truly reach those in need. Meanwhile, NGOs struggle with complex fundraising processes, and beneficiaries face barriers in accessing help.
                    </p>
                    
                    <p class="text-gray-700 leading-relaxed mb-6">
                        In 2023, our founding team—comprising technologists, social workers, and nonprofit veterans—came together with a shared vision: to revolutionize charitable giving through technology. We believed that with the right platform, we could create a seamless connection between donors, NGOs, and those who need help.
                    </p>
                    
                    <p class="text-gray-700 leading-relaxed mb-6">
                        Today, GoodGive serves thousands of users across multiple communities. Every donation is tracked, every NGO is verified, and every beneficiary is supported with dignity. We've built more than just a platform—we've created a movement of conscious giving.
                    </p>

                    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-6 border-l-4 border-indigo-500 mt-8">
                        <p class="text-gray-800 italic font-medium">
                            "We believe that transparency and technology can transform charity from a transaction into a meaningful connection between human beings."
                        </p>
                        <p class="text-gray-600 mt-3 text-sm">— The GoodGive Team</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
                <p class="text-gray-600 text-lg">The principles that guide everything we do</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Value 1 -->
                <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-white rounded-xl border-2 border-orange-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-3xl">🔍</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Transparency</h3>
                    <p class="text-gray-600">Every donation tracked, every step visible. No hidden processes, just clear, honest giving.</p>
                </div>

                <!-- Value 2 -->
                <div class="text-center p-6 bg-gradient-to-br from-indigo-50 to-white rounded-xl border-2 border-indigo-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-3xl">✓</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Trust</h3>
                    <p class="text-gray-600">Verified NGOs, authenticated users, and secure transactions. Trust is earned, not assumed.</p>
                </div>

                <!-- Value 3 -->
                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-white rounded-xl border-2 border-blue-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-3xl">💪</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Empowerment</h3>
                    <p class="text-gray-600">Giving everyone—donors, NGOs, and beneficiaries—the tools to create real change.</p>
                </div>

                <!-- Value 4 -->
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-white rounded-xl border-2 border-green-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-3xl">❤️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Compassion</h3>
                    <p class="text-gray-600">Every person deserves dignity and support. We lead with empathy in all we do.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Stats Section -->
    <section class="py-20 bg-gradient-to-br from-indigo-600 to-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Our Impact in Numbers</h2>
                <p class="text-indigo-100 text-lg">Making a real difference, one donation at a time</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-bold mb-2">2,400+</div>
                    <div class="text-indigo-100 text-lg">Active Donors</div>
                    <div class="mt-2 text-sm text-indigo-200">Making regular contributions</div>
                </div>

                <div class="text-center">
                    <div class="text-5xl font-bold mb-2">156</div>
                    <div class="text-indigo-100 text-lg">Verified NGOs</div>
                    <div class="mt-2 text-sm text-indigo-200">Trusted organizations</div>
                </div>

                <div class="text-center">
                    <div class="text-5xl font-bold mb-2">8,500+</div>
                    <div class="text-indigo-100 text-lg">Lives Impacted</div>
                    <div class="mt-2 text-sm text-indigo-200">Beneficiaries helped</div>
                </div>

                <div class="text-center">
                    <div class="text-5xl font-bold mb-2">98%</div>
                    <div class="text-indigo-100 text-lg">Success Rate</div>
                    <div class="mt-2 text-sm text-indigo-200">Donations delivered</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose GoodGive?</h2>
                <p class="text-gray-600 text-lg">What makes us different from traditional charity platforms</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition border-t-4 border-orange-500">
                    <div class="text-4xl mb-4">🔐</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">100% Verification</h3>
                    <p class="text-gray-600 mb-4">Every NGO undergoes rigorous verification. Every donor is authenticated. Every beneficiary is validated.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Document verification
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Background checks
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Regular audits
                        </li>
                    </ul>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition border-t-4 border-indigo-500">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Real-Time Tracking</h3>
                    <p class="text-gray-600 mb-4">Follow your donation from the moment you give until it reaches the beneficiary's hands.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Live status updates
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Photo verification
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Impact reports
                        </li>
                    </ul>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition border-t-4 border-blue-500">
                    <div class="text-4xl mb-4">🤖</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Smart Matching</h3>
                    <p class="text-gray-600 mb-4">Our intelligent system matches donations with needs for maximum impact and efficiency.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            AI-powered matching
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Priority needs first
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Optimal distribution
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-orange-500 to-yellow-500 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Join Our Mission</h2>
            <p class="text-xl mb-8 text-orange-50">Be part of a community that's making giving transparent, trustworthy, and impactful</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-orange-600 px-8 py-4 rounded-full font-bold text-lg transition shadow-lg">
                    Get Started Today
                </a>
                <a href="{{ route('how-it-works') }}" class="bg-orange-600 hover:bg-orange-700 text-white border-2 border-white px-8 py-4 rounded-full font-bold text-lg transition">
                    Learn How It Works
                </a>
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
