@extends('layouts.app')

@section('title', 'Donation Tracking - ' . $helpRequest->title)

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Link -->
        <div class="mb-6">
            <a href="{{ route('recipient.requests.show', $helpRequest) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                ← Back to Request Details
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="px-8 py-6 bg-gradient-to-r from-teal-600 to-emerald-600">
                <h1 class="text-2xl font-bold text-white">📍 Live Donation Tracking</h1>
                <p class="text-white/80 text-sm mt-1">Track donations being processed for your help request in real time.</p>
            </div>
            <div class="px-8 py-5 flex items-center justify-between border-b border-gray-100">
                <div>
                    <p class="text-sm text-gray-500">Help Request #{{ $helpRequest->id }}</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $helpRequest->title }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-bold {{ $helpRequest->status_color }}">
                    {{ ucfirst(str_replace('_', ' ', $helpRequest->status)) }}
                </span>
            </div>
        </div>

        <!-- Fulfillment Summary -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6">📊 Fulfillment Overview</h2>

            @if($helpRequest->isMoney() && $helpRequest->amount_needed)
                @php
                    $totalAllocated = $helpRequest->allocations->where('type', 'money')->sum('amount');
                    $pct = $helpRequest->amount_needed > 0 ? round(($totalAllocated / $helpRequest->amount_needed) * 100) : 0;
                @endphp
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Needed</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">Rs. {{ number_format($helpRequest->amount_needed) }}</p>
                    </div>
                    <div class="bg-teal-50 rounded-xl p-4 text-center">
                        <p class="text-xs text-teal-500 uppercase tracking-wider">Received</p>
                        <p class="text-xl font-bold text-teal-700 mt-1">Rs. {{ number_format($totalAllocated) }}</p>
                    </div>
                    <div class="bg-orange-50 rounded-xl p-4 text-center">
                        <p class="text-xs text-orange-500 uppercase tracking-wider">Remaining</p>
                        <p class="text-xl font-bold text-orange-700 mt-1">Rs. {{ number_format(max(0, $helpRequest->amount_needed - $totalAllocated)) }}</p>
                    </div>
                </div>
                <div class="bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="bg-teal-600 h-full rounded-full transition-all" style="width: {{ min(100, $pct) }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2 text-right">{{ $pct }}% fulfilled</p>

                {{-- Per-allocation breakdown for money (same as goods style) --}}
                @if($helpRequest->allocations->where('type', 'money')->count() > 0)
                    <div class="mt-6 space-y-4">
                        <p class="text-sm font-bold text-gray-700 uppercase tracking-wider">Allocation Breakdown</p>
                        @foreach($helpRequest->allocations->where('type', 'money') as $alloc)
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-900 text-lg">💰 Rs. {{ number_format($alloc->amount) }}</p>
                                        <p class="text-xs text-gray-400">Allocated on {{ $alloc->created_at->format('M d, Y') }}</p>
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
                                                {{ $idx <= $mIdx ? 'bg-teal-600 border-teal-600 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                                @if($idx < $mIdx) ✓ @elseif($idx === 0) ⏳ @elseif($idx === 1) 🚚 @else ✅ @endif
                                            </div>
                                            <p class="text-xs mt-1 font-medium {{ $idx <= $mIdx ? 'text-teal-600' : 'text-gray-400' }}">
                                                {{ $idx === 0 ? 'Processing' : ($idx === 1 ? 'Delivery' : 'Distributed') }}
                                            </p>
                                        </div>
                                        @if($idx < 2)
                                            <div class="flex-shrink-0 w-10 h-0.5 {{ $idx < $mIdx ? 'bg-teal-600' : 'bg-gray-200' }} mt-[-14px]"></div>
                                        @endif
                                    @endforeach
                                </div>
                                {{-- Status message --}}
                                <div class="mt-3 text-center">
                                    @if($alloc->isProcessing())
                                        <p class="text-xs text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg p-2">⏳ This amount is being processed and prepared for transfer.</p>
                                    @elseif($alloc->isDelivery())
                                        <p class="text-xs text-blue-700 bg-blue-50 border border-blue-200 rounded-lg p-2">🚚 This amount has been dispatched and is on its way!</p>
                                    @elseif($alloc->isDistributed())
                                        <p class="text-xs text-green-700 bg-green-50 border border-green-200 rounded-lg p-2">✅ This amount has been successfully distributed.</p>
                                    @endif
                                </div>
                                {{-- Proof photo --}}
                                @if($alloc->isDistributed() && $alloc->proof_photo)
                                    <div class="mt-3 bg-green-50 border border-green-200 rounded-lg p-3">
                                        <p class="text-xs font-bold text-green-800 mb-2">📸 Distribution Proof</p>
                                        <img src="{{ Storage::url($alloc->proof_photo) }}" alt="Proof" class="w-full rounded-lg max-h-48 object-cover">
                                        @if($alloc->proof_notes)
                                            <p class="text-xs text-green-700 mt-2">{{ $alloc->proof_notes }}</p>
                                        @endif
                                    </div>
                                @endif
                                {{-- OTP Section for recipient --}}
                                <div class="mt-3">
                                    @if($alloc->hasOtp() && $alloc->isDelivery() && !$alloc->isOtpVerified())
                                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                            <p class="text-xs font-bold text-orange-800 mb-1">🔐 Your Verification OTP</p>
                                            <p class="text-lg font-mono font-bold text-orange-700 tracking-widest text-center">{{ $alloc->otp_code }}</p>
                                            <p class="text-xs text-orange-500 mt-1 text-center">Use this OTP below to confirm receipt of this donation.</p>
                                        </div>
                                    @elseif($alloc->hasOtp() && $alloc->isProcessing())
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-2">
                                            <p class="text-xs text-blue-700">🔐 OTP has been generated by the donor. Waiting for delivery to start.</p>
                                        </div>
                                    @elseif($alloc->isOtpVerified())
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-2">
                                            <p class="text-xs font-bold text-green-800">✅ OTP Verified & Distributed</p>
                                            <p class="text-xs text-green-600">Verified {{ $alloc->otp_verified_at->diffForHumans() }}</p>
                                        </div>
                                    @endif
                                </div>
                                @if($alloc->notes)
                                    <div class="mt-3 bg-gray-100 rounded-lg p-2">
                                        <p class="text-xs text-gray-600"><span class="font-semibold">Notes:</span> {{ $alloc->notes }}</p>
                                    </div>
                                @endif
                                <div class="mt-2 text-right text-xs text-gray-400">
                                    Updated {{ $alloc->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

            @if($helpRequest->isGoods() && $helpRequest->items->count())
                @php
                    $overallNeeded = 0;
                    $overallAllocated = 0;
                @endphp
                <div class="space-y-4">
                    @foreach($helpRequest->items as $item)
                        @php
                            // Sum allocated quantity for this specific item name
                            $allocated = $helpRequest->allocations
                                ->where('type', 'goods')
                                ->where('item_name', $item->item_name)
                                ->sum('quantity');
                            $pct = $item->quantity > 0 ? round(($allocated / $item->quantity) * 100) : 0;
                            $overallNeeded += $item->quantity;
                            $overallAllocated += min($allocated, $item->quantity);
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
                                    <span class="text-sm font-bold text-teal-700">{{ $allocated }} received</span>
                                    <span class="text-sm text-gray-400">/</span>
                                    <span class="text-sm text-gray-600">{{ $item->quantity }} needed</span>
                                </div>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-teal-600 h-full rounded-full transition-all" style="width: {{ min(100, $pct) }}%"></div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-gray-500">{{ $pct }}% fulfilled</p>
                                <p class="text-xs font-semibold {{ $allocated >= $item->quantity ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $allocated >= $item->quantity ? '✅ Fully covered' : (max(0, $item->quantity - $allocated) . ' still needed') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($overallNeeded > 0)
                    <div class="mt-6 bg-teal-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-teal-700 font-semibold">
                            Overall: {{ $overallAllocated }}/{{ $overallNeeded }} items fulfilled ({{ round(($overallAllocated / $overallNeeded) * 100) }}%)
                        </p>
                    </div>
                @endif
            @endif
        </div>

        <!-- Live Allocation Progress -->
        @if($helpRequest->allocations->count() > 0)
            <h2 class="text-lg font-bold text-gray-900 mb-4">📋 Donation Progress</h2>

            {{-- Status summary pills --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-700">{{ $helpRequest->allocations->where('status', 'processing')->count() }}</p>
                    <p class="text-xs text-yellow-600 font-medium mt-1">⏳ Processing</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">{{ $helpRequest->allocations->where('status', 'delivery')->count() }}</p>
                    <p class="text-xs text-blue-600 font-medium mt-1">🚚 In Delivery</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">{{ $helpRequest->allocations->where('status', 'distributed')->count() }}</p>
                    <p class="text-xs text-green-600 font-medium mt-1">✅ Distributed</p>
                </div>
            </div>

            <div class="space-y-6">
                @foreach($helpRequest->allocations->sortByDesc('updated_at') as $allocation)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Allocation Header -->
                        <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                            <div>
                                @if($allocation->isMoney())
                                    <p class="font-bold text-gray-900">💰 Rs. {{ number_format($allocation->amount) }}</p>
                                @else
                                    <p class="font-bold text-gray-900">📦 {{ $allocation->item_name }} × {{ $allocation->quantity }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">Allocated on {{ $allocation->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $allocation->status_color }}">
                                {{ $allocation->status_label }}
                            </span>
                        </div>

                        <!-- 3-Stage Progress Bar -->
                        <div class="px-6 py-5">
                            @php
                                $stages = ['processing', 'delivery', 'distributed'];
                                $currentIdx = array_search($allocation->status, $stages);
                                if ($currentIdx === false) $currentIdx = -1;
                            @endphp
                            <div class="flex items-center">
                                @foreach($stages as $idx => $stage)
                                    <div class="flex-1 flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2
                                            {{ $idx <= $currentIdx ? 'bg-teal-600 border-teal-600 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
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
                                        <p class="text-xs mt-1 font-medium {{ $idx <= $currentIdx ? 'text-teal-600' : 'text-gray-400' }}">
                                            {{ $idx === 0 ? 'Processing' : ($idx === 1 ? 'Delivery' : 'Distributed') }}
                                        </p>
                                    </div>
                                    @if($idx < 2)
                                        <div class="flex-shrink-0 w-12 h-0.5 {{ $idx < $currentIdx ? 'bg-teal-600' : 'bg-gray-200' }} mt-[-16px]"></div>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Status message for recipient --}}
                            <div class="mt-4 text-center">
                                @if($allocation->isProcessing())
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                        <p class="text-sm text-yellow-800">
                                            <span class="font-semibold">Your donation is being prepared.</span>
                                            The team is processing and packaging your allocation.
                                        </p>
                                    </div>
                                @elseif($allocation->isDelivery())
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                        <p class="text-sm text-blue-800">
                                            <span class="font-semibold">Your donation is on its way!</span>
                                            It has been dispatched and is being delivered to you.
                                        </p>
                                    </div>
                                @elseif($allocation->isDistributed())
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                        <p class="text-sm text-green-800">
                                            <span class="font-semibold">Donation delivered successfully!</span>
                                            This allocation has been distributed.
                                        </p>
                                    </div>
                                @endif
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

                        <!-- OTP Section for Recipient -->
                        <div class="px-6 pb-6">
                            @if($allocation->hasOtp() && $allocation->isProcessing())
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                    <p class="text-sm font-bold text-blue-800">🔐 OTP Generated by Donor</p>
                                    <p class="text-xs text-blue-600 mt-1">The donor has generated a verification OTP. You will need it when the delivery arrives.</p>
                                </div>
                            @elseif($allocation->hasOtp() && $allocation->isDelivery() && !$allocation->isOtpVerified())
                                <div class="bg-orange-50 border-2 border-orange-300 rounded-xl p-5">
                                    <p class="text-sm font-bold text-orange-800 mb-2">🔐 Your OTP Code for Delivery Verification</p>
                                    <p class="text-xs text-orange-600 mb-1">Show this OTP to the staff during delivery:</p>
                                    <p class="text-2xl font-mono font-bold text-orange-700 tracking-widest text-center py-2 bg-white rounded-lg border border-orange-200">{{ $allocation->otp_code }}</p>
                                    <p class="text-xs text-gray-500 mt-3">When the delivery arrives, the staff will ask you to type this OTP into their system to confirm receipt.</p>
                                </div>
                            @elseif($allocation->isOtpVerified())
                                <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                                    <span class="text-3xl">✅</span>
                                    <p class="text-sm font-bold text-green-800 mt-2">OTP Verified & Distributed</p>
                                    <p class="text-xs text-green-600 mt-1">Verified {{ $allocation->otp_verified_at->diffForHumans() }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- Notes --}}
                        @if($allocation->notes)
                            <div class="px-6 pb-4">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Notes</p>
                                    <p class="text-sm text-gray-700">{{ $allocation->notes }}</p>
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
                <span class="text-5xl block mb-4">⏳</span>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No donations allocated yet</h3>
                <p class="text-gray-500">Your help request has been approved and is awaiting allocation from available donations. You'll see live updates here once donations are assigned to your request.</p>
            </div>
        @endif
    </div>
</div>
@endsection
