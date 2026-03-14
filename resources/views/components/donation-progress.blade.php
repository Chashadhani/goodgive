@props(['ngoPost'])

@if($ngoPost->isMoney() && $ngoPost->goal_amount)
    @php
        $raised = $ngoPost->confirmed_money;
        $goal = $ngoPost->goal_amount;
        $percent = $ngoPost->money_progress_percent;
        $goalMet = $ngoPost->isMoneyGoalMet();
    @endphp
    <div class="bg-gradient-to-r {{ $goalMet ? 'from-green-50 to-emerald-50 border-green-200' : 'from-green-50 to-emerald-50 border-green-200' }} border rounded-xl p-6 mb-8">
        <div class="flex items-center justify-between mb-3">
            <div>
                <p class="text-sm text-green-600 font-medium uppercase tracking-wide">Donation Goal</p>
                <p class="text-3xl font-bold text-green-700 mt-1">Rs. {{ number_format($goal) }}</p>
            </div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                <span class="text-3xl">{{ $goalMet ? '✅' : '🎯' }}</span>
            </div>
        </div>
        <!-- Progress Bar -->
        <div class="mt-4">
            <div class="flex items-center justify-between text-sm mb-1">
                <span class="font-semibold {{ $goalMet ? 'text-green-700' : 'text-green-600' }}">
                    Rs. {{ number_format($raised) }} raised
                </span>
                <span class="font-medium text-gray-500">{{ $percent }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div class="h-3 rounded-full transition-all duration-500 {{ $goalMet ? 'bg-green-500' : 'bg-gradient-to-r from-green-400 to-emerald-500' }}"
                    style="width: {{ $percent }}%"></div>
            </div>
            @if($goalMet)
                <p class="text-sm text-green-700 font-semibold mt-2">Goal reached! This post has been fulfilled.</p>
            @else
                <p class="text-sm text-gray-500 mt-2">Rs. {{ number_format($goal - $raised) }} more needed to reach the goal</p>
            @endif
        </div>
    </div>
@endif

@if($ngoPost->isGoods() && $ngoPost->items->count())
    @php
        $donated = $ngoPost->confirmed_goods_donated;
        $overallPercent = $ngoPost->goods_progress_percent;
        $goalMet = $ngoPost->isGoodsGoalMet();
    @endphp
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm text-blue-600 font-medium uppercase tracking-wide">Items Needed</p>
                <p class="text-lg font-bold text-blue-700 mt-1">{{ $ngoPost->total_items_count }} total items</p>
            </div>
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <span class="text-3xl">{{ $goalMet ? '✅' : '📦' }}</span>
            </div>
        </div>
        <!-- Overall Progress Bar -->
        <div class="mb-4">
            <div class="flex items-center justify-between text-sm mb-1">
                <span class="font-semibold {{ $goalMet ? 'text-green-700' : 'text-blue-600' }}">
                    Overall Progress
                </span>
                <span class="font-medium text-gray-500">{{ $overallPercent }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div class="h-3 rounded-full transition-all duration-500 {{ $goalMet ? 'bg-green-500' : 'bg-gradient-to-r from-blue-400 to-indigo-500' }}"
                    style="width: {{ $overallPercent }}%"></div>
            </div>
            @if($goalMet)
                <p class="text-sm text-green-700 font-semibold mt-2">All items fulfilled! This post has been completed.</p>
            @endif
        </div>
        <!-- Individual Items -->
        <div class="space-y-2">
            @foreach($ngoPost->items as $item)
                @php
                    $itemDonated = $donated[$item->item_name] ?? 0;
                    $itemPercent = $item->quantity > 0 ? min(100, round(($itemDonated / $item->quantity) * 100)) : 0;
                    $itemFulfilled = $itemDonated >= $item->quantity;
                @endphp
                <div class="bg-white rounded-lg px-4 py-3 border border-blue-100">
                    <div class="flex items-center justify-between mb-1">
                        <div>
                            <span class="font-medium text-gray-900">{{ $item->item_name }}</span>
                            @if($item->notes)
                                <span class="text-xs text-gray-500 ml-2">({{ $item->notes }})</span>
                            @endif
                        </div>
                        <span class="text-sm font-bold {{ $itemFulfilled ? 'text-green-700 bg-green-100' : 'text-blue-700 bg-blue-100' }} px-3 py-1 rounded-full">
                            {{ $itemDonated }}/{{ $item->quantity }} {{ $itemFulfilled ? '✓' : '' }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden mt-1">
                        <div class="h-2 rounded-full transition-all duration-500 {{ $itemFulfilled ? 'bg-green-500' : 'bg-blue-400' }}"
                            style="width: {{ $itemPercent }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
