@extends('admin.layouts.app')

@section('title', 'Review Request')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.requests.index') }}" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Requests
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Request Header -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'in_progress' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-indigo-100 text-indigo-800',
                                'fulfilled' => 'bg-indigo-100 text-indigo-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];
                            $urgencyColors = [
                                'critical' => 'bg-red-100 text-red-800',
                                'high' => 'bg-orange-100 text-orange-800',
                                'medium' => 'bg-yellow-100 text-yellow-800',
                                'low' => 'bg-green-100 text-green-800',
                            ];
                            $urgencyIcons = [
                                'critical' => '🔴',
                                'high' => '🟠',
                                'medium' => '🟡',
                                'low' => '🟢',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$helpRequest->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $helpRequest->status)) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $urgencyColors[$helpRequest->urgency] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $urgencyIcons[$helpRequest->urgency] ?? '' }} {{ $helpRequest->urgency_label }} Urgency
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $helpRequest->title }}</h1>
                    <p class="text-gray-500 mt-1">
                        Submitted {{ $helpRequest->created_at->format('F d, Y \a\t h:i A') }}
                        ({{ $helpRequest->created_at->diffForHumans() }})
                    </p>
                </div>
            </div>
        </div>

        <!-- Request Details -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Request Details</h2>
            
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Category</p>
                    <p class="font-medium text-gray-900">{{ $helpRequest->category_label }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Amount Needed</p>
                    <p class="font-medium text-gray-900">
                        @if($helpRequest->amount_needed)
                            LKR {{ number_format($helpRequest->amount_needed, 2) }}
                        @else
                            Not specified
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Location</p>
                    <p class="font-medium text-gray-900">{{ $helpRequest->location ?? 'Not specified' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Request ID</p>
                    <p class="font-medium text-gray-900">#{{ $helpRequest->id }}</p>
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-2">Description</p>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-800 whitespace-pre-line">{{ $helpRequest->description }}</p>
                </div>
            </div>
        </div>

        <!-- Documents -->
        @if($helpRequest->documents)
            @php
                $documents = json_decode($helpRequest->documents, true) ?? [];
            @endphp
            @if(count($documents) > 0)
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Supporting Documents</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($documents as $document)
                            @php
                                $extension = pathinfo($document, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                            @endphp
                            <a href="{{ asset('storage/' . $document) }}" target="_blank" class="group">
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 hover:bg-indigo-50 transition">
                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $document) }}" alt="Document" class="w-full h-24 object-cover rounded mb-2">
                                    @else
                                        <div class="w-full h-24 bg-gray-100 rounded mb-2 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-xs text-gray-600 truncate group-hover:text-indigo-600">
                                        {{ basename($document) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <!-- Admin Notes -->
        @if($helpRequest->admin_notes)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Admin Notes</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-800 whitespace-pre-line">{{ $helpRequest->admin_notes }}</p>
                </div>
                @if($helpRequest->reviewer)
                    <p class="text-sm text-gray-500 mt-3">
                        Reviewed by {{ $helpRequest->reviewer->name }} 
                        @if($helpRequest->reviewed_at)
                            on {{ $helpRequest->reviewed_at->format('M d, Y \a\t h:i A') }}
                        @endif
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Requester Info -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Requester Information</h2>
            
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                    <span class="text-xl font-bold text-indigo-600">{{ substr($helpRequest->user->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $helpRequest->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $helpRequest->user->email }}</p>
                </div>
            </div>

            @if($helpRequest->user->recipientProfile)
                <div class="space-y-3 pt-4 border-t border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500">Phone</p>
                        <p class="text-sm font-medium">{{ $helpRequest->user->recipientProfile->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Location</p>
                        <p class="text-sm font-medium">{{ $helpRequest->user->recipientProfile->location ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Account Status</p>
                        @php
                            $accountStatus = $helpRequest->user->recipientProfile->status ?? 'pending';
                            $accountStatusColors = [
                                'pending' => 'text-yellow-600',
                                'approved' => 'text-green-600',
                                'rejected' => 'text-red-600',
                            ];
                        @endphp
                        <p class="text-sm font-medium {{ $accountStatusColors[$accountStatus] ?? 'text-gray-600' }}">
                            {{ ucfirst($accountStatus) }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.users.show', $helpRequest->user) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    View Full Profile →
                </a>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>

            <div class="space-y-3">
                @if($helpRequest->status === 'pending')
                    <!-- Approve Form -->
                    <form action="{{ route('admin.requests.approve', $helpRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Add any notes..."></textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve Request
                        </button>
                    </form>

                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-2 bg-white text-gray-500">or</span>
                        </div>
                    </div>

                    <!-- Reject Form -->
                    <form action="{{ route('admin.requests.reject', $helpRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rejection Reason <span class="text-red-500">*</span></label>
                            <textarea name="admin_notes" rows="2" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Please provide a reason for rejection..."></textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject Request
                        </button>
                    </form>
                @elseif($helpRequest->status === 'approved')
                    <!-- Mark In Progress -->
                    <form action="{{ route('admin.requests.in-progress', $helpRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                            <textarea name="admin_notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Add progress notes...">{{ $helpRequest->admin_notes }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Mark In Progress
                        </button>
                    </form>

                    <form action="{{ route('admin.requests.pending', $helpRequest) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition text-sm">
                            Reset to Pending
                        </button>
                    </form>
                @elseif($helpRequest->status === 'in_progress')
                    <!-- Mark Complete -->
                    <form action="{{ route('admin.requests.complete', $helpRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Completion Notes (Optional)</label>
                            <textarea name="admin_notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Add completion notes...">{{ $helpRequest->admin_notes }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Mark Completed
                        </button>
                    </form>

                    <form action="{{ route('admin.requests.pending', $helpRequest) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition text-sm">
                            Reset to Pending
                        </button>
                    </form>
                @elseif($helpRequest->status === 'completed' || $helpRequest->status === 'fulfilled')
                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 text-center">
                        <svg class="w-8 h-8 text-indigo-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium text-indigo-800">Request Completed</p>
                        @if($helpRequest->completed_at)
                            <p class="text-xs text-indigo-600 mt-1">{{ $helpRequest->completed_at->format('M d, Y') }}</p>
                        @endif
                    </div>

                    <form action="{{ route('admin.requests.pending', $helpRequest) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition text-sm">
                            Reopen Request
                        </button>
                    </form>
                @elseif($helpRequest->status === 'rejected')
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                        <svg class="w-8 h-8 text-red-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium text-red-800">Request Rejected</p>
                    </div>

                    <form action="{{ route('admin.requests.pending', $helpRequest) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition text-sm">
                            Reset to Pending
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Request Created</p>
                        <p class="text-xs text-gray-500">{{ $helpRequest->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                </div>

                @if($helpRequest->reviewed_at)
                    <div class="flex items-start">
                        <div class="w-8 h-8 {{ $helpRequest->status === 'rejected' ? 'bg-red-100' : 'bg-green-100' }} rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            @if($helpRequest->status === 'rejected')
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $helpRequest->status === 'rejected' ? 'Rejected' : 'Reviewed' }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $helpRequest->reviewed_at->format('M d, Y \a\t h:i A') }}</p>
                            @if($helpRequest->reviewer)
                                <p class="text-xs text-gray-400">by {{ $helpRequest->reviewer->name }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($helpRequest->completed_at)
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Completed</p>
                            <p class="text-xs text-gray-500">{{ $helpRequest->completed_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
