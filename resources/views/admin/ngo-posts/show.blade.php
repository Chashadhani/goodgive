@extends('admin.layouts.app')

@section('title', 'Review NGO Post')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.ngo-posts.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to NGO Posts
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Post Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            @if($ngoPost->image)
                <img src="{{ Storage::url($ngoPost->image) }}" alt="{{ $ngoPost->title }}" class="w-full h-64 object-cover">
            @else
                @php
                    $gradients = [
                        'Education' => 'from-indigo-400 to-purple-500',
                        'Healthcare' => 'from-red-400 to-pink-500',
                        'Shelter' => 'from-blue-400 to-cyan-500',
                        'Food Security' => 'from-green-400 to-emerald-500',
                        'Child Welfare' => 'from-pink-400 to-rose-500',
                        'Elderly Care' => 'from-purple-400 to-indigo-500',
                    ];
                    $gradient = $gradients[$ngoPost->category] ?? 'from-gray-400 to-gray-500';
                @endphp
                <div class="h-48 bg-gradient-to-br {{ $gradient }} flex items-center justify-center">
                    <span class="text-6xl">📝</span>
                </div>
            @endif

            <div class="p-8">
                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-sm font-semibold rounded-full">{{ $ngoPost->category }}</span>
                    @if($ngoPost->urgency === 'critical')
                        <span class="px-3 py-1 bg-red-50 text-red-700 text-sm font-semibold rounded-full">🚨 Critical</span>
                    @elseif($ngoPost->urgency === 'urgent')
                        <span class="px-3 py-1 bg-orange-50 text-orange-700 text-sm font-semibold rounded-full">🔥 Urgent</span>
                    @else
                        <span class="px-3 py-1 bg-gray-50 text-gray-700 text-sm font-semibold rounded-full">Normal</span>
                    @endif
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $ngoPost->title }}</h1>

                @if($ngoPost->isMoney() && $ngoPost->goal_amount)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-green-600 font-medium">💰 Donation Goal (Money)</p>
                        <p class="text-2xl font-bold text-green-700">Rs. {{ number_format($ngoPost->goal_amount) }}</p>
                    </div>
                @endif

                @if($ngoPost->isGoods() && $ngoPost->items->count())
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-blue-600 font-medium mb-3">📦 Items Needed (Goods)</p>
                        <div class="space-y-2">
                            @foreach($ngoPost->items as $item)
                                <div class="flex items-center justify-between bg-white rounded-lg px-4 py-2 border border-blue-100">
                                    <div>
                                        <span class="font-medium text-gray-900">{{ $item->item_name }}</span>
                                        @if($item->notes)
                                            <span class="text-xs text-gray-500 ml-2">({{ $item->notes }})</span>
                                        @endif
                                    </div>
                                    <span class="text-sm font-bold text-blue-700 bg-blue-100 px-3 py-1 rounded-full">× {{ $item->quantity }}</span>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-sm text-blue-600 mt-3 font-semibold">Total items: {{ $ngoPost->total_items_count }}</p>
                    </div>
                @endif

                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($ngoPost->description)) !!}
                </div>

                <div class="text-sm text-gray-500 border-t pt-4 mt-6">
                    <p>Created: {{ $ngoPost->created_at->format('M d, Y \a\t h:i A') }}</p>
                    @if($ngoPost->reviewed_at)
                        <p>Reviewed: {{ $ngoPost->reviewed_at->format('M d, Y \a\t h:i A') }} by {{ $ngoPost->reviewer?->name ?? 'Unknown' }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- NGO Info -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">NGO Information</h3>
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <span class="text-indigo-600 font-bold">{{ strtoupper(substr($ngoPost->user->ngoProfile->organization_name ?? $ngoPost->user->name, 0, 2)) }}</span>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $ngoPost->user->ngoProfile->organization_name ?? $ngoPost->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $ngoPost->user->email }}</p>
                </div>
            </div>
            @if($ngoPost->user->ngoProfile)
                @if($ngoPost->user->ngoProfile->isVerified())
                    <span class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 text-sm font-semibold rounded-full">✅ Verified</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 bg-yellow-50 text-yellow-700 text-sm font-semibold rounded-full">⏳ Not Verified</span>
                @endif
            @endif
        </div>

        <!-- Current Status -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Current Status</h3>
            @if($ngoPost->status === 'approved')
                <div class="flex items-center space-x-2 text-green-700 bg-green-50 rounded-lg p-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-semibold">Approved</span>
                </div>
            @elseif($ngoPost->status === 'rejected')
                <div class="flex items-center space-x-2 text-red-700 bg-red-50 rounded-lg p-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-semibold">Rejected</span>
                </div>
            @else
                <div class="flex items-center space-x-2 text-yellow-700 bg-yellow-50 rounded-lg p-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-semibold">Pending Review</span>
                </div>
            @endif

            @if($ngoPost->admin_notes)
                <div class="mt-4 bg-gray-50 rounded-lg p-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Admin Notes</p>
                    <p class="text-sm text-gray-700">{{ $ngoPost->admin_notes }}</p>
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
            
            @if($ngoPost->status !== 'approved')
                <form action="{{ route('admin.ngo-posts.approve', $ngoPost) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <textarea name="admin_notes" rows="2" placeholder="Optional approval notes..." 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Approve Post</span>
                    </button>
                </form>
            @endif

            @if($ngoPost->status !== 'rejected')
                <form action="{{ route('admin.ngo-posts.reject', $ngoPost) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <textarea name="admin_notes" rows="2" placeholder="Reason for rejection (required)..." required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Reject Post</span>
                    </button>
                </form>
            @endif

            @if($ngoPost->status !== 'pending')
                <form action="{{ route('admin.ngo-posts.pending', $ngoPost) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Reset to Pending</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
