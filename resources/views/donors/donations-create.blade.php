<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Make a Donation - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Link -->
            <div class="mb-6">
                <a href="{{ route('donor.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    ← Back to Dashboard
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white">Make a Donation</h1>
                    <p class="text-orange-100 mt-1">
                        @if($ngoPost)
                            Donating to: {{ $ngoPost->title }}
                        @else
                            Direct Donation - Support those in need
                        @endif
                    </p>
                </div>

                <!-- Form -->
                <form action="{{ route('donor.donations.store') }}" method="POST" class="p-8" 
                    x-data="{ 
                        donationType: '{{ old('donation_type', 'money') }}',
                        items: [{ item_name: '', quantity: 1, notes: '' }],
                        addItem() {
                            this.items.push({ item_name: '', quantity: 1, notes: '' });
                        },
                        removeItem(index) {
                            if (this.items.length > 1) {
                                this.items.splice(index, 1);
                            }
                        }
                    }">
                    @csrf

                    @if($ngoPost)
                        <input type="hidden" name="ngo_post_id" value="{{ $ngoPost->id }}">
                        
                        <!-- NGO Post Info -->
                        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <span class="text-2xl mr-3">📋</span>
                                <div>
                                    <h3 class="font-semibold text-blue-900">{{ $ngoPost->title }}</h3>
                                    <p class="text-sm text-blue-700 mt-1">{{ Str::limit($ngoPost->description, 120) }}</p>
                                    @if($ngoPost->goal_amount)
                                        <p class="text-sm font-medium text-blue-800 mt-1">Goal: Rs. {{ number_format($ngoPost->goal_amount, 2) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Donation Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Donation Type *</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative cursor-pointer" @click="donationType = 'money'">
                                <input type="radio" name="donation_type" value="money" class="sr-only peer" 
                                    :checked="donationType === 'money'">
                                <div class="border-2 rounded-xl p-4 text-center transition peer-checked:border-green-500 peer-checked:bg-green-50"
                                    :class="donationType === 'money' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300'">
                                    <span class="text-3xl block mb-2">💰</span>
                                    <span class="font-semibold text-gray-900">Money</span>
                                    <p class="text-xs text-gray-500 mt-1">Monetary donation</p>
                                </div>
                            </label>
                            <label class="relative cursor-pointer" @click="donationType = 'goods'">
                                <input type="radio" name="donation_type" value="goods" class="sr-only peer"
                                    :checked="donationType === 'goods'">
                                <div class="border-2 rounded-xl p-4 text-center transition peer-checked:border-blue-500 peer-checked:bg-blue-50"
                                    :class="donationType === 'goods' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300'">
                                    <span class="text-3xl block mb-2">📦</span>
                                    <span class="font-semibold text-gray-900">Goods</span>
                                    <p class="text-xs text-gray-500 mt-1">Donate items/materials</p>
                                </div>
                            </label>
                        </div>
                        @error('donation_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Money Fields -->
                    <div x-show="donationType === 'money'" x-transition class="mb-6">
                        <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Amount (Rs.) *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-medium">Rs.</span>
                            <input type="number" name="amount" id="amount" step="0.01" min="1"
                                value="{{ old('amount') }}"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                placeholder="Enter donation amount">
                        </div>
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Quick Amount Buttons -->
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach([500, 1000, 2500, 5000, 10000] as $quickAmount)
                                <button type="button" 
                                    @click="document.getElementById('amount').value = {{ $quickAmount }}"
                                    class="px-4 py-2 text-sm border border-gray-300 rounded-full hover:bg-orange-50 hover:border-orange-300 transition">
                                    Rs. {{ number_format($quickAmount) }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Payment Method -->
                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Payment Method *</label>
                            <div class="grid grid-cols-2 gap-4" x-data="{ paymentMethod: '{{ old('payment_method', '') }}' }">
                                <label class="relative cursor-pointer" @click="paymentMethod = 'pickup'">
                                    <input type="radio" name="payment_method" value="pickup" class="sr-only peer"
                                        :checked="paymentMethod === 'pickup'">
                                    <div class="border-2 rounded-xl p-4 text-center transition"
                                        :class="paymentMethod === 'pickup' ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-gray-300'">
                                        <span class="text-3xl block mb-2">🚗</span>
                                        <span class="font-semibold text-gray-900">Pickup</span>
                                        <p class="text-xs text-gray-500 mt-1">Our team will collect the money from you</p>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer" @click="paymentMethod = 'online'">
                                    <input type="radio" name="payment_method" value="online" class="sr-only peer"
                                        :checked="paymentMethod === 'online'">
                                    <div class="border-2 rounded-xl p-4 text-center transition"
                                        :class="paymentMethod === 'online' ? 'border-teal-500 bg-teal-50' : 'border-gray-200 hover:border-gray-300'">
                                        <span class="text-3xl block mb-2">💳</span>
                                        <span class="font-semibold text-gray-900">Online Pay</span>
                                        <p class="text-xs text-gray-500 mt-1">Transfer the money online / bank transfer</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Goods Items Fields -->
                    <div x-show="donationType === 'goods'" x-transition class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Goods Items *</label>

                        @error('items')
                            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                        @enderror

                        <div class="space-y-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <!-- Item Name -->
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-gray-500 mb-1" x-text="'Item #' + (index + 1)"></label>
                                        <input type="text"
                                            :name="'items[' + index + '][item_name]'"
                                            x-model="item.item_name"
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="e.g., Rice bags, Shirts, Books">
                                        <template x-if="$el.closest('form')?.querySelector('[name=errors]')">
                                            <p class="text-red-500 text-xs mt-1"></p>
                                        </template>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="w-24">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Qty</label>
                                        <input type="number"
                                            :name="'items[' + index + '][quantity]'"
                                            x-model="item.quantity"
                                            min="1"
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="1">
                                    </div>

                                    <!-- Notes -->
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Notes</label>
                                        <input type="text"
                                            :name="'items[' + index + '][notes]'"
                                            x-model="item.notes"
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="Optional">
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="pt-5">
                                        <button type="button" @click="removeItem(index)"
                                            x-show="items.length > 1"
                                            class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Add Item Button -->
                        <button type="button" @click="addItem()"
                            class="mt-3 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Another Item
                        </button>

                        @error('items.*.item_name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                        @error('items.*.quantity')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label for="donor_notes" class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea name="donor_notes" id="donor_notes" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                            placeholder="Any additional notes about your donation...">{{ old('donor_notes') }}</textarea>
                        @error('donor_notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('donor.dashboard') }}" class="text-gray-500 hover:text-gray-700 font-medium">Cancel</a>
                        <button type="submit" class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-8 py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-yellow-600 transition shadow-lg">
                            Submit Donation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
