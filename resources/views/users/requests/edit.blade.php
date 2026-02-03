@extends('layouts.app')

@section('title', 'Edit Help Request')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('recipient.requests.show', $helpRequest) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Request
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Help Request</h1>
            <p class="text-gray-600 mt-1">Update your help request details</p>
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

        <form action="{{ route('recipient.requests.update', $helpRequest) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                    Request Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $helpRequest->title) }}"
                    placeholder="Brief title for your request"
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
                        <option value="education" {{ old('category', $helpRequest->category) === 'education' ? 'selected' : '' }}>Education</option>
                        <option value="healthcare" {{ old('category', $helpRequest->category) === 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="shelter" {{ old('category', $helpRequest->category) === 'shelter' ? 'selected' : '' }}>Shelter</option>
                        <option value="food" {{ old('category', $helpRequest->category) === 'food' ? 'selected' : '' }}>Food Security</option>
                        <option value="clothing" {{ old('category', $helpRequest->category) === 'clothing' ? 'selected' : '' }}>Clothing</option>
                        <option value="emergency" {{ old('category', $helpRequest->category) === 'emergency' ? 'selected' : '' }}>Emergency Relief</option>
                        <option value="other" {{ old('category', $helpRequest->category) === 'other' ? 'selected' : '' }}>Other</option>
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
                        <option value="low" {{ old('urgency', $helpRequest->urgency) === 'low' ? 'selected' : '' }}>Low - Can wait</option>
                        <option value="medium" {{ old('urgency', $helpRequest->urgency) === 'medium' ? 'selected' : '' }}>Medium - Within 2 weeks</option>
                        <option value="high" {{ old('urgency', $helpRequest->urgency) === 'high' ? 'selected' : '' }}>High - Within a week</option>
                        <option value="critical" {{ old('urgency', $helpRequest->urgency) === 'critical' ? 'selected' : '' }}>Critical - Immediate need</option>
                    </select>
                </div>
            </div>

            <!-- Amount Needed -->
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
                        value="{{ old('amount_needed', $helpRequest->amount_needed) }}"
                        placeholder="0.00"
                        min="0"
                        step="0.01"
                        class="w-full pl-14 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('amount_needed') border-red-500 @enderror"
                    >
                </div>
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
                    placeholder="Please describe your situation in detail..."
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none @error('description') border-red-500 @enderror"
                >{{ old('description', $helpRequest->description) }}</textarea>
            </div>

            <!-- Existing Documents -->
            @if($helpRequest->documents)
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Current Documents</h3>
                    <div class="space-y-2">
                        @foreach(json_decode($helpRequest->documents, true) as $document)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-gray-700">{{ basename($document) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Add More Documents -->
            <div>
                <label for="documents" class="block text-sm font-semibold text-gray-700 mb-2">
                    Add More Documents
                </label>
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
                        <p class="font-semibold text-gray-700 mb-1">Add More Documents</p>
                        <p class="text-xs text-gray-500">PDF, JPG, PNG, DOC (Max 5MB each)</p>
                    </label>
                </div>
                <div id="file-list" class="mt-3 space-y-2"></div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('recipient.requests.show', $helpRequest) }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg"
                >
                    Update Request
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
