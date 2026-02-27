@extends('layouts.app')

@section('title', 'Allocation Tracking - ' . $ngoPost->title)

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Link -->
        <div class="mb-6">
            <a href="{{ route('ngo.posts.show', $ngoPost) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                ← Back to Post Details
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                <h1 class="text-2xl font-bold text-white">📍 Allocation Tracking</h1>
                <p class="text-white/80 text-sm mt-1">Track donations allocated to your post and verify deliveries.</p>
            </div>
            <div class="px-8 py-5 flex items-center justify-between border-b border-gray-100">
                <div>
                    <p class="text-sm text-gray-500">NGO Post #{{ $ngoPost->id }}</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $ngoPost->title }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-bold {{ $ngoPost->status_color ?? 'bg-gray-100 text-gray-700' }}">
                    {{ ucfirst($ngoPost->status) }}
                </span>
            </div>
        </div>

        <!-- Status Summary -->
        @if($ngoPost->allocations->count() > 0)
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-700">{{ $ngoPost->allocations->where('status', 'processing')->count() }}</p>
                    <p class="text-xs text-yellow-600 font-medium mt-1">⏳ Processing</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">{{ $ngoPost->allocations->where('status', 'delivery')->count() }}</p>
                    <p class="text-xs text-blue-600 font-medium mt-1">🚚 In Delivery</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">{{ $ngoPost->allocations->where('status', 'distributed')->count() }}</p>
                    <p class="text-xs text-green-600 font-medium mt-1">✅ Distributed</p>
                </div>
            </div>

            <h2 class="text-lg font-bold text-gray-900 mb-4">📋 Allocation Details</h2>

            <div class="space-y-6">
                @foreach($ngoPost->allocations->sortByDesc('updated_at') as $allocation)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Header -->
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

                        <!-- Progress Bar -->
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
                                            {{ $idx <= $currentIdx ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                            @if($idx < $currentIdx) ✓
                                            @elseif($idx === 0) ⏳
                                            @elseif($idx === 1) 🚚
                                            @else ✅
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

                        <!-- Proof Photo -->
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

                        <!-- OTP Section for NGO -->
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
                <p class="text-gray-500">Your post is awaiting allocations from available donations. You'll see live updates here once donations are assigned.</p>
            </div>
        @endif
    </div>
</div>
@endsection
