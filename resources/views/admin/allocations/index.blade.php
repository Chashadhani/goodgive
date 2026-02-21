@extends('admin.layouts.app')

@section('title', 'Stock Allocations')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Stock Allocations</h1>
        <p class="text-gray-600 mt-1">Track donations allocated to NGO posts & help requests</p>
    </div>
    <a href="{{ route('admin.allocations.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        New Allocation
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-gray-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">⏳ Processing</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['processing'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">🚚 In Delivery</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['delivery'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-400">
        <p class="text-xs text-gray-500 uppercase tracking-wider">✅ Distributed</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['distributed'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <form action="{{ route('admin.allocations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search donor or item..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        <div>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>⏳ Processing</option>
                <option value="delivery" {{ request('status') === 'delivery' ? 'selected' : '' }}>🚚 In Delivery</option>
                <option value="distributed" {{ request('status') === 'distributed' ? 'selected' : '' }}>✅ Distributed</option>
            </select>
        </div>
        <div>
            <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">All Types</option>
                <option value="money" {{ request('type') === 'money' ? 'selected' : '' }}>💰 Money</option>
                <option value="goods" {{ request('type') === 'goods' ? 'selected' : '' }}>📦 Goods</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">Filter</button>
            <a href="{{ route('admin.allocations.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Clear</a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    @if($allocations->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">What</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">From (Donor)</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">To (Target)</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Date</th>
                    <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($allocations as $allocation)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            @if($allocation->isMoney())
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg">💰</span>
                                    <div>
                                        <p class="font-semibold text-gray-900">Rs. {{ number_format($allocation->amount) }}</p>
                                        <p class="text-xs text-gray-500">Money</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg">📦</span>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $allocation->item_name }}</p>
                                        <p class="text-xs text-gray-500">× {{ $allocation->quantity }}</p>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $allocation->donation->user->name ?? 'Unknown' }}</p>
                            <p class="text-xs text-gray-500">Donation #{{ $allocation->donation_id }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ Str::limit($allocation->allocatable?->title ?? 'N/A', 30) }}</p>
                            <p class="text-xs text-gray-500">{{ $allocation->allocatable_type === 'App\\Models\\NgoPost' ? 'NGO Post' : 'Help Request' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $allocation->status_color }}">
                                {{ $allocation->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $allocation->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.allocations.show', $allocation) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                Manage →
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $allocations->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <span class="text-5xl block mb-4">📋</span>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">No Allocations Yet</h3>
            <p class="text-gray-500 mb-4">Allocate stock from confirmed donations to NGO posts or help requests.</p>
            <a href="{{ route('admin.allocations.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                Create First Allocation
            </a>
        </div>
    @endif
</div>
@endsection
