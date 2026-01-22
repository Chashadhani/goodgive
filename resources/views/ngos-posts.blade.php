<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NGO Posts - {{ config('app.name', 'GoodGive') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <x-navbar />
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-gray-50 to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    NGO Posts & Needs
                </h1>
                <div class="border-b-4 border-orange-500 w-24 mx-auto mb-6"></div>
                <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                    Browse posts from verified NGOs and discover their current needs
                </p>
            </div>

            <!-- Search & Filter Bar -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <input 
                                type="text" 
                                placeholder="Search NGO posts..." 
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            >
                        </div>
                        <!-- Category Filter -->
                        <div>
                            <select class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option>All Categories</option>
                                <option>Education</option>
                                <option>Healthcare</option>
                                <option>Shelter</option>
                                <option>Food Security</option>
                                <option>Child Welfare</option>
                                <option>Elderly Care</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Posts Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Recent Posts</h2>
                    <p class="text-gray-600 mt-1">Latest needs from verified NGOs</p>
                </div>
                <div>
                    <select class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        <option>Most Recent</option>
                        <option>Most Urgent</option>
                        <option>Popular</option>
                    </select>
                </div>
            </div>

            <!-- Posts Grid - This will be populated with dynamic data -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Sample Post Card 1 - Education -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                    <!-- Post Image/Header -->
                    <div class="h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                        <span class="text-6xl">📚</span>
                    </div>
                    
                    <!-- Post Content -->
                    <div class="p-6">
                        <!-- NGO Info -->
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                ET
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Education Trust</h3>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                        
                        <!-- Post Title -->
                        <h4 class="text-lg font-bold text-gray-900 mb-2">School Supplies Needed</h4>
                        
                        <!-- Post Description -->
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            We need school supplies for 100 students including notebooks, pencils, and backpacks for the new academic year.
                        </p>
                        
                        <!-- Tags/Category -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full">Education</span>
                            <span class="px-3 py-1 bg-orange-50 text-orange-700 text-xs font-semibold rounded-full">Urgent</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <button class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold transition text-sm">
                                View Details
                            </button>
                            <button class="px-4 py-2 border-2 border-gray-300 hover:bg-gray-50 rounded-lg transition">
                                ❤️
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sample Post Card 2 - Healthcare -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-red-400 to-pink-500 flex items-center justify-center">
                        <span class="text-6xl">🏥</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                HF
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Health Foundation</h3>
                                <p class="text-xs text-gray-500">5 hours ago</p>
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Medical Supplies Required</h4>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            Urgent need for medical equipment and first aid supplies for our rural health center serving 500+ families.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-full">Healthcare</span>
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 text-xs font-semibold rounded-full">Featured</span>
                        </div>
                        <div class="flex gap-2">
                            <button class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold transition text-sm">
                                View Details
                            </button>
                            <button class="px-4 py-2 border-2 border-gray-300 hover:bg-gray-50 rounded-lg transition">
                                ❤️
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sample Post Card 3 - Shelter -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center">
                        <span class="text-6xl">🏠</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                SS
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Shelter Support</h3>
                                <p class="text-xs text-gray-500">1 day ago</p>
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Winter Clothing Drive</h4>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            Collecting warm clothing, blankets, and winter essentials for 50 families in our shelter program.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full">Shelter</span>
                        </div>
                        <div class="flex gap-2">
                            <button class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold transition text-sm">
                                View Details
                            </button>
                            <button class="px-4 py-2 border-2 border-gray-300 hover:bg-gray-50 rounded-lg transition">
                                ❤️
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sample Post Card 4 - Food Security -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                        <span class="text-6xl">🍽️</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                FH
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Food Heroes</h3>
                                <p class="text-xs text-gray-500">2 days ago</p>
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Kitchen Equipment Needed</h4>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            Help us expand our food bank with commercial kitchen equipment to serve 200+ families daily.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full">Food Security</span>
                        </div>
                        <div class="flex gap-2">
                            <button class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold transition text-sm">
                                View Details
                            </button>
                            <button class="px-4 py-2 border-2 border-gray-300 hover:bg-gray-50 rounded-lg transition">
                                ❤️
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sample Post Card 5 - Child Welfare -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center">
                        <span class="text-6xl">👶</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                CF
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Children First</h3>
                                <p class="text-xs text-gray-500">3 days ago</p>
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Educational Toys & Books</h4>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            Seeking educational toys, books, and art supplies for 80 children at our learning center.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-pink-50 text-pink-700 text-xs font-semibold rounded-full">Child Welfare</span>
                        </div>
                        <div class="flex gap-2">
                            <button class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold transition text-sm">
                                View Details
                            </button>
                            <button class="px-4 py-2 border-2 border-gray-300 hover:bg-gray-50 rounded-lg transition">
                                ❤️
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sample Post Card 6 - Elderly Care -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center">
                        <span class="text-6xl">👴</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                GC
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Golden Care</h3>
                                <p class="text-xs text-gray-500">4 days ago</p>
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Mobility Aids Request</h4>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            Looking for wheelchairs, walkers, and comfort items to support our senior residents.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-purple-50 text-purple-700 text-xs font-semibold rounded-full">Elderly Care</span>
                        </div>
                        <div class="flex gap-2">
                            <button class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold transition text-sm">
                                View Details
                            </button>
                            <button class="px-4 py-2 border-2 border-gray-300 hover:bg-gray-50 rounded-lg transition">
                                ❤️
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Pagination/Load More -->
            <div class="text-center mt-12">
                <button class="bg-white hover:bg-gray-50 text-gray-900 border-2 border-gray-300 px-8 py-3 rounded-full font-semibold transition shadow-lg hover:shadow-xl">
                    Load More Posts
                </button>
            </div>

            <!-- Empty State (Show when no posts) -->
            <!-- <div class="text-center py-20">
                <div class="text-6xl mb-4">📭</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Posts Found</h3>
                <p class="text-gray-600 mb-6">There are no posts matching your criteria.</p>
                <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                    Clear Filters
                </button>
            </div> -->

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
