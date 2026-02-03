<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donation History - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('donor.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    ← Back to Dashboard
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-4">Donation History</h1>
                <p class="text-gray-600 mt-1">View all your past donations</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <div class="text-center py-12">
                    <span class="text-6xl mb-4 block">📋</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Donation History</h3>
                    <p class="text-gray-500">Your donation history will appear here once you make donations.</p>
                    <a href="{{ route('ngos-posts') }}" class="inline-block mt-4 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full font-semibold transition">
                        Browse NGO Posts
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
