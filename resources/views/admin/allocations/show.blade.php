@extends('admin.layouts.app')

@section('title', 'Allocation Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.allocations.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Allocations
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Status Progress -->
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Allocation Progress</h2>
            
            <div class="flex items-center justify-between mb-8">
                @php
                    $steps = [
                        ['key' => 'processing', 'label' => 'Processing', 'icon' => '⏳'],
                        ['key' => 'delivery', 'label' => 'In Delivery', 'icon' => '🚚'],
                        ['key' => 'distributed', 'label' => 'Distributed', 'icon' => '✅'],
                    ];
                    $statusOrder = ['processing' => 0, 'delivery' => 1, 'distributed' => 2];
                    $currentStep = $statusOrder[$allocation->status] ?? 0;
                @endphp

                @foreach($steps as $index => $step)
                    <div class="flex-1 {{ $index < count($steps) - 1 ? '' : '' }}">
                        <div class="flex flex-col items-center relative">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center text-2xl
                                {{ $index <= $currentStep ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                {{ $step['icon'] }}
                            </div>
                            <p class="text-sm font-semibold mt-2 {{ $index <= $currentStep ? 'text-indigo-600' : 'text-gray-400' }}">
                                {{ $step['label'] }}
                            </p>
                            @if($index === $currentStep)
                                <span class="text-xs text-indigo-500 mt-1">Current</span>
                            @endif
                        </div>
                    </div>

                    @if($index < count($steps) - 1)
                        <div class="flex-shrink-0 w-16 h-1 mt-[-20px] rounded {{ $index < $currentStep ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                    @endif
                @endforeach
            </div>

            <div class="text-center">
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $allocation->status_color }}">
                    {{ $allocation->status_label }}
                </span>
            </div>
        </div>

        <!-- Allocation Details -->
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Allocation Details</h2>

            <div class="grid grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Type</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">
                        {{ $allocation->isMoney() ? '💰 Money' : '📦 Goods' }}
                    </p>
                </div>

                @if($allocation->isMoney())
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Amount</p>
                        <p class="text-lg font-bold text-green-600 mt-1">Rs. {{ number_format($allocation->amount) }}</p>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Item</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $allocation->item_name }} × {{ $allocation->quantity }}</p>
                    </div>
                @endif

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Created</p>
                    <p class="text-gray-900 mt-1">{{ $allocation->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Allocated By</p>
                    <p class="text-gray-900 mt-1">{{ $allocation->allocatedBy->name ?? 'Unknown' }}</p>
                </div>
            </div>

            @if($allocation->notes)
                <div class="mt-6 bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Notes</p>
                    <p class="text-gray-900 mt-1">{{ $allocation->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Source Donation -->
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Source Donation (From Donor)</h2>
            
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-green-600 font-bold text-lg">{{ strtoupper(substr($allocation->donation->user->name ?? '?', 0, 2)) }}</span>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-lg">{{ $allocation->donation->user->name ?? 'Unknown Donor' }}</p>
                    <p class="text-sm text-gray-500">{{ $allocation->donation->user->email ?? '' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                    <p class="text-xs text-green-600 uppercase tracking-wider">Donation ID</p>
                    <p class="text-gray-900 font-semibold mt-1">#{{ $allocation->donation->id }}</p>
                </div>
                <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                    <p class="text-xs text-green-600 uppercase tracking-wider">Donation Type</p>
                    <p class="text-gray-900 font-semibold mt-1">{{ ucfirst($allocation->donation->donation_type) }}</p>
                </div>
                @if($allocation->donation->isMoney())
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                        <p class="text-xs text-green-600 uppercase tracking-wider">Original Amount</p>
                        <p class="text-gray-900 font-semibold mt-1">Rs. {{ number_format($allocation->donation->amount) }}</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                        <p class="text-xs text-green-600 uppercase tracking-wider">Remaining</p>
                        <p class="text-gray-900 font-semibold mt-1">Rs. {{ number_format($allocation->donation->remaining_amount) }}</p>
                    </div>
                @endif
                @if($allocation->donationItem)
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                        <p class="text-xs text-green-600 uppercase tracking-wider">Original Quantity</p>
                        <p class="text-gray-900 font-semibold mt-1">{{ $allocation->donationItem->quantity }}</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                        <p class="text-xs text-green-600 uppercase tracking-wider">Remaining</p>
                        <p class="text-gray-900 font-semibold mt-1">{{ $allocation->donationItem->remaining_quantity }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Target -->
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Target (Allocated To)</h2>
            
            @if($allocation->allocatable)
                <div class="border border-indigo-200 bg-indigo-50 rounded-xl p-6">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">
                        {{ $allocation->allocatable_type === 'App\\Models\\NgoPost' ? '📝 NGO Post' : '🆘 Help Request' }}
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $allocation->allocatable->title }}</h3>
                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit($allocation->allocatable->description, 200) }}</p>
                </div>
            @else
                <p class="text-gray-500">Target has been removed.</p>
            @endif
        </div>

        <!-- Proof Section -->
        @if($allocation->proof_photo)
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6">📸 Distribution Proof</h2>
                <img src="{{ Storage::url($allocation->proof_photo) }}" alt="Distribution proof" class="w-full rounded-xl shadow-sm border">
                @if($allocation->proof_notes)
                    <div class="mt-4 bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Proof Notes</p>
                        <p class="text-gray-900 mt-1">{{ $allocation->proof_notes }}</p>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Sidebar: Actions -->
    <div class="space-y-6">
        <!-- Advance Status -->
        @if($allocation->next_status)
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Advance Status</h3>
                
                <form action="{{ route('admin.allocations.advance', $allocation) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <textarea name="notes" rows="2" placeholder="Add notes (optional)..." 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                    </div>

                    @if($allocation->next_status === 'delivery')
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                            <span>🚚</span>
                            <span>Move to Delivery</span>
                        </button>
                    @elseif($allocation->next_status === 'distributed')
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                            <span>✅</span>
                            <span>Mark as Distributed</span>
                        </button>
                    @endif
                </form>
            </div>
        @else
            <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
                <span class="text-4xl block mb-2">🎉</span>
                <p class="font-bold text-green-800">Fully Distributed!</p>
                <p class="text-sm text-green-600 mt-1">This allocation has been completed.</p>
            </div>
        @endif

        <!-- Upload Proof Photo -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">📸 Upload Proof</h3>
            <p class="text-sm text-gray-500 mb-4">Upload a photo as distribution proof for the donor.</p>
            
            <form action="{{ route('admin.allocations.proof', $allocation) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                    <input type="file" name="proof_photo" accept="image/jpeg,image/png" required
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-1">JPG/PNG, max 5MB</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="proof_notes" rows="2" placeholder="Describe the distribution..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-lg font-semibold transition">
                    Upload Proof Photo
                </button>
            </form>
        </div>

        <!-- Quick Info -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Info</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs text-gray-500 uppercase tracking-wider">Allocation ID</dt>
                    <dd class="font-semibold text-gray-900">#{{ $allocation->id }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 uppercase tracking-wider">Status</dt>
                    <dd><span class="px-3 py-1 rounded-full text-xs font-semibold {{ $allocation->status_color }}">{{ $allocation->status_label }}</span></dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 uppercase tracking-wider">Type</dt>
                    <dd class="font-semibold text-gray-900">{{ $allocation->isMoney() ? '💰 Money' : '📦 Goods' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 uppercase tracking-wider">Created</dt>
                    <dd class="text-sm text-gray-700">{{ $allocation->created_at->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 uppercase tracking-wider">Last Updated</dt>
                    <dd class="text-sm text-gray-700">{{ $allocation->updated_at->diffForHumans() }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
