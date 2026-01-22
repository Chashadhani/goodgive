<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>How It Works - {{ config('app.name', 'GoodGive') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-white" x-data="{ activeTab: 'needhelp' }">
    <x-navbar />
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-gray-50 to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                How GoodGive Works
            </h1>
            <div class="border-b-4 border-orange-500 w-24 mx-auto mb-6"></div>
            
            <p class="text-lg text-gray-700 max-w-3xl mx-auto mb-8">
                Discover how our platform connects donors, NGOs, and those in need through a transparent, secure, and efficient donation process.
            </p>

            <div class="flex flex-wrap justify-center gap-6 max-w-2xl mx-auto">
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                    <span class="text-gray-700 font-medium">Those Who Need Help</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                    <span class="text-gray-700 font-medium">For NGOs</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    <span class="text-gray-700 font-medium">For Donors</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Tab Navigation -->
    <section id="content" class="bg-white border-b-2 border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center space-x-2 md:space-x-8">
                <!-- Tab 1 -->
                <button 
                    @click="activeTab = 'needhelp'" 
                    :class="activeTab === 'needhelp' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-4 px-6 border-b-4 font-semibold transition-colors duration-200">
                    <span class="hidden md:inline">Those Who Need Help</span>
                    <span class="md:hidden">Need Help</span>
                </button>
                
                <!-- Tab 2 -->
                <button 
                    @click="activeTab = 'ngo'" 
                    :class="activeTab === 'ngo' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-4 px-6 border-b-4 font-semibold transition-colors duration-200">
                    For NGOs
                </button>
                
                <!-- Tab 3 -->
                <button 
                    @click="activeTab = 'donor'" 
                    :class="activeTab === 'donor' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-4 px-6 border-b-4 font-semibold transition-colors duration-200">
                    For Donors
                </button>
            </div>
        </div>
    </section>

    <!-- Tab Content -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Those Who Need Help Section -->
            <div x-show="activeTab === 'needhelp'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="text-center mb-16">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <span class="text-4xl">🤝</span>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">For Those Who Need Help</h2>
                    <p class="text-xl text-gray-600">Get the support you need with dignity and transparency</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    <!-- Step 1 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-orange-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">1</span>
                            </div>
                            <span class="text-4xl">📝</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Register with Proof</h3>
                        <p class="text-gray-600 leading-relaxed">Create your account and submit verification documents to ensure genuine assistance reaches those who truly need it.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-orange-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">2</span>
                            </div>
                            <span class="text-4xl">📋</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Request Your Needs</h3>
                        <p class="text-gray-600 leading-relaxed">Submit a detailed list of essential items you need. Be specific to help us match you with the right donations.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-orange-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">3</span>
                            </div>
                            <span class="text-4xl">🔄</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Staff Matching Process</h3>
                        <p class="text-gray-600 leading-relaxed">Our staff intelligently matches your needs with available donation stocks from verified donors and NGOs.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-orange-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">4</span>
                            </div>
                            <span class="text-4xl">📦</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Receive Donations</h3>
                        <p class="text-gray-600 leading-relaxed">Get notified when items are ready for collection or delivery. Track your donation status in real-time.</p>
                    </div>

                    <!-- Step 5 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-orange-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">5</span>
                            </div>
                            <span class="text-4xl">✅</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Verify Donor with Proof</h3>
                        <p class="text-gray-600 leading-relaxed">Confirm receipt of donations with photographic proof, ensuring transparency and accountability for all parties.</p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="text-center bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl p-12 shadow-xl">
                    <h3 class="text-3xl font-bold text-white mb-4">Need Help? We're Here for You</h3>
                    <p class="text-orange-50 mb-6 text-lg">Register now and get connected with verified donors and NGOs</p>
                    <a href="{{ route('register') }}" class="inline-block bg-white hover:bg-gray-100 text-orange-600 px-8 py-4 rounded-full font-bold text-lg transition shadow-lg">
                        Get Started →
                    </a>
                </div>
            </div>

            <!-- For NGOs Section -->
            <div x-show="activeTab === 'ngo'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="text-center mb-16">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <span class="text-4xl">🏢</span>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">For NGOs</h2>
                    <p class="text-xl text-gray-600">Streamline your operations and maximize your impact</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    <!-- Step 1 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-indigo-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">1</span>
                            </div>
                            <span class="text-4xl">🔐</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Register with Proof</h3>
                        <p class="text-gray-600 leading-relaxed">Submit your NGO registration documents, certifications, and verification details to join our trusted network.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-indigo-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">2</span>
                            </div>
                            <span class="text-4xl">📢</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Request Needs</h3>
                        <p class="text-gray-600 leading-relaxed">Post your organization's current requirements and create campaigns for specific causes or communities you serve.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-indigo-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">3</span>
                            </div>
                            <span class="text-4xl">🤖</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Staff Matching System</h3>
                        <p class="text-gray-600 leading-relaxed">Our automated system matches incoming donations with your posted needs and available inventory for optimal distribution.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-indigo-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">4</span>
                            </div>
                            <span class="text-4xl">🎁</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Distribute Donations</h3>
                        <p class="text-gray-600 leading-relaxed">Receive and distribute matched donations to beneficiaries. Track everything in your centralized dashboard.</p>
                    </div>

                    <!-- Step 5 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-indigo-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">5</span>
                            </div>
                            <span class="text-4xl">📸</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Verify Donor with Proof</h3>
                        <p class="text-gray-600 leading-relaxed">Upload proof of distribution with photos and documentation, building trust and transparency with your donor community.</p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="text-center bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-12 shadow-xl">
                    <h3 class="text-3xl font-bold text-white mb-4">Join Our Network of Verified NGOs</h3>
                    <p class="text-indigo-50 mb-6 text-lg">Scale your impact with our powerful donation management platform</p>
                    <a href="{{ route('join-staff') }}" class="inline-block bg-white hover:bg-gray-100 text-indigo-600 px-8 py-4 rounded-full font-bold text-lg transition shadow-lg">
                        Register Your NGO →
                    </a>
                </div>
            </div>

            <!-- For Donors Section -->
            <div x-show="activeTab === 'donor'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="text-center mb-16">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <span class="text-4xl">💝</span>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">For Donors</h2>
                    <p class="text-xl text-gray-600">Make a difference with transparent, trackable donations</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    <!-- Step 1 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-blue-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">1</span>
                            </div>
                            <span class="text-4xl">👤</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Register as Donor</h3>
                        <p class="text-gray-600 leading-relaxed">Create your donor account in minutes. Set your preferences and start making an impact right away.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-blue-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">2</span>
                            </div>
                            <span class="text-4xl">🛍️</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Donate Items</h3>
                        <p class="text-gray-600 leading-relaxed">Browse verified NGO wishlists and select items to donate. Choose from specific needs or general essentials.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-blue-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">3</span>
                            </div>
                            <span class="text-4xl">⚙️</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Staff Match with Needs</h3>
                        <p class="text-gray-600 leading-relaxed">Our system intelligently matches your donation with those who need it most, ensuring maximum impact.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-blue-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">4</span>
                            </div>
                            <span class="text-4xl">💳</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Complete Donation</h3>
                        <p class="text-gray-600 leading-relaxed">Securely complete your donation with our bank-grade payment system. Get instant confirmation and receipt.</p>
                    </div>

                    <!-- Step 5 -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 border-t-4 border-blue-500 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-white">5</span>
                            </div>
                            <span class="text-4xl">🔔</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Verify Donation Impact</h3>
                        <p class="text-gray-600 leading-relaxed">Receive photographic proof and updates when your donation reaches its recipient. Track your impact in real-time.</p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="text-center bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl p-12 shadow-xl">
                    <h3 class="text-3xl font-bold text-white mb-4">Start Making a Difference Today</h3>
                    <p class="text-blue-50 mb-6 text-lg">Join thousands of donors changing lives with transparent giving</p>
                    <a href="{{ route('register') }}" class="inline-block bg-white hover:bg-gray-100 text-blue-600 px-8 py-4 rounded-full font-bold text-lg transition shadow-lg">
                        Become a Donor →
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- Trust & Safety Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose GoodGive?</h2>
                <p class="text-gray-600">Built on transparency, trust, and technology</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-white rounded-xl border-2 border-green-200">
                    <div class="text-4xl mb-3">✓</div>
                    <h3 class="font-bold text-gray-900 mb-2">100% Verified</h3>
                    <p class="text-sm text-gray-600">All users authenticated</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-white rounded-xl border-2 border-blue-200">
                    <div class="text-4xl mb-3">🔒</div>
                    <h3 class="font-bold text-gray-900 mb-2">Secure Platform</h3>
                    <p class="text-sm text-gray-600">Bank-grade encryption</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-white rounded-xl border-2 border-purple-200">
                    <div class="text-4xl mb-3">📊</div>
                    <h3 class="font-bold text-gray-900 mb-2">Real-Time Tracking</h3>
                    <p class="text-sm text-gray-600">Monitor every donation</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-white rounded-xl border-2 border-orange-200">
                    <div class="text-4xl mb-3">📸</div>
                    <h3 class="font-bold text-gray-900 mb-2">Photo Verification</h3>
                    <p class="text-sm text-gray-600">Proof of every delivery</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-20 bg-gradient-to-r from-gray-900 to-gray-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl mb-8 text-gray-300">Choose your path and join our community today</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-full font-bold text-lg transition shadow-lg">
                    Register Now
                </a>
                <a href="{{ route('ngos-posts') }}" class="bg-white hover:bg-gray-100 text-gray-900 px-8 py-4 rounded-full font-bold text-lg transition shadow-lg">
                    Browse NGOs
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
