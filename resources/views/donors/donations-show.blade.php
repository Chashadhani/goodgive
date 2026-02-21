<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donation Details - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Link -->
            <div class="mb-6">
                <a href="{{ route('donor.donations.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    ← Back to My Donations
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header with status -->
                <div class="px-8 py-6 
                    @if($donation->status === 'confirmed') bg-gradient-to-r from-green-500 to-emerald-500
                    @elseif($donation->status === 'rejected') bg-gradient-to-r from-red-500 to-pink-500
                    @else bg-gradient-to-r from-orange-500 to-yellow-500
                    @endif">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center space-x-3">
                                <span class="text-3xl">{{ $donation->isMoney() ? '💰' : '📦' }}</span>
                                <div>
                                    <h1 class="text-2xl font-bold text-white">
                                        @if($donation->isMoney())
                                            Rs. {{ number_format($donation->amount, 2) }}
                                        @else
                                            Goods Donation ({{ $donation->total_items_count }} items)
                                        @endif
                                    </h1>
                                    <p class="text-white/80 text-sm">{{ ucfirst($donation->donation_type) }} Donation</p>
                                </div>
                            </div>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-bold
                            @if($donation->status === 'confirmed') bg-white text-green-700
                            @elseif($donation->status === 'rejected') bg-white text-red-700
                            @else bg-white text-orange-700
                            @endif">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </div>
                </div>

                <!-- Details -->
                <div class="p-8 space-y-6">
                    <!-- Donation Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Donation Type</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">
                                {{ $donation->isMoney() ? '💰 Money' : '📦 Goods' }}
                            </p>
                        </div>

                        @if($donation->isMoney())
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Amount</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">Rs. {{ number_format($donation->amount, 2) }}</p>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Total Items</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $donation->total_items_count }} items</p>
                            </div>
                        @endif

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Date Submitted</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $donation->created_at->format('M d, Y h:i A') }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Status</p>
                            <p class="text-lg font-semibold mt-1
                                @if($donation->status === 'confirmed') text-green-600
                                @elseif($donation->status === 'rejected') text-red-600
                                @else text-orange-600
                                @endif">
                                {{ ucfirst($donation->status) }}
                            </p>
                        </div>
                    </div>

                    @if($donation->isGoods() && $donation->items->count())
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-3">Goods Items</p>
                            <div class="space-y-2">
                                @foreach($donation->items as $item)
                                    <div class="flex items-center justify-between bg-white rounded-lg px-4 py-2 border border-gray-200">
                                        <div>
                                            <span class="font-medium text-gray-900">{{ $item->item_name }}</span>
                                            @if($item->notes)
                                                <span class="text-xs text-gray-500 ml-2">({{ $item->notes }})</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 bg-gray-100 px-3 py-1 rounded-full">× {{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Linked NGO Post -->
                    @if($donation->ngoPost)
                        <div class="border border-blue-200 bg-blue-50 rounded-xl p-4">
                            <p class="text-xs text-blue-500 uppercase tracking-wide mb-2">Linked to NGO Post</p>
                            <h3 class="font-semibold text-blue-900">{{ $donation->ngoPost->title }}</h3>
                            <p class="text-sm text-blue-700 mt-1">{{ Str::limit($donation->ngoPost->description, 150) }}</p>
                        </div>
                    @else
                        <div class="border border-gray-200 bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Donation Type</p>
                            <p class="text-gray-900 mt-1 font-medium">Direct Donation (not linked to a specific post)</p>
                        </div>
                    @endif

                    <!-- Donor Notes -->
                    @if($donation->donor_notes)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Your Notes</p>
                            <p class="text-gray-900 mt-1">{{ $donation->donor_notes }}</p>
                        </div>
                    @endif

                    <!-- Review Info -->
                    @if($donation->reviewed_at)
                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Review Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Reviewed By</p>
                                    <p class="text-gray-900 mt-1">{{ $donation->reviewer?->name ?? 'Admin' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Reviewed At</p>
                                    <p class="text-gray-900 mt-1">{{ $donation->reviewed_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            @if($donation->admin_notes)
                                <div class="bg-gray-50 rounded-xl p-4 mt-4">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Admin Notes</p>
                                    <p class="text-gray-900 mt-1">{{ $donation->admin_notes }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
