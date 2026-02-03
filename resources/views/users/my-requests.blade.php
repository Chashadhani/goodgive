<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Requests - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('recipient.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    ← Back to Dashboard
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-4">My Requests</h1>
                <p class="text-gray-600 mt-1">Track all your assistance requests</p>
            </div>

            @if(Auth::user()->recipientProfile)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if(Auth::user()->recipientProfile->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif(Auth::user()->recipientProfile->status === 'approved') bg-green-100 text-green-800
                                @elseif(Auth::user()->recipientProfile->status === 'assisted') bg-indigo-100 text-indigo-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(Auth::user()->recipientProfile->status) }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-900 mt-2">{{ Auth::user()->recipientProfile->category_label }}</h3>
                            <p class="text-gray-500 text-sm">Submitted on {{ Auth::user()->recipientProfile->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-gray-700">{{ Auth::user()->recipientProfile->description }}</p>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <div class="text-center py-12">
                        <span class="text-6xl mb-4 block">📋</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Requests Yet</h3>
                        <p class="text-gray-500">You haven't submitted any assistance requests.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
