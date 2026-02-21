@extends('admin.layouts.app')

@section('title', 'Donations Management')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Donations Management</h1>
    <p class="text-gray-600 mt-1">Review and manage all donor donations</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Total</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalDonations }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Pending</p>
        <p class="text-2xl font-bold text-orange-600 mt-1">{{ $pendingDonations }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Confirmed</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ $confirmedDonations }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Rejected</p>
        <p class="text-2xl font-bold text-red-600 mt-1">{{ $rejectedDonations }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Money Donated</p>
        <p class="text-2xl font-bold text-indigo-600 mt-1">Rs. {{ number_format($totalMoneyDonated, 2) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Goods Donations</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalGoodsDonations }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <div class="flex flex-wrap items-center gap-3">
        <span class="text-sm font-medium text-gray-600">Filter:</span>
        <a href="{{ route('admin.donations.index') }}" 
            class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ !request('status') && !request('type') ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            All ({{ $totalDonations }})
        </a>
        <a href="{{ route('admin.donations.index', ['status' => 'pending']) }}"
            class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('status') === 'pending' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Pending ({{ $pendingDonations }})
        </a>
        <a href="{{ route('admin.donations.index', ['status' => 'confirmed']) }}"
            class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('status') === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Confirmed ({{ $confirmedDonations }})
        </a>
        <a href="{{ route('admin.donations.index', ['status' => 'rejected']) }}"
            class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('status') === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Rejected ({{ $rejectedDonations }})
        </a>
        <span class="text-gray-300">|</span>
        <a href="{{ route('admin.donations.index', ['type' => 'money']) }}"
            class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('type') === 'money' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            💰 Money
        </a>
        <a href="{{ route('admin.donations.index', ['type' => 'goods']) }}"
            class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('type') === 'goods' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            📦 Goods
        </a>
    </div>
</div>

<!-- Donations Table -->
@if($donations->count() > 0)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Linked Post</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($donations as $donation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-600 font-semibold text-xs">{{ strtoupper(substr($donation->user->name, 0, 2)) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $donation->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $donation->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $donation->donation_type === 'money' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $donation->donation_type === 'money' ? '💰' : '📦' }} {{ ucfirst($donation->donation_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($donation->isMoney())
                                <p class="text-sm font-semibold text-gray-900">Rs. {{ number_format($donation->amount, 2) }}</p>
                            @else
                                <p class="text-sm text-gray-900">{{ Str::limit($donation->goods_summary, 40) }}</p>
                                <p class="text-xs text-gray-500">{{ $donation->total_items_count }} items</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($donation->ngoPost)
                                <p class="text-sm text-gray-900">{{ Str::limit($donation->ngoPost->title, 25) }}</p>
                            @else
                                <span class="text-xs text-gray-400">Direct Donation</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                @if($donation->status === 'pending') bg-orange-100 text-orange-800
                                @elseif($donation->status === 'confirmed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $donation->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.donations.show', $donation) }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                                View →
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $donations->withQueryString()->links() }}
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
        <span class="text-6xl mb-4 block">📋</span>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Donations Found</h3>
        <p class="text-gray-500">No donations match the current filter criteria.</p>
        <a href="{{ route('admin.donations.index') }}" class="inline-block mt-4 text-indigo-600 hover:text-indigo-700 font-medium">
            View all donations →
        </a>
    </div>
@endif
@endsection
