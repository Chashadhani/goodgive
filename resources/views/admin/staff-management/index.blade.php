@extends('admin.layouts.app')

@section('title', 'Staff Management')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Staff Management</h1>
    <p class="text-gray-600 mt-1">Manage active staff members — pause or remove access</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <p class="text-sm text-gray-500">Total Staff</p>
        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-green-50 rounded-xl shadow-sm p-5 border border-green-200">
        <p class="text-sm text-green-600">Active</p>
        <p class="text-2xl font-bold text-green-700">{{ $stats['active'] }}</p>
    </div>
    <div class="bg-orange-50 rounded-xl shadow-sm p-5 border border-orange-200">
        <p class="text-sm text-orange-600">Paused</p>
        <p class="text-2xl font-bold text-orange-700">{{ $stats['paused'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>Paused</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">Filter</button>
        <a href="{{ route('admin.staff-management.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">Clear</a>
    </form>
</div>

<!-- Staff Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($staffMembers as $staff)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 {{ $staff->is_active ? 'bg-indigo-100' : 'bg-gray-200' }} rounded-full flex items-center justify-center">
                                <span class="{{ $staff->is_active ? 'text-indigo-600' : 'text-gray-400' }} font-bold">{{ strtoupper(substr($staff->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $staff->name }}</p>
                                @if($staff->id === auth()->id())
                                    <p class="text-xs text-indigo-500 font-medium">You</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $staff->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $staff->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        @if($staff->is_active)
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">Paused</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($staff->id !== auth()->id())
                            <div class="flex items-center space-x-2">
                                @if($staff->is_active)
                                    <form action="{{ route('admin.staff-management.pause', $staff) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-orange-100 text-orange-700 rounded-lg text-xs font-semibold hover:bg-orange-200 transition"
                                            onclick="return confirm('Pause {{ $staff->name }}? They will not be able to log in.')">
                                            ⏸ Pause
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.staff-management.activate', $staff) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-xs font-semibold hover:bg-green-200 transition"
                                            onclick="return confirm('Reactivate {{ $staff->name }}?')">
                                            ▶ Activate
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.staff-management.remove', $staff) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-200 transition"
                                        onclick="return confirm('Permanently remove {{ $staff->name }}? This action cannot be undone.')">
                                        ✕ Remove
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <span class="text-4xl block mb-3">👥</span>
                        No staff members found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($staffMembers->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $staffMembers->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
