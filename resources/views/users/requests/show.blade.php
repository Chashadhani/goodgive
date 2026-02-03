@extends('layouts.app')

@section('title', 'View Help Request')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('recipient.requests.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to My Requests
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-200">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $helpRequest->title }}</h1>
                    <p class="text-gray-500 mt-1">Submitted on {{ $helpRequest->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $helpRequest->status_color }}">
                    {{ ucfirst($helpRequest->status) }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="px-8 py-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Category</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        {{ $helpRequest->category_label }}
                    </span>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Urgency</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                        @if($helpRequest->urgency === 'critical') bg-red-100 text-red-800
                        @elseif($helpRequest->urgency === 'high') bg-orange-100 text-orange-800
                        @elseif($helpRequest->urgency === 'medium') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800
                        @endif">
                        {{ $helpRequest->urgency_label }}
                    </span>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Location</h3>
                    <p class="text-gray-900">{{ $helpRequest->location ?? 'Not specified' }}</p>
                </div>
            </div>

            @if($helpRequest->amount_needed)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Amount Needed</h3>
                    <p class="text-2xl font-bold text-indigo-600">LKR {{ number_format($helpRequest->amount_needed, 2) }}</p>
                </div>
            @endif

            <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Description</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $helpRequest->description }}</p>
                </div>
            </div>

            @if($helpRequest->documents)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Supporting Documents</h3>
                    <div class="space-y-2">
                        @foreach(json_decode($helpRequest->documents, true) as $document)
                            <a href="{{ Storage::url($document) }}" target="_blank" 
                               class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-indigo-600 hover:text-indigo-800">{{ basename($document) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($helpRequest->isRejected() && $helpRequest->rejection_reason)
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-red-800 mb-1">Rejection Reason</h3>
                    <p class="text-red-700">{{ $helpRequest->rejection_reason }}</p>
                </div>
            @endif

            @if($helpRequest->admin_notes)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-1">Admin Notes</h3>
                    <p class="text-blue-700">{{ $helpRequest->admin_notes }}</p>
                </div>
            @endif

            @if($helpRequest->approved_at)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-green-800 mb-1">Request Approved</h3>
                    <p class="text-green-700">Approved on {{ $helpRequest->approved_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
            @endif

            @if($helpRequest->fulfilled_at)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-1">Request Fulfilled</h3>
                    <p class="text-blue-700">Fulfilled on {{ $helpRequest->fulfilled_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
            @endif
        </div>

        <!-- Actions -->
        @if($helpRequest->isPending())
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-4">
                <a href="{{ route('recipient.requests.edit', $helpRequest) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Request
                </a>
                
                <form action="{{ route('recipient.requests.destroy', $helpRequest) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this request?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Request
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
