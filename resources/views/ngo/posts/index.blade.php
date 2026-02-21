<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Posts - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <a href="{{ route('ngo.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-2">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to Dashboard
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">My Posts</h1>
                    <p class="text-gray-600 mt-1">Manage your NGO posts</p>
                </div>
                @if(Auth::user()->ngoProfile?->isVerified())
                    <a href="{{ route('ngo.posts.create') }}" class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold transition shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create New Post
                    </a>
                @endif
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Posts Table -->
            @if($posts->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Post</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Category</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Urgency</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Status</th>
                                <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">Created</th>
                                <th class="text-right px-6 py-4 text-sm font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($posts as $post)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            @if($post->image)
                                                <img src="{{ Storage::url($post->image) }}" alt="" class="w-12 h-12 rounded-lg object-cover">
                                            @else
                                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                                    <span class="text-xl">📝</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ Str::limit($post->title, 40) }}</p>
                                                @if($post->goal_amount)
                                                    <p class="text-xs text-gray-500">Goal: Rs. {{ number_format($post->goal_amount) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full">{{ $post->category }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($post->urgency === 'critical')
                                            <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-full">Critical</span>
                                        @elseif($post->urgency === 'urgent')
                                            <span class="px-3 py-1 bg-orange-50 text-orange-700 text-xs font-semibold rounded-full">Urgent</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-50 text-gray-700 text-xs font-semibold rounded-full">Normal</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($post->status === 'approved')
                                            <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full">Approved</span>
                                        @elseif($post->status === 'rejected')
                                            <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-full">Rejected</span>
                                        @else
                                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 text-xs font-semibold rounded-full">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('ngo.posts.show', $post) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View</a>
                                            <a href="{{ route('ngo.posts.edit', $post) }}" class="text-orange-600 hover:text-orange-800 text-sm font-medium">Edit</a>
                                            <form action="{{ route('ngo.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <span class="text-6xl mb-4 block">📋</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Posts Yet</h3>
                    <p class="text-gray-600 mb-6">Create your first post to start receiving donations</p>
                    @if(Auth::user()->ngoProfile?->isVerified())
                        <a href="{{ route('ngo.posts.create') }}" class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold transition">
                            Create Your First Post
                        </a>
                    @else
                        <p class="text-yellow-600 font-medium">Your NGO must be verified before creating posts.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</body>
</html>
