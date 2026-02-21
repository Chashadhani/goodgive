<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $ngoPost->title }} - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Link -->
            <a href="{{ route('ngos-posts') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to All Posts
            </a>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <!-- Post Image -->
                @php
                    $categoryColors = [
                        'Education' => 'from-indigo-400 to-purple-500',
                        'Healthcare' => 'from-red-400 to-pink-500',
                        'Shelter' => 'from-blue-400 to-cyan-500',
                        'Food Security' => 'from-green-400 to-emerald-500',
                        'Child Welfare' => 'from-pink-400 to-rose-500',
                        'Elderly Care' => 'from-purple-400 to-indigo-500',
                        'Disaster Relief' => 'from-orange-400 to-red-500',
                        'Environment' => 'from-teal-400 to-green-500',
                    ];
                    $gradient = $categoryColors[$ngoPost->category] ?? 'from-gray-400 to-gray-500';
                    
                    $categoryEmojis = [
                        'Education' => '📚', 'Healthcare' => '🏥', 'Shelter' => '🏠',
                        'Food Security' => '🍽️', 'Child Welfare' => '👶', 'Elderly Care' => '👴',
                        'Disaster Relief' => '🚨', 'Environment' => '🌿', 'Other' => '📋',
                    ];
                    $emoji = $categoryEmojis[$ngoPost->category] ?? '📋';
                    $ngoName = $ngoPost->user->ngoProfile->organization_name ?? $ngoPost->user->name;
                    $initials = strtoupper(substr($ngoName, 0, 2));
                @endphp

                @if($ngoPost->image)
                    <img src="{{ Storage::url($ngoPost->image) }}" alt="{{ $ngoPost->title }}" class="w-full h-80 object-cover">
                @else
                    <div class="h-64 bg-gradient-to-br {{ $gradient }} flex items-center justify-center">
                        <span class="text-8xl">{{ $emoji }}</span>
                    </div>
                @endif

                <div class="p-8 lg:p-12">
                    <!-- NGO Info -->
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-14 h-14 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ $initials }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $ngoName }}</h3>
                            <p class="text-sm text-gray-500">Posted {{ $ngoPost->created_at->diffForHumans() }} &middot; {{ $ngoPost->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-4 py-1 bg-blue-50 text-blue-700 text-sm font-semibold rounded-full">{{ $ngoPost->category }}</span>
                        @if($ngoPost->urgency === 'urgent')
                            <span class="px-4 py-1 bg-orange-50 text-orange-700 text-sm font-semibold rounded-full">🔥 Urgent</span>
                        @elseif($ngoPost->urgency === 'critical')
                            <span class="px-4 py-1 bg-red-50 text-red-700 text-sm font-semibold rounded-full">🚨 Critical</span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">{{ $ngoPost->title }}</h1>

                    <!-- Goal Amount -->
                    @if($ngoPost->isMoney() && $ngoPost->goal_amount)
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 mb-8">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-green-600 font-medium uppercase tracking-wide">Donation Goal</p>
                                    <p class="text-3xl font-bold text-green-700 mt-1">Rs. {{ number_format($ngoPost->goal_amount) }}</p>
                                </div>
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-3xl">🎯</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Items Needed (goods) -->
                    @if($ngoPost->isGoods() && $ngoPost->items->count())
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm text-blue-600 font-medium uppercase tracking-wide">Items Needed</p>
                                    <p class="text-lg font-bold text-blue-700 mt-1">{{ $ngoPost->total_items_count }} total items</p>
                                </div>
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-3xl">📦</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                @foreach($ngoPost->items as $item)
                                    <div class="flex items-center justify-between bg-white rounded-lg px-4 py-3 border border-blue-100">
                                        <div>
                                            <span class="font-medium text-gray-900">{{ $item->item_name }}</span>
                                            @if($item->notes)
                                                <span class="text-xs text-gray-500 ml-2">({{ $item->notes }})</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-bold text-blue-700 bg-blue-100 px-3 py-1 rounded-full">× {{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Description -->
                    <div class="prose prose-lg max-w-none text-gray-700 mb-8 leading-relaxed">
                        {!! nl2br(e($ngoPost->description)) !!}
                    </div>

                    <!-- Action Buttons -->
                    <div class="border-t border-gray-200 pt-8 mt-8">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- Donate Button -->
                            @auth
                                @if(auth()->user()->isDonor())
                                    <a href="{{ route('donor.donations.create', ['ngo_post_id' => $ngoPost->id]) }}" class="flex-1 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                        <span class="text-2xl">💝</span>
                                        <span>Donate Now</span>
                                    </a>
                                @else
                                    <button class="flex-1 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 opacity-75 cursor-not-allowed" title="Only donors can make donations">
                                        <span class="text-2xl">💝</span>
                                        <span>Donate Now</span>
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="flex-1 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                    <span class="text-2xl">💝</span>
                                    <span>Login to Donate</span>
                                </a>
                            @endauth
                            
                            <!-- Share Button -->
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!')" class="px-6 py-4 border-2 border-gray-300 hover:bg-gray-50 rounded-xl font-semibold transition flex items-center justify-center space-x-2">
                                <span>📤</span>
                                <span>Share</span>
                            </button>

                            <!-- Heart/Save Button -->
                            <button class="px-6 py-4 border-2 border-gray-300 hover:bg-red-50 hover:border-red-300 rounded-xl font-semibold transition flex items-center justify-center space-x-2">
                                <span>❤️</span>
                                <span>Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NGO Information Card -->
            <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">About {{ $ngoName }}</h3>
                <div class="flex items-start space-x-4">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-xl flex-shrink-0">
                        {{ $initials }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-lg">{{ $ngoName }}</p>
                        @if($ngoPost->user->ngoProfile)
                            @if($ngoPost->user->ngoProfile->address)
                                <p class="text-gray-600 mt-1">📍 {{ $ngoPost->user->ngoProfile->address }}</p>
                            @endif
                            @if($ngoPost->user->ngoProfile->phone)
                                <p class="text-gray-600 mt-1">📞 {{ $ngoPost->user->ngoProfile->phone }}</p>
                            @endif
                            @if($ngoPost->user->ngoProfile->isVerified())
                                <span class="inline-flex items-center mt-2 px-3 py-1 bg-green-50 text-green-700 text-sm font-semibold rounded-full">
                                    ✅ Verified Organization
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8 mt-12">
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
