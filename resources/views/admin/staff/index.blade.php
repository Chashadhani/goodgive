@extends('admin.layouts.app')

@section('title', 'Staff Applications')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Staff Applications</h1>
    <p class="text-gray-600 mt-1">Manage staff join requests and generate login credentials</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <p class="text-sm text-gray-500">Total Applications</p>
        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-yellow-50 rounded-xl shadow-sm p-5 border border-yellow-200">
        <p class="text-sm text-yellow-600">Pending</p>
        <p class="text-2xl font-bold text-yellow-700">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-green-50 rounded-xl shadow-sm p-5 border border-green-200">
        <p class="text-sm text-green-600">Approved</p>
        <p class="text-2xl font-bold text-green-700">{{ $stats['approved'] }}</p>
    </div>
    <div class="bg-red-50 rounded-xl shadow-sm p-5 border border-red-200">
        <p class="text-sm text-red-600">Rejected</p>
        <p class="text-2xl font-bold text-red-700">{{ $stats['rejected'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, or NIC..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">Filter</button>
        <a href="{{ route('admin.staff.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">Clear</a>
    </form>
</div>

<!-- Applications Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIC</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($applications as $app)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold">{{ strtoupper(substr($app->full_name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $app->full_name }}</p>
                                <p class="text-sm text-gray-500">{{ $app->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $app->position_label }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $app->nic }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $app->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $app->status_color }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.staff.show', $app) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                            View Details →
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <span class="text-4xl block mb-3">📋</span>
                        No staff applications found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($applications->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $applications->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
