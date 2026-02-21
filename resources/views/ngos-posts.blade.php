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
                    <form action="{{ route('ngos-posts') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <input 
                                type="text" 
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search NGO posts..." 
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            >
                        </div>
                        <!-- Category Filter -->
                        <div>
                            <select name="category" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="all">All Categories</option>
                                @foreach(['Education', 'Healthcare', 'Shelter', 'Food Security', 'Child Welfare', 'Elderly Care', 'Disaster Relief', 'Environment', 'Other'] as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Search Button -->
                        <div>
                            <button type="submit" class="w-full px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold transition">
                                Search
                            </button>
                        </div>
                    </form>
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
                    <form action="{{ route('ngos-posts') }}" method="GET">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Most Recent</option>
                            <option value="urgent" {{ request('sort') == 'urgent' ? 'selected' : '' }}>Most Urgent</option>
                        </select>
                    </form>
                </div>
            </div>

            @if($posts->count() > 0)
                <!-- Posts Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                        @php
                            $ngoName = $post->user->ngoProfile->organization_name ?? $post->user->name;
                            $initials = strtoupper(substr($ngoName, 0, 2));
                            
                            $categoryColors = [
                                'Education' => ['from-indigo-400 to-purple-500', 'bg-indigo-600', 'bg-indigo-50 text-indigo-700'],
                                'Healthcare' => ['from-red-400 to-pink-500', 'bg-red-600', 'bg-red-50 text-red-700'],
                                'Shelter' => ['from-blue-400 to-cyan-500', 'bg-blue-600', 'bg-blue-50 text-blue-700'],
                                'Food Security' => ['from-green-400 to-emerald-500', 'bg-green-600', 'bg-green-50 text-green-700'],
                                'Child Welfare' => ['from-pink-400 to-rose-500', 'bg-pink-600', 'bg-pink-50 text-pink-700'],
                                'Elderly Care' => ['from-purple-400 to-indigo-500', 'bg-purple-600', 'bg-purple-50 text-purple-700'],
                                'Disaster Relief' => ['from-orange-400 to-red-500', 'bg-orange-600', 'bg-orange-50 text-orange-700'],
                                'Environment' => ['from-teal-400 to-green-500', 'bg-teal-600', 'bg-teal-50 text-teal-700'],
                            ];
                            $colors = $categoryColors[$post->category] ?? ['from-gray-400 to-gray-500', 'bg-gray-600', 'bg-gray-50 text-gray-700'];
                            
                            $categoryEmojis = [
                                'Education' => '📚', 'Healthcare' => '🏥', 'Shelter' => '🏠',
                                'Food Security' => '🍽️', 'Child Welfare' => '👶', 'Elderly Care' => '👴',
                                'Disaster Relief' => '🚨', 'Environment' => '🌿', 'Other' => '📋',
                            ];
                            $emoji = $categoryEmojis[$post->category] ?? '📋';
                        @endphp

                        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                            <!-- Post Image/Header -->
                            @if($post->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br {{ $colors[0] }} flex items-center justify-center">
                                    <span class="text-6xl">{{ $emoji }}</span>
                                </div>
                            @endif
                            
                            <!-- Post Content -->
                            <div class="p-6">
                                <!-- NGO Info -->
                                <div class="flex items-center space-x-2 mb-4">
                                    <div class="w-10 h-10 {{ $colors[1] }} rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-sm">{{ $ngoName }}</h3>
                                        <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                <!-- Post Title -->
                                <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $post->title }}</h4>
                                
                                <!-- Post Description -->
                                <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                    {{ Str::limit($post->description, 120) }}
                                </p>
                                
                                <!-- Tags/Category -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-3 py-1 {{ $colors[2] }} text-xs font-semibold rounded-full">{{ $post->category }}</span>
                                    @if($post->urgency === 'urgent')
                                        <span class="px-3 py-1 bg-orange-50 text-orange-700 text-xs font-semibold rounded-full">Urgent</span>
                                    @elseif($post->urgency === 'critical')
                                        <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-full">Critical</span>
                                    @endif
                                    @if($post->isMoney() && $post->goal_amount)
                                        <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full">Rs. {{ number_format($post->goal_amount) }}</span>
                                    @elseif($post->isGoods())
                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full">📦 {{ $post->total_items_count }} items needed</span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('ngo-post.show', $post) }}" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold transition text-sm text-center">
                                        View Details
                                    </a>
                                    <button class="px-4 py-2 border-2 border-gray-300 hover:bg-gray-50 rounded-lg transition">
                                        ❤️
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $posts->withQueryString()->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="text-6xl mb-4">📭</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Posts Found</h3>
                    <p class="text-gray-600 mb-6">There are no posts matching your criteria.</p>
                    <a href="{{ route('ngos-posts') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-between items-center">
                <div class="text-sm">&copy; 2025 GoodGive. All rights reserved.</div>
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
