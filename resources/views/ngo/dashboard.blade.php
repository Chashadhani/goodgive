<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NGO Dashboard - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ Auth::user()->ngoProfile?->organization_name ?? Auth::user()->name }}!</h1>
                <p class="text-gray-600 mt-1">NGO Dashboard - Manage your requests and connect with donors</p>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <p class="text-blue-800">{{ session('info') }}</p>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                    <p class="text-yellow-800">{{ session('warning') }}</p>
                </div>
            @endif

            <!-- Verification Status Banner -->
            @if(Auth::user()->ngoProfile)
                @if(Auth::user()->ngoProfile->isPending())
                    <div class="bg-yellow-50 border-2 border-yellow-300 rounded-2xl p-6 mb-8">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-yellow-200 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl">⏳</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-yellow-800">Verification Pending</h3>
                                <p class="text-yellow-700 mt-1">Your NGO registration is under review. This usually takes 1-3 business days.</p>
                                <p class="text-sm text-yellow-600 mt-2">Some features are restricted until verification is complete.</p>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::user()->ngoProfile->isRejected())
                    <div class="bg-red-50 border-2 border-red-300 rounded-2xl p-6 mb-8">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl">❌</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-red-800">Verification Rejected</h3>
                                <p class="text-red-700 mt-1">{{ Auth::user()->ngoProfile->rejection_reason ?? 'Your registration was not approved. Please contact support.' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                        <div class="flex items-center space-x-3">
                            <span class="text-xl">✅</span>
                            <p class="text-green-800 font-medium">Verified Organization</p>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Active Posts</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">📝</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Total Received</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">Rs. 0</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">💰</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">People Helped</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">❤️</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Donors</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                        </div>
                        <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">👥</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">Create New Post</h3>
                    <p class="opacity-90 mb-4">Post a new request to connect with donors</p>
                    @if(Auth::user()->ngoProfile?->isVerified())
                        <a href="{{ route('ngo.post-request') }}" class="inline-block bg-white text-green-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                            Create Post
                        </a>
                    @else
                        <button disabled class="inline-block bg-gray-300 text-gray-500 px-6 py-2 rounded-full font-semibold cursor-not-allowed">
                            Verification Required
                        </button>
                    @endif
                </div>

                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">View Requests</h3>
                    <p class="opacity-90 mb-4">Browse assistance requests from people who need help</p>
                    <a href="{{ route('ngo.requests') }}" class="inline-block bg-white text-indigo-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                        View Requests
                    </a>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Your Recent Posts</h3>
                <div class="text-center py-8 text-gray-500">
                    <span class="text-4xl mb-3 block">📋</span>
                    <p>No posts yet</p>
                    <p class="text-sm mt-1">Create your first post to start receiving donations</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
