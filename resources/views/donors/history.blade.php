<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donation History - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    @php
        $donations = \App\Models\Donation::where('user_id', Auth::id())
            ->with(['ngoPost', 'items'])
            ->latest()
            ->paginate(15);
    @endphp

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('donor.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    ← Back to Dashboard
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-4">Donation History</h1>
                <p class="text-gray-600 mt-1">View all your past donations</p>
            </div>

            @if($donations->count() > 0)
                <div class="space-y-4">
                    @foreach($donations as $donation)
                        <a href="{{ route('donor.donations.show', $donation) }}" class="block bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $donation->donation_type === 'money' ? 'bg-green-100' : 'bg-blue-100' }}">
                                        <span class="text-xl">{{ $donation->donation_type === 'money' ? '💰' : '📦' }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            @if($donation->isMoney())
                                                Rs. {{ number_format($donation->amount, 2) }}
                                            @else
                                                {{ $donation->goods_summary }}
                                            @endif
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $donation->created_at->format('M d, Y') }}
                                            @if($donation->ngoPost) • {{ Str::limit($donation->ngoPost->title, 30) }} @endif
                                        </p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($donation->status === 'pending') bg-orange-100 text-orange-800
                                    @elseif($donation->status === 'confirmed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6">{{ $donations->links() }}</div>
            @else
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <div class="text-center py-12">
                        <span class="text-6xl mb-4 block">📋</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Donation History</h3>
                        <p class="text-gray-500">Your donation history will appear here once you make donations.</p>
                        <a href="{{ route('donor.donations.create') }}" class="inline-block mt-4 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full font-semibold transition">
                            Make a Donation
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
