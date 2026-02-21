@extends('admin.layouts.app')

@section('title', 'Help Requests')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Help Requests</h1>
    <p class="text-gray-600 mt-1">Review and manage help requests from recipients</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-gray-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-yellow-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-green-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Approved</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">In Progress</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-indigo-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Completed</p>
        <p class="text-2xl font-bold text-indigo-600">{{ $stats['completed'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-red-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Rejected</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <form action="{{ route('admin.requests.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <!-- Search -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Search by title, description, or user..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            >
        </div>

        <!-- Status Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <!-- Category Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                        {{ $category->icon }} {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Urgency Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Urgency</label>
            <select name="urgency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">All Urgency</option>
                <option value="critical" {{ request('urgency') === 'critical' ? 'selected' : '' }}>🔴 Critical</option>
                <option value="high" {{ request('urgency') === 'high' ? 'selected' : '' }}>🟠 High</option>
                <option value="medium" {{ request('urgency') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                <option value="low" {{ request('urgency') === 'low' ? 'selected' : '' }}>🟢 Low</option>
            </select>
        </div>

        <div class="md:col-span-5 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.requests.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                Clear Filters
            </a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                Apply Filters
            </button>
        </div>
    </form>
</div>

<!-- Requests Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    @if($requests->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urgency</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($requests as $request)
                        <tr class="hover:bg-gray-50 {{ $request->status === 'pending' ? 'bg-yellow-50' : '' }}">
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $request->title }}</p>
                                    @if($request->isGoods())
                                        <p class="text-xs text-blue-600 mt-1">📦 {{ $request->items->count() }} items needed</p>
                                    @elseif($request->amount_needed)
                                        <p class="text-xs font-medium text-indigo-600 mt-1">💰 LKR {{ number_format($request->amount_needed, 2) }}</p>
                                    @else
                                        <p class="text-xs text-gray-500 truncate">{{ Str::limit($request->description, 50) }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $request->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $request->location ?? 'Location not specified' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $request->category_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $urgencyColors[$request->urgency] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $urgencyIcons[$request->urgency] ?? '' }} {{ $request->urgency_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-indigo-100 text-indigo-800',
                                        'fulfilled' => 'bg-indigo-100 text-indigo-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->created_at->format('M d, Y') }}
                                <br>
                                <span class="text-xs">{{ $request->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.requests.show', $request) }}" class="text-indigo-600 hover:text-indigo-900">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $requests->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No help requests found</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if(request()->hasAny(['search', 'status', 'category', 'urgency']))
                    Try adjusting your filters to find what you're looking for.
                @else
                    Help requests from recipients will appear here.
                @endif
            </p>
        </div>
    @endif
</div>
@endsection
