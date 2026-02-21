<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Submit Help Request - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-content {
            display: none;
            animation: fadeIn 0.4s ease;
        }
        .step-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .category-card {
            transition: all 0.2s ease;
        }
        .category-card:hover {
            transform: translateY(-2px);
        }
        .category-card.selected {
            border-color: #4f46e5;
            background-color: #eef2ff;
        }
        .urgency-card {
            transition: all 0.2s ease;
        }
        .urgency-card:hover {
            transform: scale(1.02);
        }
        .urgency-card.selected {
            border-width: 2px;
        }
        .file-upload-zone {
            transition: all 0.2s ease;
        }
        .file-upload-zone.dragover {
            border-color: #4f46e5;
            background-color: #eef2ff;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">
    <x-navbar />

    <div class="min-h-screen py-8 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('recipient.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Dashboard
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8 sm:px-10">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">Submit Help Request</h1>
                    <p class="text-indigo-100 mt-2">Tell us about your situation so we can connect you with the right help</p>
                </div>

                <!-- Progress Steps -->
                <div class="px-6 py-6 sm:px-10 border-b border-gray-100 bg-gray-50">
                    <div class="flex items-center justify-between max-w-2xl mx-auto">
                        <!-- Step 1 -->
                        <div class="flex flex-col items-center step-indicator" data-step="1">
                            <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-lg" id="step1-circle">
                                1
                            </div>
                            <span class="text-xs mt-2 text-indigo-600 font-semibold hidden sm:block">Category</span>
                        </div>
                        
                        <div class="flex-1 h-1 mx-2 sm:mx-4 bg-gray-200 rounded" id="progress-1-2">
                            <div class="h-full bg-indigo-600 rounded transition-all duration-500" style="width: 0%"></div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex flex-col items-center step-indicator" data-step="2">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-sm" id="step2-circle">
                                2
                            </div>
                            <span class="text-xs mt-2 text-gray-500 font-medium hidden sm:block">Details</span>
                        </div>

                        <div class="flex-1 h-1 mx-2 sm:mx-4 bg-gray-200 rounded" id="progress-2-3">
                            <div class="h-full bg-indigo-600 rounded transition-all duration-500" style="width: 0%"></div>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex flex-col items-center step-indicator" data-step="3">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-sm" id="step3-circle">
                                3
                            </div>
                            <span class="text-xs mt-2 text-gray-500 font-medium hidden sm:block">Urgency</span>
                        </div>

                        <div class="flex-1 h-1 mx-2 sm:mx-4 bg-gray-200 rounded" id="progress-3-4">
                            <div class="h-full bg-indigo-600 rounded transition-all duration-500" style="width: 0%"></div>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex flex-col items-center step-indicator" data-step="4">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-sm" id="step4-circle">
                                4
                            </div>
                            <span class="text-xs mt-2 text-gray-500 font-medium hidden sm:block">Documents</span>
                        </div>

                        <div class="flex-1 h-1 mx-2 sm:mx-4 bg-gray-200 rounded" id="progress-4-5">
                            <div class="h-full bg-indigo-600 rounded transition-all duration-500" style="width: 0%"></div>
                        </div>

                        <!-- Step 5 -->
                        <div class="flex flex-col items-center step-indicator" data-step="5">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-sm" id="step5-circle">
                                5
                            </div>
                            <span class="text-xs mt-2 text-gray-500 font-medium hidden sm:block">Review</span>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mx-6 sm:mx-10 mt-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-red-800">Please fix the following errors:</h4>
                                <ul class="list-disc list-inside text-sm text-red-600 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('recipient.requests.store') }}" method="POST" enctype="multipart/form-data" id="helpRequestForm">
                    @csrf

                    <!-- Step 1: Category Selection -->
                    <div class="step-content active p-6 sm:p-10" id="step1">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">What type of help do you need?</h2>
                            <p class="text-gray-500 mt-2">Select the category that best describes your situation</p>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                            @forelse($categories as $category)
                                <label class="category-card cursor-pointer">
                                    <input type="radio" name="category" value="{{ $category->slug }}" class="hidden" {{ old('category') === $category->slug ? 'checked' : '' }}>
                                    <div class="border-2 border-gray-200 rounded-2xl p-4 sm:p-6 text-center hover:border-indigo-300 transition {{ old('category') === $category->slug ? 'border-indigo-600 bg-indigo-50' : '' }}">
                                        <div class="text-4xl mb-3">{{ $category->icon }}</div>
                                        <h3 class="font-semibold text-gray-800">{{ $category->name }}</h3>
                                        @if($category->description)
                                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($category->description, 30) }}</p>
                                        @endif
                                    </div>
                                </label>
                            @empty
                                <div class="col-span-full text-center py-8">
                                    <p class="text-gray-500">No categories available. Please contact the administrator.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="flex justify-end mt-8">
                            <button type="button" onclick="nextStep(1)" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg flex items-center">
                                Continue
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Details -->
                    <div class="step-content p-6 sm:p-10" id="step2">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">Tell us more about your situation</h2>
                            <p class="text-gray-500 mt-2">The more details you provide, the better we can help</p>
                        </div>

                        <div class="max-w-2xl mx-auto space-y-6">
                            <!-- Request Type -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    What type of help do you need? <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="request_type" value="money" class="hidden peer" {{ old('request_type', 'money') === 'money' ? 'checked' : '' }}>
                                        <div class="border-2 border-gray-200 rounded-xl p-4 text-center hover:border-green-300 transition peer-checked:border-green-500 peer-checked:bg-green-50">
                                            <span class="text-3xl block mb-2">💰</span>
                                            <span class="font-semibold text-gray-800">Money</span>
                                            <p class="text-xs text-gray-500 mt-1">Financial assistance</p>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="request_type" value="goods" class="hidden peer" {{ old('request_type') === 'goods' ? 'checked' : '' }}>
                                        <div class="border-2 border-gray-200 rounded-xl p-4 text-center hover:border-blue-300 transition peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                            <span class="text-3xl block mb-2">📦</span>
                                            <span class="font-semibold text-gray-800">Goods</span>
                                            <p class="text-xs text-gray-500 mt-1">Physical items needed</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Request Title <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="title" 
                                    name="title" 
                                    value="{{ old('title') }}"
                                    placeholder="e.g., Need help with school fees for my children"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                >
                                <p class="text-xs text-gray-500 mt-1">A brief, clear title for your request</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Describe Your Situation <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    rows="6"
                                    placeholder="Please describe your situation in detail:&#10;- What challenges are you facing?&#10;- How did this situation occur?&#10;- What specific help do you need?&#10;- How will this help improve your situation?"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"
                                >{{ old('description') }}</textarea>
                                <div class="flex justify-between items-center mt-1">
                                    <p class="text-xs text-gray-500">Minimum 50 characters required</p>
                                    <span id="charCount" class="text-xs text-gray-400">0 characters</span>
                                </div>
                            </div>

                            <!-- Amount Needed (Money type) -->
                            <div id="amountSection">
                                <label for="amount_needed" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Estimated Amount Needed (Optional)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">LKR</span>
                                    <input 
                                        type="number" 
                                        id="amount_needed" 
                                        name="amount_needed" 
                                        value="{{ old('amount_needed') }}"
                                        placeholder="0.00"
                                        min="0"
                                        step="100"
                                        class="w-full pl-14 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Leave empty if you're not sure or if it's not financial assistance</p>
                            </div>

                            <!-- Items Needed (Goods type) -->
                            <div id="itemsSection" style="display: none;">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Items Needed <span class="text-red-500">*</span>
                                </label>
                                <div id="itemsContainer" class="space-y-3">
                                    <!-- Items will be added dynamically -->
                                </div>
                                <button type="button" onclick="addItem()" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Item
                                </button>
                            </div>

                            <!-- Location Display -->
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Your Location</p>
                                        <p class="text-gray-900 font-semibold">{{ auth()->user()->recipientProfile->location ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between mt-8 max-w-2xl mx-auto">
                            <button type="button" onclick="prevStep(2)" class="px-6 py-3 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Back
                            </button>
                            <button type="button" onclick="nextStep(2)" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg flex items-center">
                                Continue
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Urgency -->
                    <div class="step-content p-6 sm:p-10" id="step3">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">How urgent is your need?</h2>
                            <p class="text-gray-500 mt-2">This helps us prioritize and respond appropriately</p>
                        </div>

                        <div class="max-w-2xl mx-auto space-y-4">
                            <label class="urgency-card cursor-pointer block">
                                <input type="radio" name="urgency" value="low" class="hidden" {{ old('urgency') === 'low' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-2xl p-5 hover:border-green-300 transition {{ old('urgency') === 'low' ? 'border-green-500 bg-green-50' : '' }}">
                                    <div class="flex items-center">
                                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                            <span class="text-2xl">🟢</span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-800 text-lg">Low Priority</h3>
                                            <p class="text-gray-500">Can wait for a month or more</p>
                                        </div>
                                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center urgency-check">
                                            <svg class="w-4 h-4 text-green-600 hidden" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="urgency-card cursor-pointer block">
                                <input type="radio" name="urgency" value="medium" class="hidden" {{ old('urgency', 'medium') === 'medium' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-2xl p-5 hover:border-yellow-300 transition {{ old('urgency', 'medium') === 'medium' ? 'border-yellow-500 bg-yellow-50' : '' }}">
                                    <div class="flex items-center">
                                        <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                                            <span class="text-2xl">🟡</span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-800 text-lg">Medium Priority</h3>
                                            <p class="text-gray-500">Need help within 2-4 weeks</p>
                                        </div>
                                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center urgency-check">
                                            <svg class="w-4 h-4 text-yellow-600 hidden" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="urgency-card cursor-pointer block">
                                <input type="radio" name="urgency" value="high" class="hidden" {{ old('urgency') === 'high' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-2xl p-5 hover:border-orange-300 transition {{ old('urgency') === 'high' ? 'border-orange-500 bg-orange-50' : '' }}">
                                    <div class="flex items-center">
                                        <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                                            <span class="text-2xl">🟠</span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-800 text-lg">High Priority</h3>
                                            <p class="text-gray-500">Need help within 1 week</p>
                                        </div>
                                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center urgency-check">
                                            <svg class="w-4 h-4 text-orange-600 hidden" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="urgency-card cursor-pointer block">
                                <input type="radio" name="urgency" value="critical" class="hidden" {{ old('urgency') === 'critical' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-200 rounded-2xl p-5 hover:border-red-300 transition {{ old('urgency') === 'critical' ? 'border-red-500 bg-red-50' : '' }}">
                                    <div class="flex items-center">
                                        <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                                            <span class="text-2xl">🔴</span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-800 text-lg">Critical - Emergency</h3>
                                            <p class="text-gray-500">Immediate assistance needed</p>
                                        </div>
                                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center urgency-check">
                                            <svg class="w-4 h-4 text-red-600 hidden" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="flex justify-between mt-8 max-w-2xl mx-auto">
                            <button type="button" onclick="prevStep(3)" class="px-6 py-3 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Back
                            </button>
                            <button type="button" onclick="nextStep(3)" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg flex items-center">
                                Continue
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Documents -->
                    <div class="step-content p-6 sm:p-10" id="step4">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">Upload Supporting Documents</h2>
                            <p class="text-gray-500 mt-2">Documents help verify your request and speed up the approval process</p>
                        </div>

                        <div class="max-w-2xl mx-auto">
                            <!-- Document Types Info -->
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-blue-800">Recommended documents:</h4>
                                        <ul class="text-sm text-blue-700 mt-1 space-y-1">
                                            <li>• National ID card or birth certificate</li>
                                            <li>• Medical reports or prescriptions (for healthcare)</li>
                                            <li>• School admission letters or fee receipts (for education)</li>
                                            <li>• Bills or invoices related to your request</li>
                                            <li>• Photos of your situation (if applicable)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Zone -->
                            <div 
                                class="file-upload-zone border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer"
                                id="dropZone"
                                ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)"
                                ondrop="handleDrop(event)"
                            >
                                <input 
                                    type="file" 
                                    id="documents" 
                                    name="documents[]" 
                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                    multiple
                                    class="hidden"
                                    onchange="handleFileSelect(this)"
                                >
                                <label for="documents" class="cursor-pointer">
                                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                    </div>
                                    <p class="font-semibold text-gray-700 mb-1">Drag & drop files here</p>
                                    <p class="text-sm text-gray-500 mb-3">or click to browse</p>
                                    <span class="inline-block px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700">
                                        Select Files
                                    </span>
                                </label>
                            </div>

                            <p class="text-xs text-gray-500 text-center mt-3">
                                Accepted formats: PDF, JPG, PNG, DOC, DOCX • Max 2MB per file • Up to 5 files
                            </p>

                            <!-- File List -->
                            <div id="fileList" class="mt-4 space-y-2"></div>

                            <p class="text-center text-sm text-gray-500 mt-6">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Documents are optional but help verify your request faster
                                </span>
                            </p>
                        </div>

                        <div class="flex justify-between mt-8 max-w-2xl mx-auto">
                            <button type="button" onclick="prevStep(4)" class="px-6 py-3 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Back
                            </button>
                            <button type="button" onclick="nextStep(4)" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg flex items-center">
                                Continue to Review
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 5: Review & Submit -->
                    <div class="step-content p-6 sm:p-10" id="step5">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">Review Your Request</h2>
                            <p class="text-gray-500 mt-2">Please verify all information before submitting</p>
                        </div>

                        <div class="max-w-2xl mx-auto">
                            <!-- Review Card -->
                            <div class="bg-gray-50 rounded-2xl p-6 space-y-6">
                                <!-- Category -->
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm text-gray-500">Category</p>
                                        <p class="font-semibold text-gray-900" id="review-category">-</p>
                                    </div>
                                    <button type="button" onclick="goToStep(1)" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Edit</button>
                                </div>

                                <hr class="border-gray-200">

                                <!-- Request Type -->
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm text-gray-500">Request Type</p>
                                        <p class="font-semibold text-gray-900" id="review-request-type">-</p>
                                    </div>
                                    <button type="button" onclick="goToStep(2)" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Edit</button>
                                </div>

                                <hr class="border-gray-200">

                                <!-- Title -->
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 mr-4">
                                        <p class="text-sm text-gray-500">Request Title</p>
                                        <p class="font-semibold text-gray-900" id="review-title">-</p>
                                    </div>
                                    <button type="button" onclick="goToStep(2)" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Edit</button>
                                </div>

                                <hr class="border-gray-200">

                                <!-- Description -->
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 mr-4">
                                        <p class="text-sm text-gray-500">Description</p>
                                        <p class="text-gray-900 whitespace-pre-line" id="review-description">-</p>
                                    </div>
                                    <button type="button" onclick="goToStep(2)" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Edit</button>
                                </div>

                                <hr class="border-gray-200">

                                <!-- Amount (money) -->
                                <div class="flex items-start justify-between" id="review-amount-row">
                                    <div>
                                        <p class="text-sm text-gray-500">Amount Needed</p>
                                        <p class="font-semibold text-gray-900" id="review-amount">Not specified</p>
                                    </div>
                                    <button type="button" onclick="goToStep(2)" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Edit</button>
                                </div>

                                <!-- Items (goods) -->
                                <div class="flex items-start justify-between" id="review-items-row" style="display: none;">
                                    <div class="flex-1 mr-4">
                                        <p class="text-sm text-gray-500">Items Needed</p>
                                        <div id="review-items" class="mt-1 space-y-1"></div>
                                    </div>
                                    <button type="button" onclick="goToStep(2)" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Edit</button>
                                </div>

                                <hr class="border-gray-200">

                                <!-- Urgency -->
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm text-gray-500">Urgency Level</p>
                                        <p class="font-semibold" id="review-urgency">-</p>
                                    </div>
                                    <button type="button" onclick="goToStep(3)" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Edit</button>
                                </div>

                                <hr class="border-gray-200">

                                <!-- Documents -->
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm text-gray-500">Documents</p>
                                        <p class="font-semibold text-gray-900" id="review-documents">No documents uploaded</p>
                                    </div>
                                    <button type="button" onclick="goToStep(4)" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Edit</button>
                                </div>

                                <hr class="border-gray-200">

                                <!-- Location -->
                                <div>
                                    <p class="text-sm text-gray-500">Location</p>
                                    <p class="font-semibold text-gray-900">{{ auth()->user()->recipientProfile->location ?? 'Not specified' }}</p>
                                </div>
                            </div>

                            <!-- Agreement -->
                            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" id="agreement" name="agreement" class="w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded mt-0.5 mr-3 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">
                                        I confirm that all information provided is accurate and truthful. I understand that providing false information may result in rejection of my request and possible account suspension.
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between mt-8 max-w-2xl mx-auto">
                            <button type="button" onclick="prevStep(5)" class="px-6 py-3 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Back
                            </button>
                            <button 
                                type="submit" 
                                id="submitBtn"
                                class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition shadow-lg flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Submit Request
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 5;
        let itemCounter = 0;

        // Category labels from database (passed via Blade)
        const categoryLabels = {
            @foreach($categories as $category)
                '{{ $category->slug }}': '{{ $category->icon }} {{ $category->name }}',
            @endforeach
        };

        // Urgency labels and colors
        const urgencyLabels = {
            'low': { label: '🟢 Low Priority', color: 'text-green-600' },
            'medium': { label: '🟡 Medium Priority', color: 'text-yellow-600' },
            'high': { label: '🟠 High Priority', color: 'text-orange-600' },
            'critical': { label: '🔴 Critical - Emergency', color: 'text-red-600' }
        };

        // Request type toggle
        function toggleRequestType() {
            const requestType = document.querySelector('input[name="request_type"]:checked');
            const amountSection = document.getElementById('amountSection');
            const itemsSection = document.getElementById('itemsSection');
            
            if (requestType && requestType.value === 'goods') {
                amountSection.style.display = 'none';
                itemsSection.style.display = 'block';
                if (document.getElementById('itemsContainer').children.length === 0) {
                    addItem();
                }
            } else {
                amountSection.style.display = 'block';
                itemsSection.style.display = 'none';
            }
        }

        function addItem() {
            itemCounter++;
            const container = document.getElementById('itemsContainer');
            const row = document.createElement('div');
            row.className = 'flex gap-3 items-start bg-gray-50 rounded-xl p-4 border border-gray-200';
            row.id = `item-row-${itemCounter}`;
            row.innerHTML = `
                <div class="flex-1 space-y-2">
                    <input type="text" name="items[${itemCounter}][item_name]" placeholder="Item name (e.g., Rice, Textbooks)" 
                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                    <div class="flex gap-2">
                        <input type="number" name="items[${itemCounter}][quantity]" placeholder="Qty" min="1" value="1"
                            class="w-24 px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                        <input type="text" name="items[${itemCounter}][notes]" placeholder="Notes (optional, e.g., size, brand)" 
                            class="flex-1 px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>
                </div>
                <button type="button" onclick="removeItem(${itemCounter})" class="mt-1 p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            `;
            container.appendChild(row);
        }

        function removeItem(id) {
            const row = document.getElementById(`item-row-${id}`);
            if (row) {
                row.remove();
                if (document.getElementById('itemsContainer').children.length === 0) {
                    addItem();
                }
            }
        }

        function updateProgressBar() {
            for (let i = 1; i <= totalSteps; i++) {
                const circle = document.getElementById(`step${i}-circle`);
                const label = circle.nextElementSibling;
                
                if (i < currentStep) {
                    circle.className = 'w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold text-sm shadow-lg';
                    circle.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
                    if (label) label.className = 'text-xs mt-2 text-green-600 font-semibold hidden sm:block';
                } else if (i === currentStep) {
                    circle.className = 'w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-lg';
                    circle.innerHTML = i;
                    if (label) label.className = 'text-xs mt-2 text-indigo-600 font-semibold hidden sm:block';
                } else {
                    circle.className = 'w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-sm';
                    circle.innerHTML = i;
                    if (label) label.className = 'text-xs mt-2 text-gray-500 font-medium hidden sm:block';
                }
            }

            // Update progress lines
            for (let i = 1; i < totalSteps; i++) {
                const progressLine = document.getElementById(`progress-${i}-${i+1}`);
                if (progressLine) {
                    const inner = progressLine.querySelector('div');
                    if (i < currentStep) {
                        inner.style.width = '100%';
                    } else {
                        inner.style.width = '0%';
                    }
                }
            }
        }

        function showStep(step) {
            document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
            document.getElementById(`step${step}`).classList.add('active');
            currentStep = step;
            updateProgressBar();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateStep(step) {
            switch (step) {
                case 1:
                    const category = document.querySelector('input[name="category"]:checked');
                    if (!category) {
                        alert('Please select a category for your help request.');
                        return false;
                    }
                    return true;
                case 2:
                    const title = document.getElementById('title').value.trim();
                    const description = document.getElementById('description').value.trim();
                    if (!title) {
                        alert('Please enter a title for your request.');
                        return false;
                    }
                    if (!description || description.length < 50) {
                        alert('Please provide a detailed description (minimum 50 characters).');
                        return false;
                    }
                    return true;
                case 3:
                    const urgency = document.querySelector('input[name="urgency"]:checked');
                    if (!urgency) {
                        alert('Please select an urgency level.');
                        return false;
                    }
                    return true;
                case 4:
                    return true; // Documents are optional
                default:
                    return true;
            }
        }

        function nextStep(currentStepNum) {
            if (!validateStep(currentStepNum)) return;
            
            if (currentStepNum < totalSteps) {
                showStep(currentStepNum + 1);
                if (currentStepNum + 1 === 5) {
                    updateReviewSection();
                }
            }
        }

        function prevStep(currentStepNum) {
            if (currentStepNum > 1) {
                showStep(currentStepNum - 1);
            }
        }

        function goToStep(step) {
            showStep(step);
        }

        function updateReviewSection() {
            // Category
            const category = document.querySelector('input[name="category"]:checked');
            document.getElementById('review-category').textContent = category ? categoryLabels[category.value] : '-';

            // Request Type
            const requestType = document.querySelector('input[name="request_type"]:checked');
            const rtEl = document.getElementById('review-request-type');
            if (requestType) {
                rtEl.textContent = requestType.value === 'money' ? '💰 Money' : '📦 Goods';
            }

            // Title
            const title = document.getElementById('title').value.trim();
            document.getElementById('review-title').textContent = title || '-';

            // Description
            const description = document.getElementById('description').value.trim();
            document.getElementById('review-description').textContent = description || '-';

            // Amount / Items based on type
            const reviewAmountRow = document.getElementById('review-amount-row');
            const reviewItemsRow = document.getElementById('review-items-row');
            
            if (requestType && requestType.value === 'goods') {
                reviewAmountRow.style.display = 'none';
                reviewItemsRow.style.display = 'flex';
                
                const itemsContainer = document.getElementById('itemsContainer');
                const reviewItems = document.getElementById('review-items');
                reviewItems.innerHTML = '';
                
                itemsContainer.querySelectorAll('[id^="item-row-"]').forEach(row => {
                    const name = row.querySelector('input[name*="item_name"]').value;
                    const qty = row.querySelector('input[name*="quantity"]').value;
                    const notes = row.querySelector('input[name*="notes"]').value;
                    if (name) {
                        const div = document.createElement('div');
                        div.className = 'flex items-center justify-between bg-blue-50 rounded-lg px-3 py-2';
                        div.innerHTML = `<span class="text-sm font-medium text-gray-900">${name}${notes ? ' <span class="text-gray-500">(' + notes + ')</span>' : ''}</span><span class="text-xs font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">× ${qty}</span>`;
                        reviewItems.appendChild(div);
                    }
                });
            } else {
                reviewAmountRow.style.display = 'flex';
                reviewItemsRow.style.display = 'none';
                const amount = document.getElementById('amount_needed').value;
                document.getElementById('review-amount').textContent = amount ? `LKR ${parseFloat(amount).toLocaleString()}` : 'Not specified';
            }

            // Urgency
            const urgency = document.querySelector('input[name="urgency"]:checked');
            if (urgency) {
                const urgencyEl = document.getElementById('review-urgency');
                urgencyEl.textContent = urgencyLabels[urgency.value].label;
                urgencyEl.className = `font-semibold ${urgencyLabels[urgency.value].color}`;
            }

            // Documents
            const fileInput = document.getElementById('documents');
            const fileCount = fileInput.files.length;
            document.getElementById('review-documents').textContent = fileCount > 0 ? `${fileCount} file(s) attached` : 'No documents uploaded';
        }

        // Category card selection
        document.querySelectorAll('.category-card input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.category-card > div').forEach(card => {
                    card.classList.remove('border-indigo-600', 'bg-indigo-50');
                    card.classList.add('border-gray-200');
                });
                if (this.checked) {
                    this.nextElementSibling.classList.remove('border-gray-200');
                    this.nextElementSibling.classList.add('border-indigo-600', 'bg-indigo-50');
                }
            });
        });

        // Urgency card selection
        document.querySelectorAll('.urgency-card input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.urgency-card > div').forEach(card => {
                    card.classList.remove('border-green-500', 'bg-green-50', 'border-yellow-500', 'bg-yellow-50', 'border-orange-500', 'bg-orange-50', 'border-red-500', 'bg-red-50');
                    card.classList.add('border-gray-200');
                    card.querySelector('.urgency-check svg').classList.add('hidden');
                });
                if (this.checked) {
                    const colors = {
                        'low': ['border-green-500', 'bg-green-50'],
                        'medium': ['border-yellow-500', 'bg-yellow-50'],
                        'high': ['border-orange-500', 'bg-orange-50'],
                        'critical': ['border-red-500', 'bg-red-50']
                    };
                    this.nextElementSibling.classList.remove('border-gray-200');
                    this.nextElementSibling.classList.add(...colors[this.value]);
                    this.nextElementSibling.querySelector('.urgency-check svg').classList.remove('hidden');
                }
            });
        });

        // Character count for description
        document.getElementById('description').addEventListener('input', function() {
            document.getElementById('charCount').textContent = this.value.length + ' characters';
        });

        // Agreement checkbox
        document.getElementById('agreement').addEventListener('change', function() {
            document.getElementById('submitBtn').disabled = !this.checked;
        });

        // File handling
        function handleFileSelect(input) {
            const files = Array.from(input.files);
            if (files.length > 5) {
                alert('You can only upload up to 5 files.');
                input.value = '';
                return;
            }
            updateFileList(files);
        }

        function handleDragOver(e) {
            e.preventDefault();
            document.getElementById('dropZone').classList.add('dragover');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            document.getElementById('dropZone').classList.remove('dragover');
        }

        function handleDrop(e) {
            e.preventDefault();
            document.getElementById('dropZone').classList.remove('dragover');
            
            const files = Array.from(e.dataTransfer.files);
            if (files.length > 5) {
                alert('You can only upload up to 5 files.');
                return;
            }

            const input = document.getElementById('documents');
            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
            
            updateFileList(files);
        }

        function updateFileList(files) {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';

            files.forEach((file, index) => {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between bg-white border border-gray-200 rounded-xl p-3';
                fileItem.innerHTML = `
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 text-sm">${file.name}</p>
                            <p class="text-xs text-gray-500">${fileSize} MB</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile(${index})" class="text-gray-400 hover:text-red-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                `;
                fileList.appendChild(fileItem);
            });
        }

        function removeFile(index) {
            const input = document.getElementById('documents');
            const dataTransfer = new DataTransfer();
            const files = Array.from(input.files);
            
            files.forEach((file, i) => {
                if (i !== index) {
                    dataTransfer.items.add(file);
                }
            });
            
            input.files = dataTransfer.files;
            updateFileList(Array.from(dataTransfer.files));
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Request type toggle listeners
            document.querySelectorAll('input[name="request_type"]').forEach(input => {
                input.addEventListener('change', toggleRequestType);
            });
            toggleRequestType();

            // Trigger change events for pre-selected values (from old input)
            document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
                input.dispatchEvent(new Event('change'));
            });
            
            // Initialize character count
            const descInput = document.getElementById('description');
            if (descInput.value) {
                document.getElementById('charCount').textContent = descInput.value.length + ' characters';
            }
        });
    </script>
</body>
</html>
