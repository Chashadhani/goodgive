@extends('admin.layouts.app')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to All Users
    </a>
</div>

@php
    $roleColors = [
        'donor' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'label' => '🤝 Donor', 'avatar' => 'bg-orange-100 text-orange-600'],
        'ngo' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => '🏢 NGO', 'avatar' => 'bg-purple-100 text-purple-600'],
        'user' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => '🙋 Recipient', 'avatar' => 'bg-blue-100 text-blue-600'],
        'admin' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => '🛡️ Admin', 'avatar' => 'bg-red-100 text-red-600'],
        'staff' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-700', 'label' => '👤 Staff', 'avatar' => 'bg-teal-100 text-teal-600'],
    ];
    $rc = $roleColors[$user->user_type] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => ucfirst($user->user_type), 'avatar' => 'bg-gray-100 text-gray-600'];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-16 h-16 {{ $rc['avatar'] }} rounded-full flex items-center justify-center">
                        <span class="font-bold text-2xl">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-500">{{ $user->email }}</p>
                        <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rc['bg'] }} {{ $rc['text'] }}">
                            {{ $rc['label'] }}
                        </span>
                    </div>
                </div>
                
                {{-- Status badge --}}
                @if($user->user_type === 'user')
                    @if($user->recipientProfile?->status === 'approved')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">✅ Approved</span>
                    @elseif($user->recipientProfile?->status === 'rejected')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">❌ Rejected</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">⏳ Pending</span>
                    @endif
                @elseif($user->user_type === 'ngo')
                    @if($user->ngoProfile?->verification_status === 'verified')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">✅ Verified</span>
                    @elseif($user->ngoProfile?->verification_status === 'rejected')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">❌ Rejected</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">⏳ Pending</span>
                    @endif
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">✅ Active</span>
                @endif
            </div>

            {{-- Common details --}}
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Email</h3>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Registered On</h3>
                    <p class="text-gray-900">{{ $user->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
            </div>

            {{-- Donor-specific details --}}
            @if($user->user_type === 'donor' && $user->donorProfile)
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">🤝 Donor Details</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Phone</h3>
                            <p class="text-gray-900">{{ $user->donorProfile->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Address</h3>
                            <p class="text-gray-900">{{ $user->donorProfile->address ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Total Donated</h3>
                            <p class="text-2xl font-bold text-green-600">Rs. {{ number_format($user->donorProfile->total_donated ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Donations Made</h3>
                            <p class="text-2xl font-bold text-indigo-600">{{ $user->donorProfile->donation_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- NGO-specific details --}}
            @if($user->user_type === 'ngo' && $user->ngoProfile)
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">🏢 NGO Details</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Organization Name</h3>
                            <p class="text-gray-900 font-semibold">{{ $user->ngoProfile->organization_name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Registration Number</h3>
                            <p class="text-gray-900">{{ $user->ngoProfile->registration_number }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Contact Person</h3>
                            <p class="text-gray-900">{{ $user->ngoProfile->contact_person }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Phone</h3>
                            <p class="text-gray-900">{{ $user->ngoProfile->phone }}</p>
                        </div>
                        <div class="col-span-2">
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Address</h3>
                            <p class="text-gray-900">{{ $user->ngoProfile->address }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Verification Status</h3>
                            @if($user->ngoProfile->verification_status === 'verified')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Verified</span>
                            @elseif($user->ngoProfile->verification_status === 'rejected')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Pending</span>
                            @endif
                        </div>
                        @if($user->ngoProfile->verified_at)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Verified At</h3>
                                <p class="text-gray-900">{{ $user->ngoProfile->verified_at->format('M d, Y') }}</p>
                            </div>
                        @endif
                    </div>

                    @if($user->ngoProfile->documents)
                        <div class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-200">
                            <h3 class="text-sm font-medium text-indigo-800 mb-2">📄 Registration Documents</h3>
                            <a href="{{ Storage::url($user->ngoProfile->documents) }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                View / Download Document
                            </a>
                        </div>
                    @endif

                    @if($user->ngoProfile->rejection_reason)
                        <div class="mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
                            <h3 class="text-sm font-medium text-red-800 mb-1">Rejection Reason</h3>
                            <p class="text-red-700">{{ $user->ngoProfile->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Recipient-specific details --}}
            @if($user->user_type === 'user' && $user->recipientProfile)
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">🙋 Recipient Details</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Phone</h3>
                            <p class="text-gray-900">{{ $user->recipientProfile->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Location</h3>
                            <p class="text-gray-900">{{ $user->recipientProfile->location ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Need Category</h3>
                            <p class="text-gray-900">{{ ucfirst($user->recipientProfile->need_category ?? 'Not specified') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Account Status</h3>
                            @if($user->recipientProfile->status === 'approved')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                            @elseif($user->recipientProfile->status === 'rejected')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                            @elseif($user->recipientProfile->status === 'assisted')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Assisted</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Pending</span>
                            @endif
                        </div>
                        @if($user->recipientProfile->description)
                            <div class="col-span-2">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Description</h3>
                                <p class="text-gray-900">{{ $user->recipientProfile->description }}</p>
                            </div>
                        @endif
                    </div>

                    @if($user->recipientProfile->documents)
                        <div class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-200">
                            <h3 class="text-sm font-medium text-indigo-800 mb-2">📄 ID / Supporting Documents</h3>
                            <a href="{{ Storage::url($user->recipientProfile->documents) }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                View / Download Document
                            </a>
                        </div>
                    @endif

                    @if($user->recipientProfile->rejection_reason)
                        <div class="mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
                            <h3 class="text-sm font-medium text-red-800 mb-1">Rejection Reason</h3>
                            <p class="text-red-700">{{ $user->recipientProfile->rejection_reason }}</p>
                        </div>
                    @endif

                    @if($user->recipientProfile->approved_at)
                        <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                            <h3 class="text-sm font-medium text-green-800 mb-1">Account Approved On</h3>
                            <p class="text-green-700">{{ $user->recipientProfile->approved_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Actions Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        {{-- Recipient actions --}}
        @if($user->user_type === 'user' && $user->recipientProfile)
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Actions</h2>
                <div class="space-y-3">
                    @if($user->recipientProfile->status === 'pending')
                        <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Approve Account
                            </button>
                        </form>
                    @endif

                    @if($user->recipientProfile->status !== 'pending')
                        <form action="{{ route('admin.users.pending', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Set to Pending
                            </button>
                        </form>
                    @endif

                    @if($user->recipientProfile->status !== 'rejected')
                        <button type="button" onclick="document.getElementById('rejectSection').classList.toggle('hidden')" 
                            class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reject Account
                        </button>
                    @endif
                </div>

                <div id="rejectSection" class="hidden mt-4">
                    <form action="{{ route('admin.users.reject', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Rejection Reason</label>
                            <textarea name="rejection_reason" id="rejection_reason" rows="3" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                placeholder="Reason for rejection..."></textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                            Confirm Rejection
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Account Info Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Account Info</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Role</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rc['bg'] }} {{ $rc['text'] }}">{{ $rc['label'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Email Verified</span>
                    <span class="font-semibold {{ $user->email_verified_at ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $user->email_verified_at ? '✅ Yes' : '❌ No' }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Member Since</span>
                    <span class="font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">User ID</span>
                    <span class="font-mono text-sm text-gray-500">#{{ $user->id }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
