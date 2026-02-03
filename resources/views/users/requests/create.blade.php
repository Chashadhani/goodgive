@extends('layouts.app')

@section('title', 'Submit Help Request')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('recipient.requests.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to My Requests
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Submit Help Request</h1>
            <p class="text-gray-600 mt-1">Tell us about your situation and how we can help</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('recipient.requests.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

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
                    placeholder="Brief title for your request (e.g., Medical Treatment Support)"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('title') border-red-500 @enderror"
                >
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        Category of Need <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="category" 
                        name="category"
                        required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('category') border-red-500 @enderror"
                    >
                        <option value="">Select category</option>
                        <option value="education" {{ old('category') === 'education' ? 'selected' : '' }}>Education</option>
                        <option value="healthcare" {{ old('category') === 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="shelter" {{ old('category') === 'shelter' ? 'selected' : '' }}>Shelter</option>
                        <option value="food" {{ old('category') === 'food' ? 'selected' : '' }}>Food Security</option>
                        <option value="clothing" {{ old('category') === 'clothing' ? 'selected' : '' }}>Clothing</option>
                        <option value="emergency" {{ old('category') === 'emergency' ? 'selected' : '' }}>Emergency Relief</option>
                        <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Urgency -->
                <div>
                    <label for="urgency" class="block text-sm font-semibold text-gray-700 mb-2">
                        Urgency Level <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="urgency" 
                        name="urgency"
                        required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('urgency') border-red-500 @enderror"
                    >
                        <option value="">Select urgency</option>
                        <option value="low" {{ old('urgency') === 'low' ? 'selected' : '' }}>Low - Can wait</option>
                        <option value="medium" {{ old('urgency') === 'medium' ? 'selected' : '' }}>Medium - Within 2 weeks</option>
                        <option value="high" {{ old('urgency') === 'high' ? 'selected' : '' }}>High - Within a week</option>
                        <option value="critical" {{ old('urgency') === 'critical' ? 'selected' : '' }}>Critical - Immediate need</option>
                    </select>
                </div>
            </div>

            <!-- Amount Needed (Optional) -->
            <div>
                <label for="amount_needed" class="block text-sm font-semibold text-gray-700 mb-2">
                    Amount Needed (Optional)
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-gray-500">LKR</span>
                    <input 
                        type="number" 
                        id="amount_needed" 
                        name="amount_needed" 
                        value="{{ old('amount_needed') }}"
                        placeholder="0.00"
                        min="0"
                        step="0.01"
                        class="w-full pl-14 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('amount_needed') border-red-500 @enderror"
                    >
                </div>
                <p class="text-xs text-gray-500 mt-1">Leave empty if you're not sure or it's not monetary assistance</p>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Description of Your Situation <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="6"
                    required
                    minlength="50"
                    placeholder="Please describe your situation in detail. Include information about your current circumstances, what kind of help you need, and how it would benefit you. (Minimum 50 characters)"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none @error('description') border-red-500 @enderror"
                >{{ old('description') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Minimum 50 characters. Be as detailed as possible.</p>
            </div>

            <!-- Documents -->
            <div>
                <label for="documents" class="block text-sm font-semibold text-gray-700 mb-2">
                    Supporting Documents (Optional)
                </label>
                <p class="text-xs text-gray-500 mb-3">Upload proof documents (ID card, medical reports, bills, etc.)</p>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer">
                    <input 
                        type="file" 
                        id="documents" 
                        name="documents[]" 
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                        multiple
                        class="hidden"
                        onchange="updateFileList(this)"
                    >
                    <label for="documents" class="cursor-pointer">
                        <div class="text-4xl mb-2">📄</div>
                        <p class="font-semibold text-gray-700 mb-1">Upload Documents</p>
                        <p class="text-xs text-gray-500">PDF, JPG, PNG, DOC (Max 5MB each, up to 5 files)</p>
                    </label>
                </div>
                <div id="file-list" class="mt-3 space-y-2"></div>
            </div>

            <!-- Location Info -->
            <div class="bg-gray-50 rounded-xl p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm text-gray-700">
                        <strong>Location:</strong> {{ auth()->user()->recipientProfile->location ?? 'Not specified' }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-2">Your location from your profile will be used. Update your profile if needed.</p>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('recipient.requests.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg"
                >
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateFileList(input) {
        const fileList = document.getElementById('file-list');
        fileList.innerHTML = '';
        
        if (input.files.length > 0) {
            if (input.files.length > 5) {
                alert('You can only upload up to 5 files.');
                input.value = '';
                return;
            }
            
            Array.from(input.files).forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between bg-indigo-50 rounded-lg px-3 py-2 text-sm';
                fileItem.innerHTML = `
                    <span class="text-indigo-700 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                        ${file.name}
                    </span>
                    <span class="text-gray-500">${(file.size / 1024).toFixed(1)} KB</span>
                `;
                fileList.appendChild(fileItem);
            });
        }
    }
</script>
@endsection
