<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donation Tracking - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Link -->
            <div class="mb-6">
                <a href="{{ route('donor.donations.show', $donation) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    ← Back to Donation Details
                </a>
            </div>

            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                    <h1 class="text-2xl font-bold text-white">📍 Donation Tracking</h1>
                    <p class="text-white/80 text-sm mt-1">See exactly where your donation is going and its distribution status.</p>
                </div>
                <div class="px-8 py-5 flex items-center justify-between border-b border-gray-100">
                    <div>
                        <p class="text-sm text-gray-500">Donation #{{ $donation->id }}</p>
                        <p class="font-bold text-gray-900 text-lg">
                            @if($donation->isMoney())
                                💰 Rs. {{ number_format($donation->amount, 2) }} (Money)
                            @else
                                📦 {{ $donation->total_items_count }} Items (Goods)
                            @endif
                        </p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-700">{{ ucfirst($donation->status) }}</span>
                </div>
            </div>

            <!-- Stock Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6">📊 Stock Overview</h2>

                @if($donation->isMoney())
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Original</p>
                            <p class="text-xl font-bold text-gray-900 mt-1">Rs. {{ number_format($donation->amount) }}</p>
                        </div>
                        <div class="bg-indigo-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-indigo-500 uppercase tracking-wider">Allocated</p>
                            <p class="text-xl font-bold text-indigo-700 mt-1">Rs. {{ number_format($donation->amount - $donation->remaining_amount) }}</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-green-500 uppercase tracking-wider">Remaining</p>
                            <p class="text-xl font-bold text-green-700 mt-1">Rs. {{ number_format($donation->remaining_amount) }}</p>
                        </div>
                    </div>
                    @if($donation->amount > 0)
                        <div class="bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-indigo-600 h-full rounded-full transition-all" style="width: {{ min(100, (($donation->amount - $donation->remaining_amount) / $donation->amount) * 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 text-right">{{ round((($donation->amount - $donation->remaining_amount) / $donation->amount) * 100) }}% allocated</p>
                    @endif

                    {{-- Per-allocation breakdown for money --}}
                    @if($donation->allocations->where('type', 'money')->count() > 0)
                        <div class="mt-6 space-y-4">
                            <p class="text-sm font-bold text-gray-700 uppercase tracking-wider">Allocation Breakdown</p>
                            @foreach($donation->allocations->where('type', 'money') as $alloc)
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <p class="font-semibold text-gray-900 text-lg">💰 Rs. {{ number_format($alloc->amount) }}</p>
                                            <p class="text-xs text-gray-500">→ {{ Str::limit($alloc->allocatable?->title ?? 'N/A', 40) }}</p>
                                            <p class="text-xs text-gray-400">{{ $alloc->allocatable_type === 'App\\Models\\NgoPost' ? 'NGO Post' : 'Help Request' }}</p>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $alloc->status_color }}">{{ $alloc->status_label }}</span>
                                    </div>
                                    {{-- Progress stages --}}
                                    @php
                                        $mStages = ['processing', 'delivery', 'distributed'];
                                        $mIdx = array_search($alloc->status, $mStages);
                                        if ($mIdx === false) $mIdx = -1;
                                    @endphp
                                    <div class="flex items-center">
                                        @foreach($mStages as $idx => $stage)
                                            <div class="flex-1 flex flex-col items-center">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-2
                                                    {{ $idx <= $mIdx ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                                    @if($idx < $mIdx) ✓ @elseif($idx === 0) ⏳ @elseif($idx === 1) 🚚 @else ✅ @endif
                                                </div>
                                                <p class="text-xs mt-1 font-medium {{ $idx <= $mIdx ? 'text-indigo-600' : 'text-gray-400' }}">
                                                    {{ $idx === 0 ? 'Processing' : ($idx === 1 ? 'Delivery' : 'Distributed') }}
                                                </p>
                                            </div>
                                            @if($idx < 2)
                                                <div class="flex-shrink-0 w-10 h-0.5 {{ $idx < $mIdx ? 'bg-indigo-600' : 'bg-gray-200' }} mt-[-14px]"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                    {{-- Proof photo --}}
                                    @if($alloc->isDistributed() && $alloc->proof_photo)
                                        <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-3">
                                            <p class="text-xs font-bold text-green-800 mb-2">📸 Distribution Proof</p>
                                            <img src="{{ Storage::url($alloc->proof_photo) }}" alt="Proof" class="w-full rounded-lg max-h-48 object-cover">
                                            @if($alloc->proof_notes)
                                                <p class="text-xs text-green-700 mt-2">{{ $alloc->proof_notes }}</p>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="mt-3 flex items-center justify-between text-xs text-gray-400">
                                        <span>Allocated {{ $alloc->created_at->format('M d, Y') }}</span>
                                        <span>Updated {{ $alloc->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

                @if($donation->isGoods() && $donation->items->count())
                    <div class="space-y-4">
                        @foreach($donation->items as $item)
                            @php
                                $allocated = $item->quantity - $item->remaining_quantity;
                                $pct = $item->quantity > 0 ? round(($allocated / $item->quantity) * 100) : 0;
                            @endphp
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-900 text-lg">{{ $item->item_name }}</p>
                                        @if($item->notes)
                                            <p class="text-xs text-gray-500">{{ $item->notes }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-indigo-700">{{ $allocated }} allocated</span>
                                        <span class="text-sm text-gray-400">/</span>
                                        <span class="text-sm text-gray-600">{{ $item->quantity }} total</span>
                                    </div>
                                </div>
                                <div class="bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-indigo-600 h-full rounded-full transition-all" style="width: {{ $pct }}%"></div>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-xs text-gray-500">{{ $pct }}% allocated</p>
                                    <p class="text-xs font-semibold text-green-600">{{ $item->remaining_quantity }} remaining in stock</p>
                                </div>

                                <!-- Show where each item went -->
                                @if($item->allocations->count() > 0)
                                    <div class="mt-3 pt-3 border-t border-gray-200 space-y-2">
                                        @foreach($item->allocations as $alloc)
                                            <div class="flex items-center justify-between text-sm">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-gray-400">→</span>
                                                    <span class="text-gray-700">{{ $alloc->quantity }}× to <strong>{{ Str::limit($alloc->allocatable?->title ?? 'N/A', 30) }}</strong></span>
                                                </div>
                                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $alloc->status_color }}">{{ $alloc->status_label }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Allocation Cards -->
            @if($donation->allocations->count() > 0)
                <h2 class="text-lg font-bold text-gray-900 mb-4">📋 Allocation Details</h2>
                <div class="space-y-6">
                    @foreach($donation->allocations as $allocation)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <!-- Allocation Header -->
                            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                                <div>
                                    @if($allocation->isMoney())
                                        <p class="font-bold text-gray-900">💰 Rs. {{ number_format($allocation->amount) }}</p>
                                    @else
                                        <p class="font-bold text-gray-900">📦 {{ $allocation->item_name }} × {{ $allocation->quantity }}</p>
                                    @endif
                                    <p class="text-sm text-gray-500">→ {{ $allocation->allocatable?->title ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-400">{{ $allocation->allocatable_type === 'App\\Models\\NgoPost' ? 'NGO Post' : 'Help Request' }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $allocation->status_color }}">
                                    {{ $allocation->status_label }}
                                </span>
                            </div>

                            <!-- 3-Stage Progress -->
                            <div class="px-6 py-5">
                                @php
                                    $stages = ['processing', 'delivery', 'distributed'];
                                    $currentIdx = array_search($allocation->status, $stages);
                                @endphp
                                <div class="flex items-center">
                                    @foreach($stages as $idx => $stage)
                                        <div class="flex-1 flex flex-col items-center">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2
                                                {{ $idx <= $currentIdx ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                                @if($idx < $currentIdx)
                                                    ✓
                                                @elseif($idx === 0)
                                                    ⏳
                                                @elseif($idx === 1)
                                                    🚚
                                                @else
                                                    ✅
                                                @endif
                                            </div>
                                            <p class="text-xs mt-1 font-medium {{ $idx <= $currentIdx ? 'text-indigo-600' : 'text-gray-400' }}">
                                                {{ $idx === 0 ? 'Processing' : ($idx === 1 ? 'Delivery' : 'Distributed') }}
                                            </p>
                                        </div>
                                        @if($idx < 2)
                                            <div class="flex-shrink-0 w-12 h-0.5 {{ $idx < $currentIdx ? 'bg-indigo-600' : 'bg-gray-200' }} mt-[-16px]"></div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Proof Photo (if distributed) -->
                            @if($allocation->isDistributed() && $allocation->proof_photo)
                                <div class="px-6 pb-6">
                                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                        <p class="text-sm font-bold text-green-800 mb-3">📸 Distribution Proof</p>
                                        <img src="{{ Storage::url($allocation->proof_photo) }}" alt="Distribution proof" class="w-full rounded-lg shadow-sm max-h-64 object-cover">
                                        @if($allocation->proof_notes)
                                            <p class="text-sm text-green-700 mt-3 bg-green-100 rounded-lg p-3">{{ $allocation->proof_notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Footer -->
                            <div class="px-6 py-3 bg-gray-50 text-xs text-gray-500 flex items-center justify-between">
                                <span>Allocated on {{ $allocation->created_at->format('M d, Y') }}</span>
                                <span>Last updated {{ $allocation->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                    <span class="text-5xl block mb-4">📦</span>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Your donation is in stock</h3>
                    <p class="text-gray-500">Your donation has been confirmed and is waiting to be allocated to someone in need. We'll notify you once it's assigned.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
