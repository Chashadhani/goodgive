@extends('admin.layouts.app')

@section('title', 'Allocate Stock')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.allocations.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Allocations
    </a>
</div>

<h1 class="text-3xl font-bold text-gray-900 mb-2">Allocate from Stock</h1>
<p class="text-gray-600 mb-8">Assign confirmed donations to NGO posts or help requests.</p>

@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.allocations.store') }}" method="POST" x-data="{
    targetType: '{{ $targetType ?? '' }}',
    targetId: '{{ $targetId ?? '' }}',
    allocationType: '{{ $needsType ?? '' }}',
    selectedDonationId: '',

    get effectiveType() {
        return '{{ $needsType }}' || this.allocationType;
    },

    onTargetSelected(event) {
        const option = event.target.options[event.target.selectedIndex];
        if (option) {
            const type = option.getAttribute('data-type');
            if (type) {
                this.allocationType = type;
            }
        }
    }
}" class="space-y-8">
    @csrf

    <!-- Step 1: Select Target -->
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm">1</div>
            <h2 class="text-xl font-bold text-gray-900">Select Target</h2>
        </div>

        @if($target)
            <!-- Pre-selected target -->
            <input type="hidden" name="target_type" value="{{ $targetType }}">
            <input type="hidden" name="target_id" value="{{ $targetId }}">
            <div class="border-2 border-indigo-200 bg-indigo-50 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">
                            {{ $targetType === 'ngo_post' ? '📝 NGO Post' : '🆘 Help Request' }}
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 mt-1">{{ $target->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($target->description, 100) }}</p>
                    </div>
                    <div class="text-right">
                        @if($target->isMoney())
                            <span class="px-3 py-1 bg-green-100 text-green-700 font-semibold text-sm rounded-full">💰 Money</span>
                            @if($target->goal_amount ?? $target->amount_needed)
                                <p class="text-sm text-gray-600 mt-2">Needs: Rs. {{ number_format($target->goal_amount ?? $target->amount_needed) }}</p>
                            @endif
                        @else
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 font-semibold text-sm rounded-full">📦 Goods</span>
                            @if($target->items->count())
                                <p class="text-sm text-gray-600 mt-2">{{ $target->items->count() }} items needed</p>
                            @endif
                        @endif
                    </div>
                </div>

                @if($target->isGoods() && $target->items->count())
                    <div class="mt-4 pt-4 border-t border-indigo-200">
                        <p class="text-xs text-indigo-600 font-semibold mb-2">Items Needed:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($target->items as $item)
                                <span class="px-3 py-1 bg-white text-gray-700 text-sm rounded-lg border border-indigo-200">
                                    {{ $item->item_name }} × {{ $item->quantity }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @else
            <!-- Choose target -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Type</label>
                    <select x-model="targetType" name="target_type" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                        <option value="">-- Select Target Type --</option>
                        <option value="ngo_post">📝 NGO Post</option>
                        <option value="help_request">🆘 Help Request</option>
                    </select>
                </div>

                <!-- NGO Posts List -->
                <div x-show="targetType === 'ngo_post'" x-cloak>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select NGO Post</label>
                    <select name="target_id" x-model="targetId" @change="onTargetSelected($event)" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" :required="targetType === 'ngo_post'">
                        <option value="">-- Choose a post --</option>
                        @foreach($ngoPostsNeedingHelp as $post)
                            <option value="{{ $post->id }}" data-type="{{ $post->request_type }}">
                                {{ $post->title }} ({{ $post->request_type === 'money' ? 'Money - Rs.' . number_format($post->goal_amount ?? 0) : 'Goods - ' . $post->total_items_count . ' items' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Help Requests List -->
                <div x-show="targetType === 'help_request'" x-cloak>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Help Request</label>
                    <select name="target_id" x-model="targetId" @change="onTargetSelected($event)" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" :required="targetType === 'help_request'">
                        <option value="">-- Choose a request --</option>
                        @foreach($helpRequestsNeedingHelp as $req)
                            <option value="{{ $req->id }}" data-type="{{ $req->request_type }}">
                                {{ $req->title }} ({{ $req->request_type === 'money' ? 'Money - Rs.' . number_format($req->amount_needed ?? 0) : 'Goods - ' . $req->total_items_count . ' items' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
    </div>

    <!-- Step 2: Allocation Type -->
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm">2</div>
            <h2 class="text-xl font-bold text-gray-900">Select Allocation Type</h2>
        </div>

        @if($needsType)
            <input type="hidden" name="allocation_type" value="{{ $needsType }}">
            <div class="text-center py-4">
                @if($needsType === 'money')
                    <span class="text-5xl block mb-3">💰</span>
                    <p class="text-lg font-semibold text-gray-900">Money Allocation</p>
                    <p class="text-gray-500 text-sm">This target needs monetary donations.</p>
                @else
                    <span class="text-5xl block mb-3">📦</span>
                    <p class="text-lg font-semibold text-gray-900">Goods Allocation</p>
                    <p class="text-gray-500 text-sm">This target needs physical goods.</p>
                @endif
            </div>
        @else
            <div class="grid grid-cols-2 gap-4">
                <label class="cursor-pointer">
                    <input type="radio" name="allocation_type" value="money" x-model="allocationType" class="sr-only peer">
                    <div class="border-2 rounded-xl p-6 text-center peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:border-gray-400 transition">
                        <span class="text-4xl block mb-2">💰</span>
                        <p class="font-semibold text-gray-900">Money</p>
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="allocation_type" value="goods" x-model="allocationType" class="sr-only peer">
                    <div class="border-2 rounded-xl p-6 text-center peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:border-gray-400 transition">
                        <span class="text-4xl block mb-2">📦</span>
                        <p class="font-semibold text-gray-900">Goods</p>
                    </div>
                </label>
            </div>
        @endif
    </div>

    <!-- Step 3: Select from Stock -->
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm">3</div>
            <h2 class="text-xl font-bold text-gray-900">Select from Available Stock</h2>
        </div>

        @php
            $moneyDonations = $availableDonations->where('donation_type', 'money');
            $goodsDonations = $availableDonations->where('donation_type', 'goods');
        @endphp

        <!-- Money Stock Selection -->
        <div x-show="effectiveType === 'money'" x-cloak>
            @if($moneyDonations->count() > 0)
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Donor's Money Donation</label>
                    @foreach($moneyDonations as $donation)
                        <label class="cursor-pointer block">
                            <input type="radio" name="donation_id" value="{{ $donation->id }}" class="sr-only peer" x-model="selectedDonationId">
                            <div class="border-2 rounded-xl p-5 peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-400 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="text-green-600 font-bold">{{ strtoupper(substr($donation->user->name, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $donation->user->name }}</p>
                                            <p class="text-sm text-gray-500">Donation #{{ $donation->id }} · {{ $donation->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-green-600">Rs. {{ number_format($donation->remaining_amount) }}</p>
                                        <p class="text-xs text-gray-500">of Rs. {{ number_format($donation->amount) }} remaining</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amount to Allocate (Rs.)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" placeholder="Enter amount..." 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-lg font-semibold">
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <span class="text-4xl block mb-3">🏦</span>
                    <p class="font-semibold">No money donations available in stock</p>
                    <p class="text-sm mt-1">All confirmed money donations have been fully allocated.</p>
                </div>
            @endif
        </div>

        <!-- Goods Stock Selection -->
        <div x-show="effectiveType === 'goods'" x-cloak>
            @if($goodsDonations->count() > 0)
                <div class="space-y-6">
                    <p class="text-sm text-gray-600">Select items from available donors' stock. You can pick items from multiple donations.</p>
                    
                    @php $itemIndex = 0; @endphp
                    @foreach($goodsDonations as $donation)
                        @foreach($donation->items as $item)
                            @if($item->remaining_quantity > 0)
                                <div class="border rounded-xl p-5 hover:border-indigo-300 transition" x-data="{ selected: false, qty: '' }">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <label class="flex items-center">
                                                <input type="checkbox" x-model="selected" @change="qty = selected ? 1 : ''" class="w-5 h-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                                            </label>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $item->item_name }}</p>
                                                <p class="text-sm text-gray-500">
                                                    From <span class="font-medium">{{ $donation->user->name }}</span> · Donation #{{ $donation->id }}
                                                    @if($item->notes) · {{ $item->notes }} @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm">
                                                <span class="font-bold text-indigo-600">{{ $item->remaining_quantity }}</span>
                                                <span class="text-gray-500">of {{ $item->quantity }} remaining</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div x-show="selected" x-cloak class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center space-x-4">
                                            <label class="text-sm font-medium text-gray-700">Quantity to allocate:</label>
                                            <input type="number" 
                                                :name="selected ? 'goods_allocations[{{ $itemIndex }}][quantity]' : ''" 
                                                x-model.number="qty" 
                                                min="1" max="{{ $item->remaining_quantity }}" 
                                                :disabled="!selected"
                                                class="w-24 px-3 py-2 border border-gray-300 rounded-lg text-center font-semibold focus:ring-2 focus:ring-indigo-500 disabled:bg-gray-100 disabled:text-gray-400">
                                            <span class="text-sm text-gray-500">max {{ $item->remaining_quantity }}</span>
                                            <input type="hidden" 
                                                :name="selected ? 'goods_allocations[{{ $itemIndex }}][donation_item_id]' : ''" 
                                                value="{{ $item->id }}"
                                                :disabled="!selected">
                                        </div>
                                    </div>
                                </div>
                                @php $itemIndex++; @endphp
                            @endif
                        @endforeach
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <span class="text-4xl block mb-3">📦</span>
                    <p class="font-semibold">No goods available in stock</p>
                    <p class="text-sm mt-1">All confirmed goods donations have been fully allocated.</p>
                </div>
            @endif
        </div>

        <!-- Placeholder when no type selected -->
        <div x-show="!effectiveType" class="text-center py-8 text-gray-400">
            <span class="text-4xl block mb-2">👆</span>
            <p>Select a target and allocation type first.</p>
        </div>
    </div>

    <!-- Notes -->
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center font-bold text-sm">4</div>
            <h2 class="text-xl font-bold text-gray-900">Notes (Optional)</h2>
        </div>
        <textarea name="notes" rows="3" placeholder="Add any notes about this allocation..." 
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('notes') }}</textarea>
    </div>

    <!-- Submit -->
    <div class="flex items-center justify-end space-x-4">
        <a href="{{ route('admin.allocations.index') }}" class="px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition font-medium">Cancel</a>
        <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Allocate Stock</span>
        </button>
    </div>
</form>

@endsection
