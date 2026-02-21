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

            <form action="{{ route('ngo.posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8"
                x-data="{ 
                    requestType: '{{ old('request_type', 'money') }}',
                    items: [{ item_name: '', quantity: 1, notes: '' }],
                    addItem() { this.items.push({ item_name: '', quantity: 1, notes: '' }); },
                    removeItem(index) { if (this.items.length > 1) this.items.splice(index, 1); }
                }">
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

                <!-- Request Type Toggle -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">What do you need? *</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="request_type" value="money" x-model="requestType" class="sr-only peer">
                            <div class="flex items-center justify-center px-4 py-3 border-2 rounded-lg transition peer-checked:border-green-500 peer-checked:bg-green-50 border-gray-300 hover:bg-gray-50">
                                <span class="text-xl mr-2">💰</span>
                                <span class="font-semibold text-gray-700">Money</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="request_type" value="goods" x-model="requestType" class="sr-only peer">
                            <div class="flex items-center justify-center px-4 py-3 border-2 rounded-lg transition peer-checked:border-blue-500 peer-checked:bg-blue-50 border-gray-300 hover:bg-gray-50">
                                <span class="text-xl mr-2">📦</span>
                                <span class="font-semibold text-gray-700">Goods</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Goal Amount (shown for money) -->
                <div class="mb-6" x-show="requestType === 'money'" x-transition>
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

                <!-- Goods Items (shown for goods) -->
                <div class="mb-6" x-show="requestType === 'goods'" x-transition>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Items Needed *</label>
                    @error('items')
                        <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                    @enderror
                    <div class="space-y-3">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-500 mb-1" x-text="'Item #' + (index + 1)"></label>
                                    <input type="text" :name="'items[' + index + '][item_name]'" x-model="item.item_name"
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="e.g., Rice bags, Shirts, Books">
                                </div>
                                <div class="w-24">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Qty</label>
                                    <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity" min="1"
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="1">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Notes</label>
                                    <input type="text" :name="'items[' + index + '][notes]'" x-model="item.notes"
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Optional">
                                </div>
                                <div class="pt-5">
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                        class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="addItem()"
                        class="mt-3 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Another Item
                    </button>
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
