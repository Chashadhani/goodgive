<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $ngoPost->title }} - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('ngo.posts.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to My Posts
            </a>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @if($ngoPost->image)
                    <img src="{{ Storage::url($ngoPost->image) }}" alt="{{ $ngoPost->title }}" class="w-full h-64 object-cover">
                @else
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center">
                        <span class="text-6xl">📝</span>
                    </div>
                @endif

                <div class="p-8">
                    <!-- Status Badge -->
                    <div class="flex items-center space-x-3 mb-4">
                        @if($ngoPost->status === 'approved')
                            <span class="px-4 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">✅ Approved</span>
                        @elseif($ngoPost->status === 'rejected')
                            <span class="px-4 py-1 bg-red-100 text-red-800 text-sm font-semibold rounded-full">❌ Rejected</span>
                        @else
                            <span class="px-4 py-1 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full">⏳ Pending Review</span>
                        @endif

                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full">{{ $ngoPost->category }}</span>

                        @if($ngoPost->urgency !== 'normal')
                            <span class="px-3 py-1 {{ $ngoPost->urgency === 'critical' ? 'bg-red-50 text-red-700' : 'bg-orange-50 text-orange-700' }} text-xs font-semibold rounded-full">{{ ucfirst($ngoPost->urgency) }}</span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $ngoPost->title }}</h1>

                    <!-- Request Type Badge -->
                    <div class="mb-4">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $ngoPost->isMoney() ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $ngoPost->isMoney() ? '💰 Money Request' : '📦 Goods Request' }}
                        </span>
                    </div>

                    @if($ngoPost->isMoney() && $ngoPost->goal_amount)
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <p class="text-sm text-gray-500">Donation Goal</p>
                            <p class="text-2xl font-bold text-green-600">Rs. {{ number_format($ngoPost->goal_amount) }}</p>
                        </div>
                    @endif

                    @if($ngoPost->isGoods() && $ngoPost->items->count())
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                            <p class="text-sm font-semibold text-blue-800 mb-3">Items Needed</p>
                            <div class="space-y-2">
                                @foreach($ngoPost->items as $item)
                                    <div class="flex items-center justify-between bg-white rounded-lg px-4 py-2 border border-blue-100">
                                        <div>
                                            <span class="font-medium text-gray-900">{{ $item->item_name }}</span>
                                            @if($item->notes)
                                                <span class="text-xs text-gray-500 ml-2">({{ $item->notes }})</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold text-blue-700 bg-blue-100 px-3 py-1 rounded-full">× {{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="prose max-w-none text-gray-700 mb-6">
                        {!! nl2br(e($ngoPost->description)) !!}
                    </div>

                    @if($ngoPost->admin_notes)
                        <div class="bg-{{ $ngoPost->status === 'rejected' ? 'red' : 'blue' }}-50 border border-{{ $ngoPost->status === 'rejected' ? 'red' : 'blue' }}-200 rounded-lg p-4 mb-6">
                            <p class="text-sm font-semibold text-{{ $ngoPost->status === 'rejected' ? 'red' : 'blue' }}-800 mb-1">Admin Notes:</p>
                            <p class="text-sm text-{{ $ngoPost->status === 'rejected' ? 'red' : 'blue' }}-700">{{ $ngoPost->admin_notes }}</p>
                        </div>
                    @endif

                    <div class="text-sm text-gray-500 border-t pt-4">
                        <p>Created {{ $ngoPost->created_at->format('M d, Y \a\t h:i A') }}</p>
                        @if($ngoPost->reviewed_at)
                            <p>Reviewed {{ $ngoPost->reviewed_at->format('M d, Y \a\t h:i A') }}</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-3 mt-6">
                        <a href="{{ route('ngo.posts.edit', $ngoPost) }}" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold transition">
                            Edit Post
                        </a>
                        <form action="{{ route('ngo.posts.destroy', $ngoPost) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 border-2 border-red-300 text-red-600 hover:bg-red-50 rounded-lg font-semibold transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
