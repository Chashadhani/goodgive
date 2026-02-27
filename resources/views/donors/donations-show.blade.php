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
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Payment Method</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">
                                    @if($donation->payment_method === 'pickup')
                                        🚗 Pickup
                                    @elseif($donation->payment_method === 'online')
                                        💳 Online Pay
                                    @else
                                        —
                                    @endif
                                </p>
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

                    <!-- Stock & Allocation Tracking -->
                    @if($donation->status === 'confirmed')
                        <div class="border-t border-gray-100 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">📦 Stock & Allocation Tracking</h3>
                                <a href="{{ route('donor.donations.tracking', $donation) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                    View Full Tracking →
                                </a>
                            </div>

                            @if($donation->isMoney())
                                <!-- Money remaining stock -->
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5 mb-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs text-green-600 uppercase tracking-wider font-semibold">Remaining in Stock</p>
                                            <p class="text-2xl font-bold text-green-700 mt-1">Rs. {{ number_format($donation->remaining_amount) }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-gray-500">Original: Rs. {{ number_format($donation->amount) }}</p>
                                            <p class="text-xs text-gray-500">Allocated: Rs. {{ number_format($donation->amount - $donation->remaining_amount) }}</p>
                                        </div>
                                    </div>
                                    @if($donation->amount > 0)
                                        <div class="mt-3 bg-green-200 rounded-full h-2 overflow-hidden">
                                            <div class="bg-green-600 h-full rounded-full" style="width: {{ min(100, (($donation->amount - $donation->remaining_amount) / $donation->amount) * 100) }}%"></div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Money allocation details (same as goods) --}}
                                @if($donation->allocations->where('type', 'money')->count() > 0)
                                    <div class="space-y-3 mb-4">
                                        <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Allocation Details</p>
                                        @foreach($donation->allocations->where('type', 'money') as $alloc)
                                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div>
                                                        <span class="font-semibold text-gray-900">💰 Rs. {{ number_format($alloc->amount) }}</span>
                                                        <span class="text-xs text-gray-500 ml-2">→ {{ Str::limit($alloc->allocatable?->title ?? 'N/A', 30) }}</span>
                                                    </div>
                                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $alloc->status_color }}">{{ $alloc->status_label }}</span>
                                                </div>
                                                @php
                                                    $mStages = ['processing', 'delivery', 'distributed'];
                                                    $mIdx = array_search($alloc->status, $mStages);
                                                    if ($mIdx === false) $mIdx = -1;
                                                @endphp
                                                <div class="flex items-center mt-2">
                                                    @foreach($mStages as $idx => $stage)
                                                        <div class="flex-1 flex flex-col items-center">
                                                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold border
                                                                {{ $idx <= $mIdx ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                                                @if($idx < $mIdx) ✓ @elseif($idx === 0) ⏳ @elseif($idx === 1) 🚚 @else ✅ @endif
                                                            </div>
                                                            <p class="text-[10px] mt-0.5 font-medium {{ $idx <= $mIdx ? 'text-indigo-600' : 'text-gray-400' }}">
                                                                {{ $idx === 0 ? 'Processing' : ($idx === 1 ? 'Delivery' : 'Distributed') }}
                                                            </p>
                                                        </div>
                                                        @if($idx < 2)
                                                            <div class="flex-shrink-0 w-8 h-0.5 {{ $idx < $mIdx ? 'bg-indigo-600' : 'bg-gray-200' }} mt-[-12px]"></div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @if($alloc->isDistributed() && $alloc->proof_photo)
                                                    <div class="mt-2 flex items-center text-xs text-green-600">
                                                        <span>📸 Proof available</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif

                            @if($donation->isGoods() && $donation->items->count())
                                <!-- Goods remaining per item -->
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-4">
                                    <p class="text-xs text-blue-600 uppercase tracking-wider font-semibold mb-3">Items Remaining in Stock</p>
                                    <div class="space-y-3">
                                        @foreach($donation->items as $item)
                                            <div class="bg-white rounded-lg p-3 border border-blue-100">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="font-medium text-gray-900">{{ $item->item_name }}</span>
                                                    <span class="text-sm">
                                                        <span class="font-bold text-blue-700">{{ $item->remaining_quantity }}</span>
                                                        <span class="text-gray-500">/ {{ $item->quantity }} remaining</span>
                                                    </span>
                                                </div>
                                                @if($item->quantity > 0)
                                                    <div class="bg-blue-100 rounded-full h-1.5 overflow-hidden">
                                                        <div class="bg-blue-600 h-full rounded-full" style="width: {{ min(100, (($item->quantity - $item->remaining_quantity) / $item->quantity) * 100) }}%"></div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Allocation list -->
                            @if($donation->allocations->count() > 0)
                                <div class="space-y-3">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Where Your Donation Went</p>
                                    @foreach($donation->allocations as $allocation)
                                        <div class="border rounded-xl p-4 {{ $allocation->isDistributed() ? 'border-green-200 bg-green-50' : ($allocation->isDelivery() ? 'border-blue-200 bg-blue-50' : 'border-yellow-200 bg-yellow-50') }}">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    @if($allocation->isMoney())
                                                        <p class="font-semibold text-gray-900">💰 Rs. {{ number_format($allocation->amount) }}</p>
                                                    @else
                                                        <p class="font-semibold text-gray-900">📦 {{ $allocation->item_name }} × {{ $allocation->quantity }}</p>
                                                    @endif
                                                    <p class="text-sm text-gray-600 mt-1">→ {{ Str::limit($allocation->allocatable?->title ?? 'N/A', 40) }}</p>
                                                </div>
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $allocation->status_color }}">
                                                    {{ $allocation->status_label }}
                                                </span>
                                            </div>
                                            @if($allocation->isDistributed() && $allocation->proof_photo)
                                                <div class="mt-3 pt-3 border-t border-green-200">
                                                    <p class="text-xs text-green-600 font-semibold mb-2">📸 Distribution Proof</p>
                                                    <img src="{{ Storage::url($allocation->proof_photo) }}" alt="Proof" class="w-full max-h-40 object-cover rounded-lg">
                                                    @if($allocation->proof_notes)
                                                        <p class="text-xs text-gray-600 mt-1">{{ $allocation->proof_notes }}</p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4 text-gray-400">
                                    <p class="text-sm">Your donation is in stock and hasn't been allocated yet.</p>
                                </div>
                            @endif
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
