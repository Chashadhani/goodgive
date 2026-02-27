@extends('admin.layouts.app')

@section('title', 'Donation Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.donations.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
        ← Back to Donations
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Donation Details Card -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 
                @if($donation->status === 'confirmed') bg-gradient-to-r from-green-500 to-emerald-500
                @elseif($donation->status === 'rejected') bg-gradient-to-r from-red-500 to-pink-500
                @else bg-gradient-to-r from-orange-500 to-yellow-500
                @endif">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">{{ $donation->isMoney() ? '💰' : '📦' }}</span>
                        <div>
                            <h1 class="text-xl font-bold text-white">
                                @if($donation->isMoney())
                                    Rs. {{ number_format($donation->amount, 2) }}
                                @else
                                    Goods Donation ({{ $donation->total_items_count }} items)
                                @endif
                            </h1>
                            <p class="text-white/80 text-sm">{{ ucfirst($donation->donation_type) }} Donation • #{{ $donation->id }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1.5 rounded-full text-sm font-bold
                        @if($donation->status === 'confirmed') bg-white text-green-700
                        @elseif($donation->status === 'rejected') bg-white text-red-700
                        @else bg-white text-orange-700
                        @endif">
                        {{ ucfirst($donation->status) }}
                    </span>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Donation Type</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $donation->isMoney() ? '💰 Money' : '📦 Goods' }}</p>
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
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Submitted</p>
                        <p class="font-semibold text-gray-900 mt-1">{{ $donation->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Status</p>
                        <p class="font-semibold mt-1 
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

                @if($donation->donor_notes)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Donor Notes</p>
                        <p class="text-gray-900 mt-1">{{ $donation->donor_notes }}</p>
                    </div>
                @endif

                @if($donation->ngoPost)
                    <div class="border border-blue-200 bg-blue-50 rounded-xl p-4">
                        <p class="text-xs text-blue-500 uppercase tracking-wide mb-2">Linked to NGO Post</p>
                        <h3 class="font-semibold text-blue-900">{{ $donation->ngoPost->title }}</h3>
                        <p class="text-sm text-blue-700 mt-1">{{ Str::limit($donation->ngoPost->description, 150) }}</p>
                    </div>
                @else
                    <div class="border border-gray-200 bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-600">This is a <strong>Direct Donation</strong> — not linked to any specific NGO post.</p>
                    </div>
                @endif

                @if($donation->reviewed_at)
                    <div class="border-t border-gray-100 pt-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Review Info</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-xs text-gray-500">Reviewed By</p>
                                <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $donation->reviewer?->name ?? 'Admin' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-xs text-gray-500">Reviewed At</p>
                                <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $donation->reviewed_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @if($donation->admin_notes)
                            <div class="bg-gray-50 rounded-xl p-3 mt-3">
                                <p class="text-xs text-gray-500">Admin Notes</p>
                                <p class="text-sm text-gray-900 mt-0.5">{{ $donation->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar: Donor Info & Actions -->
    <div class="space-y-6">
        <!-- Donor Info -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Donor Information</h3>
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-bold text-lg">{{ strtoupper(substr($donation->user->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $donation->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $donation->user->email }}</p>
                    </div>
                </div>
                @if($donation->user->donorProfile)
                    <div class="border-t border-gray-100 pt-3 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Phone</span>
                            <span class="text-gray-900">{{ $donation->user->donorProfile->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Total Donated</span>
                            <span class="text-gray-900 font-medium">Rs. {{ number_format($donation->user->donorProfile->total_donated, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Donation Count</span>
                            <span class="text-gray-900 font-medium">{{ $donation->user->donorProfile->donation_count }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Admin Actions</h3>
            
            @if($donation->isPending())
                <!-- Confirm -->
                <form action="{{ route('admin.donations.confirm', $donation) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <textarea name="admin_notes" rows="2" placeholder="Admin notes (optional)..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 mb-2"></textarea>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg font-semibold transition">
                        ✓ Confirm Donation
                    </button>
                </form>

                <!-- Reject -->
                <form action="{{ route('admin.donations.reject', $donation) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="admin_notes" value="">
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg font-semibold transition"
                        onclick="return confirm('Are you sure you want to reject this donation?')">
                        ✕ Reject Donation
                    </button>
                </form>
            @elseif($donation->isConfirmed())
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center mb-3">
                    <span class="text-2xl">✅</span>
                    <p class="text-green-800 font-medium mt-1">Donation Confirmed</p>
                </div>
                <form action="{{ route('admin.donations.pending', $donation) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition"
                        onclick="return confirm('Set this donation back to pending?')">
                        Reset to Pending
                    </button>
                </form>
            @elseif($donation->isRejected())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center mb-3">
                    <span class="text-2xl">❌</span>
                    <p class="text-red-800 font-medium mt-1">Donation Rejected</p>
                </div>
                <form action="{{ route('admin.donations.pending', $donation) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition"
                        onclick="return confirm('Set this donation back to pending?')">
                        Reset to Pending
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
