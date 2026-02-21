<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Post - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Link -->
            <a href="{{ route('ngo.posts.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to My Posts
            </a>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Post</h1>
            <p class="text-gray-600 mb-8">Share your NGO's needs with the community. Your post will be reviewed before publishing.</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('ngo.posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                @csrf

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Post Title *</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title') }}" 
                        placeholder="e.g., School Supplies Needed for 100 Children" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        required
                    >
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                    <select 
                        name="category" 
                        id="category" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        required
                    >
                        <option value="">Select a category</option>
                        <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Healthcare" {{ old('category') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="Shelter" {{ old('category') == 'Shelter' ? 'selected' : '' }}>Shelter</option>
                        <option value="Food Security" {{ old('category') == 'Food Security' ? 'selected' : '' }}>Food Security</option>
                        <option value="Child Welfare" {{ old('category') == 'Child Welfare' ? 'selected' : '' }}>Child Welfare</option>
                        <option value="Elderly Care" {{ old('category') == 'Elderly Care' ? 'selected' : '' }}>Elderly Care</option>
                        <option value="Disaster Relief" {{ old('category') == 'Disaster Relief' ? 'selected' : '' }}>Disaster Relief</option>
                        <option value="Environment" {{ old('category') == 'Environment' ? 'selected' : '' }}>Environment</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Urgency -->
                <div class="mb-6">
                    <label for="urgency" class="block text-sm font-semibold text-gray-700 mb-2">Urgency Level *</label>
                    <select 
                        name="urgency" 
                        id="urgency" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        required
                    >
                        <option value="normal" {{ old('urgency') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="urgent" {{ old('urgency') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="critical" {{ old('urgency') == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>

                <!-- Goal Amount -->
                <div class="mb-6">
                    <label for="goal_amount" class="block text-sm font-semibold text-gray-700 mb-2">Goal Amount (Rs.) <span class="text-gray-400 font-normal">- Optional</span></label>
                    <input 
                        type="number" 
                        name="goal_amount" 
                        id="goal_amount" 
                        value="{{ old('goal_amount') }}" 
                        placeholder="e.g., 50000" 
                        step="0.01" 
                        min="0"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="6" 
                        placeholder="Describe in detail what you need and how it will help..." 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        required
                    >{{ old('description') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Minimum 20 characters</p>
                </div>

                <!-- Image Upload -->
                <div class="mb-8">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Cover Image <span class="text-gray-400 font-normal">- Optional</span></label>
                    <input 
                        type="file" 
                        name="image" 
                        id="image" 
                        accept="image/*"
                        class="w-full px-4 py-3 border-2 border-gray-300 border-dashed rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                    <p class="text-xs text-gray-500 mt-1">Max 2MB. Supported: JPEG, PNG, JPG, GIF, WEBP</p>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('ngo.posts.index') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold transition shadow-lg">
                        Submit Post for Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
