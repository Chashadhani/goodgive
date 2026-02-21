<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donor Dashboard - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    @php
        $recentDonations = \App\Models\Donation::where('user_id', Auth::id())
            ->with('ngoPost')
            ->latest()
            ->take(5)
            ->get();
        $donorDonationCount = \App\Models\Donation::where('user_id', Auth::id())->count();
        $confirmedCount = \App\Models\Donation::where('user_id', Auth::id())->where('status', 'confirmed')->count();
    @endphp

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 mt-1">Your donor dashboard - track your impact and donations</p>
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

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Total Donated</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                Rs. {{ number_format(Auth::user()->donorProfile?->total_donated ?? 0, 2) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">💰</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Donations Made</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                {{ Auth::user()->donorProfile?->donation_count ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">🎁</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">Lives Impacted</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">❤️</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">Direct Donation</h3>
                    <p class="opacity-90 mb-4">Make a direct money or goods donation</p>
                    <a href="{{ route('donor.donations.create') }}" class="inline-block bg-white text-green-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                        Donate Now
                    </a>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">Browse NGO Posts</h3>
                    <p class="opacity-90 mb-4">Support verified NGOs and help those in need</p>
                    <a href="{{ route('ngos-posts') }}" class="inline-block bg-white text-orange-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                        Browse Posts
                    </a>
                </div>

                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">My Donations</h3>
                    <p class="opacity-90 mb-4">Track all your donations and their status</p>
                    <a href="{{ route('donor.donations.index') }}" class="inline-block bg-white text-indigo-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                        View All
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Recent Donations</h3>
                    @if($recentDonations->count() > 0)
                        <a href="{{ route('donor.donations.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">View all →</a>
                    @endif
                </div>
                @if($recentDonations->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentDonations as $donation)
                            <a href="{{ route('donor.donations.show', $donation) }}" class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0 hover:bg-gray-50 rounded-lg px-2 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $donation->donation_type === 'money' ? 'bg-green-100' : 'bg-blue-100' }}">
                                        <span class="text-lg">{{ $donation->donation_type === 'money' ? '💰' : '📦' }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">
                                            @if($donation->isMoney())
                                                Rs. {{ number_format($donation->amount, 2) }}
                                            @else
                                                {{ Str::limit($donation->goods_description, 30) }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $donation->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($donation->status === 'pending') bg-orange-100 text-orange-800
                                    @elseif($donation->status === 'confirmed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <span class="text-4xl mb-3 block">📋</span>
                        <p>No recent donations yet</p>
                        <p class="text-sm mt-1">Your donation history will appear here</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
