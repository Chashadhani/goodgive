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

        <form action="{{ route('recipient.requests.update', $helpRequest) }}" method="POST" enctype="multipart/form-data" class="space-y-6"
              x-data="{
                  requestType: '{{ old('request_type', $helpRequest->request_type ?? 'money') }}',
                  items: {{ old('request_type') ? '[]' : $helpRequest->items->map(fn($i) => ['item_name' => $i->item_name, 'quantity' => $i->quantity, 'notes' => $i->notes])->toJson() }},
                  addItem() { this.items.push({ item_name: '', quantity: 1, notes: '' }); },
                  removeItem(index) { this.items.splice(index, 1); if (this.items.length === 0) this.addItem(); }
              }"
              x-init="if (requestType === 'goods' && items.length === 0) addItem()">
            @csrf
            @method('PUT')

            <!-- Request Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Request Type <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="request_type" value="money" class="hidden peer" x-model="requestType">
                        <div class="border-2 border-gray-200 rounded-xl p-4 text-center hover:border-green-300 transition peer-checked:border-green-500 peer-checked:bg-green-50">
                            <span class="text-3xl block mb-2">💰</span>
                            <span class="font-semibold text-gray-800">Money</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="request_type" value="goods" class="hidden peer" x-model="requestType">
                        <div class="border-2 border-gray-200 rounded-xl p-4 text-center hover:border-blue-300 transition peer-checked:border-blue-500 peer-checked:bg-blue-50">
                            <span class="text-3xl block mb-2">📦</span>
                            <span class="font-semibold text-gray-800">Goods</span>
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
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ old('category', $helpRequest->category) === $category->slug ? 'selected' : '' }}>
                                {{ $category->icon }} {{ $category->name }}
                            </option>
                        @endforeach
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

            <!-- Amount Needed (Money) -->
            <div x-show="requestType === 'money'" x-transition>
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

            <!-- Items Needed (Goods) -->
            <div x-show="requestType === 'goods'" x-transition>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Items Needed <span class="text-red-500">*</span>
                </label>
                <div class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex gap-3 items-start bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex-1 space-y-2">
                                <input type="text" :name="'items['+index+'][item_name]'" x-model="item.item_name" placeholder="Item name" 
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <div class="flex gap-2">
                                    <input type="number" :name="'items['+index+'][quantity]'" x-model="item.quantity" min="1" placeholder="Qty"
                                        class="w-24 px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <input type="text" :name="'items['+index+'][notes]'" x-model="item.notes" placeholder="Notes (optional)"
                                        class="flex-1 px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>
                            </div>
                            <button type="button" @click="removeItem(index)" class="mt-1 p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
                <button type="button" @click="addItem()" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Item
                </button>
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
