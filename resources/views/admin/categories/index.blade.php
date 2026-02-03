@extends('admin.layouts.app')

@section('title', 'Help Categories')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Help Categories</h1>
        <p class="text-gray-600 mt-1">Manage help request categories that users can select</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Category
    </a>
</div>

<!-- Categories Table -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Requests</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition {{ !$category->is_active ? 'opacity-50' : '' }}">
                    <td class="px-6 py-4">
                        <span class="text-gray-500 font-medium">{{ $category->sort_order }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">{{ $category->icon }}</span>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                                <p class="text-xs text-gray-500">{{ $category->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-600 max-w-xs truncate">{{ $category->description ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($category->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-gray-600 font-medium">{{ $category->helpRequests()->count() }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <form action="{{ route('admin.categories.toggle', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="p-2 rounded-lg hover:bg-gray-100 transition" title="{{ $category->is_active ? 'Deactivate' : 'Activate' }}">
                                    @if($category->is_active)
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 rounded-lg hover:bg-gray-100 transition" title="Edit">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg hover:bg-red-50 transition" title="Delete">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <p class="text-gray-500">No categories found</p>
                            <a href="{{ route('admin.categories.create') }}" class="mt-3 text-indigo-600 hover:text-indigo-700 font-medium">
                                Create your first category
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($categories->hasPages())
    <div class="mt-6">
        {{ $categories->links() }}
    </div>
@endif
@endsection
