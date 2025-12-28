<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GoodGive') }} - Home</title>

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
    <section class="bg-gradient-to-br from-gray-50 to-blue-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Donate Smarter.<br>
                        Help Faster.
                    </h1>
                    <div class="border-b-4 border-orange-500 w-24 mb-6"></div>
                    
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <span class="text-gray-700 font-medium">Verified NGOs</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                            <span class="text-gray-700 font-medium">Safe Donations</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            <span class="text-gray-700 font-medium">Real-Time Tracking</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('ngos-posts') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-full font-semibold transition shadow-lg hover:shadow-xl">
                            Donate Now →
                        </a>
                        <a href="{{ route('join-staff') }}" class="bg-white hover:bg-gray-50 text-gray-900 border-2 border-gray-300 px-8 py-3 rounded-full font-semibold transition">
                            Register as NGO
                        </a>
                    </div>
                </div>

                <!-- Right Content - Stats Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">🎯</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Active Campaigns</h3>
                            <p class="text-sm text-gray-500">Right now, impacting lives</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6 mb-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-1">2.4K</div>
                            <div class="text-sm text-gray-500">Donors</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-1">156</div>
                            <div class="text-sm text-gray-500">NGOs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-pink-600 mb-1">98%</div>
                            <div class="text-sm text-gray-500">Reached</div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Recent Activity</h4>
                        <div class="space-y-2">
                            <div class="h-2 bg-gradient-to-r from-blue-500 to-blue-400 rounded-full w-full"></div>
                            <div class="h-2 bg-gradient-to-r from-orange-500 to-orange-400 rounded-full w-5/6"></div>
                            <div class="h-2 bg-gradient-to-r from-blue-600 to-blue-500 rounded-full w-4/5"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-gray-600">Three simple steps to transform lives</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                            <span class="text-4xl font-bold text-white">1</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Browse NGOs</h3>
                    <p class="text-gray-600 mb-4">Explore verified organizations and discover their current needs in real-time</p>
                    <div class="text-4xl">🔍</div>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                            <span class="text-4xl font-bold text-white">2</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Choose Items</h3>
                    <p class="text-gray-600 mb-4">Select non-food essentials from curated wishlists and make secure donations</p>
                    <div class="text-4xl">🎁</div>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                            <span class="text-4xl font-bold text-white">3</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Track Impact</h3>
                    <p class="text-gray-600 mb-4">Monitor your donation journey with live updates and impact metrics</p>
                    <div class="text-4xl">📊</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted Partners Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Trusted Partners</h2>
                <p class="text-gray-600">Verified organizations creating real change</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Partner 1 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition border-t-4 border-indigo-500">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-2xl">✓</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Education Trust</h3>
                    <p class="text-gray-600 mb-4">Empowering through learning</p>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span>94% Impact Score</span>
                    </div>
                    <p class="text-xs text-gray-400">School supplies • Books • Uniforms</p>
                </div>

                <!-- Partner 2 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition border-t-4 border-orange-500">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-2xl">✓</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Health Foundation</h3>
                    <p class="text-gray-600 mb-4">Wellness for all communities</p>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span>96% Impact Score</span>
                    </div>
                    <p class="text-xs text-gray-400">Medical supplies • Hygiene kits</p>
                </div>

                <!-- Partner 3 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition border-t-4 border-blue-500">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-2xl">✓</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Shelter Support</h3>
                    <p class="text-gray-600 mb-4">Safe spaces, warm hearts</p>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span>95% Impact Score</span>
                    </div>
                    <p class="text-xs text-gray-400">Clothing • Blankets • Essentials</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Badges Section -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-indigo-50 rounded-xl p-8 text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">🔒</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Bank-Grade Security</h3>
                    <p class="text-sm text-gray-600">256-bit encryption</p>
                </div>

                <div class="bg-green-50 rounded-xl p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">✓</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">100% Verified</h3>
                    <p class="text-sm text-gray-600">Every NGO authenticated</p>
                </div>

                <div class="bg-orange-50 rounded-xl p-8 text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">⚡</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Instant Impact</h3>
                    <p class="text-sm text-gray-600">Track in real-time</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Loved by <span class="underline decoration-orange-500 decoration-4">Thousands</span></h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gradient-to-br from-indigo-50 to-white rounded-xl p-8 shadow-lg border-t-4 border-indigo-500">
                    <div class="flex text-yellow-400 mb-4">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <p class="text-gray-700 mb-6 italic">"This platform completely changed how I give back. The transparency and ease of use are unmatched!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            S
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Sarah Mitchell</div>
                            <div class="text-sm text-gray-500">Donor since 2023</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-8 shadow-lg border-t-4 border-green-500">
                    <div class="flex text-yellow-400 mb-4">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <p class="text-gray-700 mb-6 italic">"As an NGO director, GoodGive has revolutionized our fundraising. Incredible platform and support!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            P
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Priya Kumar</div>
                            <div class="text-sm text-gray-500">NGO Director</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl p-8 shadow-lg border-t-4 border-orange-500">
                    <div class="flex text-yellow-400 mb-4">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <p class="text-gray-700 mb-6 italic">"Transparent, secure, and impactful. GoodGive sets the standard for modern giving."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            M
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">Michael Torres</div>
                            <div class="text-sm text-gray-500">Corporate Donor</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Make a Difference?</h2>
            <p class="text-xl mb-8 text-indigo-100">Join thousands of donors supporting verified NGOs</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('login') }}" class="bg-white hover:bg-gray-100 text-indigo-600 px-8 py-4 rounded-full font-bold text-lg transition shadow-lg">
                    Get Started
                </a>
                <a href="{{ route('how-it-works') }}" class="bg-indigo-700 hover:bg-indigo-800 text-white border-2 border-white px-8 py-4 rounded-full font-bold text-lg transition">
                    Learn More
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
