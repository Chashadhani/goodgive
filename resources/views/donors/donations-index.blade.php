<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Donations - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Link & Header -->
            <div class="mb-6">
                <a href="{{ route('donor.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    ← Back to Dashboard
                </a>
                <div class="flex items-center justify-between mt-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">My Donations</h1>
                        <p class="text-gray-600 mt-1">Track all your donations and their status</p>
                    </div>
                    <a href="{{ route('donor.donations.create') }}" class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-6 py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-yellow-600 transition shadow-lg">
                        + New Donation
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Donations</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalDonations }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Confirmed</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $confirmedDonations }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Pending</p>
                    <p class="text-2xl font-bold text-orange-600 mt-1">{{ $pendingDonations }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Money Donated</p>
                    <p class="text-2xl font-bold text-indigo-600 mt-1">Rs. {{ number_format($totalMoneyDonated, 2) }}</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 mb-6">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-sm font-medium text-gray-600">Filter:</span>
                    <a href="{{ route('donor.donations.index') }}" 
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ !request('status') && !request('type') ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        All
                    </a>
                    <a href="{{ route('donor.donations.index', ['status' => 'pending']) }}"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('status') === 'pending' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Pending
                    </a>
                    <a href="{{ route('donor.donations.index', ['status' => 'confirmed']) }}"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('status') === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Confirmed
                    </a>
                    <a href="{{ route('donor.donations.index', ['status' => 'rejected']) }}"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('status') === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Rejected
                    </a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('donor.donations.index', ['type' => 'money']) }}"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('type') === 'money' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        💰 Money
                    </a>
                    <a href="{{ route('donor.donations.index', ['type' => 'goods']) }}"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('type') === 'goods' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        📦 Goods
                    </a>
                </div>
            </div>

            <!-- Donations List -->
            @if($donations->count() > 0)
                <div class="space-y-4">
                    @foreach($donations as $donation)
                        <a href="{{ route('donor.donations.show', $donation) }}" class="block bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $donation->donation_type === 'money' ? 'bg-green-100' : 'bg-blue-100' }}">
                                        <span class="text-2xl">{{ $donation->donation_type === 'money' ? '💰' : '📦' }}</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <h3 class="font-semibold text-gray-900">
                                                @if($donation->isMoney())
                                                    Rs. {{ number_format($donation->amount, 2) }}
                                                @else
                                                    {{ $donation->goods_summary }}
                                                @endif
                                            </h3>
                                            <span class="px-2 py-0.5 text-xs rounded-full font-medium
                                                {{ $donation->donation_type === 'money' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ ucfirst($donation->donation_type) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $donation->created_at->format('M d, Y h:i A') }}
                                            @if($donation->ngoPost)
                                                • For: {{ Str::limit($donation->ngoPost->title, 40) }}
                                            @else
                                                • Direct Donation
                                            @endif
                                        </p>
                                        @if($donation->isGoods())
                                            <p class="text-sm text-gray-500">{{ $donation->total_items_count }} items</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                        @if($donation->status === 'pending') bg-orange-100 text-orange-800
                                        @elseif($donation->status === 'confirmed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                    @if($donation->reviewed_at)
                                        <p class="text-xs text-gray-400 mt-1">Reviewed {{ $donation->reviewed_at->diffForHumans() }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $donations->withQueryString()->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm p-12 border border-gray-100 text-center">
                    <span class="text-6xl mb-4 block">📋</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Donations Yet</h3>
                    <p class="text-gray-500 mb-6">You haven't made any donations yet. Start by making your first donation!</p>
                    <a href="{{ route('donor.donations.create') }}" class="inline-block bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-6 py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-yellow-600 transition">
                        Make a Donation
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
