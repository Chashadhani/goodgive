@extends('admin.layouts.app')

@section('title', 'Add Help Category')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Categories
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Add Help Category</h1>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Category Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    placeholder="e.g., Education, Healthcare"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                >
            </div>

            <!-- Icon -->
            <div>
                <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
                    Icon (Emoji) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="icon" 
                    name="icon" 
                    value="{{ old('icon', '📋') }}"
                    required
                    maxlength="50"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-2xl"
                >
                <p class="text-xs text-gray-500 mt-1">Use an emoji icon (e.g., 📚, 🏥, 🏠)</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    <span class="text-xs text-gray-500">Quick select:</span>
                    @foreach(['📚', '🏥', '🏠', '🍚', '👕', '🚨', '💼', '📋', '❤️', '🎓', '💊', '🚗', '⚡', '💰', '🛠️', '👶'] as $emoji)
                        <button type="button" onclick="document.getElementById('icon').value='{{ $emoji }}'" class="text-xl hover:bg-gray-100 rounded p-1">{{ $emoji }}</button>
                    @endforeach
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Description
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3"
                    placeholder="Brief description of this help category"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"
                >{{ old('description') }}</textarea>
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">
                    Sort Order
                </label>
                <input 
                    type="number" 
                    id="sort_order" 
                    name="sort_order" 
                    value="{{ old('sort_order', 0) }}"
                    min="0"
                    class="w-32 px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                >
                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="is_active" 
                    name="is_active" 
                    value="1"
                    {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded focus:ring-indigo-500"
                >
                <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                    Active (visible to users)
                </label>
            </div>

            <!-- Preview -->
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-sm font-semibold text-gray-700 mb-3">Preview:</p>
                <div class="border-2 border-gray-200 rounded-2xl p-4 sm:p-6 text-center bg-white max-w-[200px]">
                    <div class="text-4xl mb-3" id="preview-icon">📋</div>
                    <h3 class="font-semibold text-gray-800" id="preview-name">Category Name</h3>
                    <p class="text-xs text-gray-500 mt-1" id="preview-desc">Description here</p>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Live preview
    document.getElementById('name').addEventListener('input', function() {
        document.getElementById('preview-name').textContent = this.value || 'Category Name';
    });
    document.getElementById('icon').addEventListener('input', function() {
        document.getElementById('preview-icon').textContent = this.value || '📋';
    });
    document.getElementById('description').addEventListener('input', function() {
        document.getElementById('preview-desc').textContent = this.value || 'Description here';
    });
</script>
@endpush
@endsection
