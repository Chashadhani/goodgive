<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Dashboard - {{ config('app.name', 'GoodGive') }}</title>

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
                <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 mt-1">Manage your account and submit help requests</p>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <p class="text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <p class="text-blue-800">{{ session('info') }}</p>
                </div>
            @endif

            <!-- Account Status Banner -->
            @if(Auth::user()->recipientProfile)
                @php $profile = Auth::user()->recipientProfile; @endphp
                
                @if($profile->isPending())
                    <div class="bg-yellow-50 border-2 border-yellow-300 rounded-2xl p-6 mb-8">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-yellow-200 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl">⏳</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-yellow-800">Account Pending Approval</h3>
                                <p class="text-yellow-700 mt-1">Your account is being reviewed by an administrator.</p>
                                <p class="text-sm text-yellow-600 mt-2">Once approved, you will be able to submit help requests.</p>
                            </div>
                        </div>
                    </div>
                @elseif($profile->isApproved())
                    <div class="bg-green-50 border-2 border-green-300 rounded-2xl p-6 mb-8">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-2xl">✅</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-green-800">Account Approved!</h3>
                                    <p class="text-green-700 mt-1">Your account has been verified. You can now submit help requests.</p>
                                </div>
                            </div>
                            <a href="{{ route('recipient.requests.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                New Request
                            </a>
                        </div>
                    </div>
                @elseif($profile->isRejected())
                    <div class="bg-red-50 border-2 border-red-300 rounded-2xl p-6 mb-8">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl">❌</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-red-800">Account Rejected</h3>
                                <p class="text-red-700 mt-1">Unfortunately, your account could not be approved.</p>
                                @if($profile->rejection_reason)
                                    <p class="text-sm text-red-600 mt-2"><strong>Reason:</strong> {{ $profile->rejection_reason }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Account Info Card -->
            @if(Auth::user()->recipientProfile)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Account Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Phone Number</p>
                            <p class="font-semibold text-gray-900">{{ Auth::user()->recipientProfile->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-semibold text-gray-900">{{ Auth::user()->recipientProfile->location ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Account Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if(Auth::user()->recipientProfile->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif(Auth::user()->recipientProfile->status === 'approved') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(Auth::user()->recipientProfile->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">My Help Requests</h3>
                    <p class="opacity-90 mb-4">View and manage your submitted requests</p>
                    <a href="{{ route('recipient.requests.index') }}" class="inline-block bg-white text-indigo-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                        View Requests
                    </a>
                </div>

                @if(Auth::user()->recipientProfile?->isApproved())
                    <div class="bg-gradient-to-br from-green-500 to-teal-500 rounded-2xl p-6 text-white">
                        <h3 class="text-xl font-bold mb-2">Submit New Request</h3>
                        <p class="opacity-90 mb-4">Create a new help request</p>
                        <a href="{{ route('recipient.requests.create') }}" class="inline-block bg-white text-green-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                            New Request
                        </a>
                    </div>
                @else
                    <div class="bg-gray-200 rounded-2xl p-6 text-gray-500">
                        <h3 class="text-xl font-bold mb-2">Submit New Request</h3>
                        <p class="mb-4">Account approval required</p>
                        <span class="inline-block bg-gray-300 text-gray-500 px-6 py-2 rounded-full font-semibold cursor-not-allowed">
                            Locked
                        </span>
                    </div>
                @endif

                <div class="bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">Eligibility Forum</h3>
                    <p class="opacity-90 mb-4">Check eligibility and ask questions</p>
                    <a href="{{ route('recipient.eligibility-forum') }}" class="inline-block bg-white text-orange-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                        Visit Forum
                    </a>
                </div>
            </div>

            <!-- Recent Requests -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Recent Help Requests</h3>
                    <a href="{{ route('recipient.requests.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                        View All →
                    </a>
                </div>
                
                @php
                    $recentRequests = Auth::user()->helpRequests()->latest()->take(5)->get();
                @endphp

                @if($recentRequests->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentRequests as $request)
                            <a href="{{ route('recipient.requests.show', $request) }}" 
                               class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ Str::limit($request->title, 50) }}</p>
                                        <p class="text-sm text-gray-500">{{ $request->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $request->status_color }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <span class="text-4xl mb-3 block">📋</span>
                        <p>No help requests yet</p>
                        @if(Auth::user()->recipientProfile?->isApproved())
                            <a href="{{ route('recipient.requests.create') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium mt-2 inline-block">
                                Submit your first request →
                            </a>
                        @else
                            <p class="text-sm mt-1">Wait for account approval to submit requests</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
