@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to User Accounts
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center">
                        <span class="text-pink-600 font-bold text-2xl">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                
                @if($user->recipientProfile?->status === 'approved')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Account Approved
                    </span>
                @elseif($user->recipientProfile?->status === 'rejected')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        Account Rejected
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Pending Approval
                    </span>
                @endif
            </div>

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
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Registered On</h3>
                    <p class="text-gray-900">{{ $user->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Email</h3>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
            </div>

            @if($user->recipientProfile?->status === 'rejected' && $user->recipientProfile?->rejection_reason)
                <div class="mt-6 p-4 bg-red-50 rounded-lg border border-red-200">
                    <h3 class="text-sm font-medium text-red-800 mb-1">Rejection Reason</h3>
                    <p class="text-red-700">{{ $user->recipientProfile->rejection_reason }}</p>
                </div>
            @endif

            @if($user->recipientProfile?->approved_at)
                <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                    <h3 class="text-sm font-medium text-green-800 mb-1">Account Approved On</h3>
                    <p class="text-green-700">{{ $user->recipientProfile->approved_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
            @endif

            @if($user->recipientProfile?->status === 'approved')
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-blue-800 mb-1">Account Active</h3>
                            <p class="text-blue-700 text-sm">This user can now submit help requests from their dashboard.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Actions</h2>
            
            <div class="space-y-3">
                @if($user->recipientProfile?->status === 'pending')
                    <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve Account
                        </button>
                    </form>
                @endif

                @if($user->recipientProfile?->status !== 'pending')
                    <form action="{{ route('admin.users.pending', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Set to Pending
                        </button>
                    </form>
                @endif

                @if($user->recipientProfile?->status !== 'rejected')
                    <button type="button" onclick="document.getElementById('rejectSection').classList.toggle('hidden')" 
                        class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reject Account
                    </button>
                @endif
            </div>

            <!-- Reject Form -->
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

        <!-- User Info Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mt-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Account Info</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Account Type</span>
                    <span class="font-semibold text-gray-900">{{ $user->user_type_label }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Email Verified</span>
                    <span class="font-semibold {{ $user->email_verified_at ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $user->email_verified_at ? 'Yes' : 'No' }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Member Since</span>
                    <span class="font-semibold text-gray-900">{{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
