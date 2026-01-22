<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Our Work - {{ config('app.name', 'GoodGive') }}</title>

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
                Our Work & Impact
            </h1>
            <div class="border-b-4 border-orange-500 w-24 mx-auto mb-6"></div>
            
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Discover the real-world impact we're creating together. Every donation, every NGO, every story represents lives changed and communities strengthened.
            </p>
        </div>
    </section>

    <!-- Impact Numbers Section -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Impact at a Glance</h2>
                <p class="text-indigo-100 text-lg">Numbers that tell our story of change</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-white bg-opacity-10 rounded-xl backdrop-blur-sm">
                    <div class="text-5xl font-bold mb-2">8,500+</div>
                    <div class="text-indigo-100 text-lg mb-1">Lives Impacted</div>
                    <div class="text-sm text-indigo-200">Beneficiaries helped</div>
                </div>

                <div class="text-center p-6 bg-white bg-opacity-10 rounded-xl backdrop-blur-sm">
                    <div class="text-5xl font-bold mb-2">156</div>
                    <div class="text-indigo-100 text-lg mb-1">NGO Partners</div>
                    <div class="text-sm text-indigo-200">Verified organizations</div>
                </div>

                <div class="text-center p-6 bg-white bg-opacity-10 rounded-xl backdrop-blur-sm">
                    <div class="text-5xl font-bold mb-2">2,400+</div>
                    <div class="text-indigo-100 text-lg mb-1">Active Donors</div>
                    <div class="text-sm text-indigo-200">Generous contributors</div>
                </div>

                <div class="text-center p-6 bg-white bg-opacity-10 rounded-xl backdrop-blur-sm">
                    <div class="text-5xl font-bold mb-2">$2.4M</div>
                    <div class="text-indigo-100 text-lg mb-1">Total Donated</div>
                    <div class="text-sm text-indigo-200">Since 2023</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                <div class="text-center p-6 bg-white bg-opacity-10 rounded-xl backdrop-blur-sm">
                    <div class="text-4xl font-bold mb-2">342</div>
                    <div class="text-indigo-100">Active Campaigns</div>
                </div>

                <div class="text-center p-6 bg-white bg-opacity-10 rounded-xl backdrop-blur-sm">
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <div class="text-indigo-100">Success Rate</div>
                </div>

                <div class="text-center p-6 bg-white bg-opacity-10 rounded-xl backdrop-blur-sm">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-indigo-100">Platform Availability</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Focus Areas Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Focus Areas</h2>
                <p class="text-gray-600 text-lg">Creating impact across multiple sectors</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Focus Area 1 -->
                <div class="group bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-indigo-100 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-3xl">📚</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Education</h3>
                    <div class="text-3xl font-bold text-indigo-600 mb-2">2,100+</div>
                    <p class="text-gray-600 mb-4">Students supported with school supplies, uniforms, and learning materials</p>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            42 schools benefited
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            1,200+ books distributed
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            95% attendance improvement
                        </div>
                    </div>
                </div>

                <!-- Focus Area 2 -->
                <div class="group bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-red-100 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🏥</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Healthcare</h3>
                    <div class="text-3xl font-bold text-red-600 mb-2">1,800+</div>
                    <p class="text-gray-600 mb-4">Individuals received medical supplies, hygiene kits, and health services</p>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            28 clinics equipped
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            5,000+ hygiene kits
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            100% verified distribution
                        </div>
                    </div>
                </div>

                <!-- Focus Area 3 -->
                <div class="group bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-blue-100 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🏠</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Shelter & Housing</h3>
                    <div class="text-3xl font-bold text-blue-600 mb-2">1,200+</div>
                    <p class="text-gray-600 mb-4">Families provided with bedding, clothing, and essential shelter items</p>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            18 shelters supported
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            3,000+ blankets distributed
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Winter preparation complete
                        </div>
                    </div>
                </div>

                <!-- Focus Area 4 -->
                <div class="group bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🍽️</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Food Security</h3>
                    <div class="text-3xl font-bold text-green-600 mb-2">1,600+</div>
                    <p class="text-gray-600 mb-4">Families supported with kitchen equipment and food distribution resources</p>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            15 food banks equipped
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Daily meal distribution
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Zero waste initiative
                        </div>
                    </div>
                </div>

                <!-- Focus Area 5 -->
                <div class="group bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-pink-100 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-3xl">👶</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Child Welfare</h3>
                    <div class="text-3xl font-bold text-pink-600 mb-2">900+</div>
                    <p class="text-gray-600 mb-4">Children provided with toys, learning materials, and developmental support</p>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            22 children centers
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            2,500+ toys distributed
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Educational programs active
                        </div>
                    </div>
                </div>

                <!-- Focus Area 6 -->
                <div class="group bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-purple-100 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-3xl">👴</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Elderly Care</h3>
                    <div class="text-3xl font-bold text-purple-600 mb-2">900+</div>
                    <p class="text-gray-600 mb-4">Senior citizens supported with mobility aids and comfort items</p>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            12 care homes supported
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            350+ mobility aids provided
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Quality of life improved
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Success Stories</h2>
                <p class="text-gray-600 text-lg">Real stories of lives transformed through giving</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Story 1 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="h-64 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                        <span class="text-8xl">📚</span>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-full">Education</span>
                            <span class="text-gray-500 text-sm">March 2025</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Rural School Transformation</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Through our platform, Education Trust received 1,200 books, 300 school supply kits, and 150 uniforms for students in rural communities. Attendance improved by 95%, and test scores increased by 40%.
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div>
                                <div class="text-2xl font-bold text-indigo-600">300+</div>
                                <div class="text-sm text-gray-600">Students Benefited</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-indigo-600">95%</div>
                                <div class="text-sm text-gray-600">Attendance Rate</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-indigo-600">$45K</div>
                                <div class="text-sm text-gray-600">Donations</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story 2 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="h-64 bg-gradient-to-br from-red-400 to-pink-500 flex items-center justify-center">
                        <span class="text-8xl">🏥</span>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-sm font-semibold rounded-full">Healthcare</span>
                            <span class="text-gray-500 text-sm">January 2026</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Community Health Center Equipped</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Health Foundation's rural clinic received complete medical equipment and supplies serving 500+ families. The center now provides daily health services with 100% verified distribution and real-time tracking.
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div>
                                <div class="text-2xl font-bold text-red-600">500+</div>
                                <div class="text-sm text-gray-600">Families Served</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-red-600">Daily</div>
                                <div class="text-sm text-gray-600">Services</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-red-600">$62K</div>
                                <div class="text-sm text-gray-600">Donations</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story 3 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="h-64 bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center">
                        <span class="text-8xl">🏠</span>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-semibold rounded-full">Shelter</span>
                            <span class="text-gray-500 text-sm">December 2025</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Winter Preparation Success</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Shelter Support received blankets, winter clothing, and bedding for 200 families. Every resident was prepared for winter with verified delivery, ensuring warmth and comfort during cold months.
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div>
                                <div class="text-2xl font-bold text-blue-600">200</div>
                                <div class="text-sm text-gray-600">Families Helped</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-blue-600">100%</div>
                                <div class="text-sm text-gray-600">Verified</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-blue-600">$38K</div>
                                <div class="text-sm text-gray-600">Donations</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story 4 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="h-64 bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center">
                        <span class="text-8xl">👶</span>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="px-3 py-1 bg-pink-100 text-pink-700 text-sm font-semibold rounded-full">Child Welfare</span>
                            <span class="text-gray-500 text-sm">November 2025</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Children's Center Revival</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Children First received toys, educational materials, and art supplies for 120 children. The center now runs active learning programs with improved development metrics and happier children.
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div>
                                <div class="text-2xl font-bold text-pink-600">120</div>
                                <div class="text-sm text-gray-600">Children</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-pink-600">85%</div>
                                <div class="text-sm text-gray-600">Development</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-pink-600">$28K</div>
                                <div class="text-sm text-gray-600">Donations</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Monthly Impact Timeline -->
    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Recent Impact Timeline</h2>
                <p class="text-gray-600 text-lg">Our journey over the past months</p>
            </div>

            <div class="space-y-8">
                <!-- Timeline Item 1 -->
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-sm">JAN</span>
                        </div>
                    </div>
                    <div class="flex-1 bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl p-6 border-l-4 border-orange-500">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">January 2026 - Record Month</h3>
                        <p class="text-gray-600 mb-3">Achieved highest monthly donations with 420 successful campaigns and 1,200+ beneficiaries reached.</p>
                        <div class="flex flex-wrap gap-4 text-sm">
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-orange-700">420 Campaigns</span>
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-orange-700">$285K Raised</span>
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-orange-700">1,200+ Lives</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Item 2 -->
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-sm">DEC</span>
                        </div>
                    </div>
                    <div class="flex-1 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-6 border-l-4 border-indigo-500">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">December 2025 - Holiday Season Impact</h3>
                        <p class="text-gray-600 mb-3">Winter preparation campaign success with 45 NGOs receiving essential supplies for vulnerable communities.</p>
                        <div class="flex flex-wrap gap-4 text-sm">
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-indigo-700">45 NGOs</span>
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-indigo-700">$215K Raised</span>
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-indigo-700">Winter Ready</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Item 3 -->
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-sm">NOV</span>
                        </div>
                    </div>
                    <div class="flex-1 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border-l-4 border-green-500">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">November 2025 - Platform Milestone</h3>
                        <p class="text-gray-600 mb-3">Crossed 2,000 active donors milestone and launched enhanced photo verification system for transparency.</p>
                        <div class="flex flex-wrap gap-4 text-sm">
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-green-700">2,000+ Donors</span>
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-green-700">Photo Verification</span>
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-green-700">New Features</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Item 4 -->
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-sm">OCT</span>
                        </div>
                    </div>
                    <div class="flex-1 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 border-l-4 border-blue-500">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">October 2025 - Education Focus</h3>
                        <p class="text-gray-600 mb-3">Major education initiative benefiting 50+ schools with supplies for new academic year.</p>
                        <div class="flex flex-wrap gap-4 text-sm">
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-blue-700">50+ Schools</span>
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-blue-700">$180K Raised</span>
                            <span class="px-3 py-1 bg-white rounded-full font-semibold text-blue-700">Back to School</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Transparency Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Commitment to Transparency</h2>
                <p class="text-gray-600 text-lg">Every donation tracked, every impact verified</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="text-5xl mb-4">📸</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Photo Verification</h3>
                    <div class="text-3xl font-bold text-indigo-600 mb-2">100%</div>
                    <p class="text-gray-600">All donations verified with photographic proof</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="text-5xl mb-4">📊</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Real-Time Tracking</h3>
                    <div class="text-3xl font-bold text-indigo-600 mb-2">24/7</div>
                    <p class="text-gray-600">Track your donation journey anytime, anywhere</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="text-5xl mb-4">✓</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Verified NGOs</h3>
                    <div class="text-3xl font-bold text-indigo-600 mb-2">156</div>
                    <p class="text-gray-600">Thoroughly vetted and authenticated partners</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-orange-500 to-yellow-500 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Be Part of Our Story</h2>
            <p class="text-xl mb-8 text-orange-50">Join thousands of donors creating real change in communities</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('ngos-posts') }}" class="bg-white hover:bg-gray-100 text-orange-600 px-8 py-4 rounded-full font-bold text-lg transition shadow-lg">
                    Browse Campaigns
                </a>
                <a href="{{ route('register') }}" class="bg-orange-600 hover:bg-orange-700 text-white border-2 border-white px-8 py-4 rounded-full font-bold text-lg transition">
                    Start Donating
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
