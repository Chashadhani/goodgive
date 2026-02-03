<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assistance Requests - Admin | {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white">
            <div class="p-6">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-xl">G</span>
                    </div>
                    <div>
                        <span class="text-xl font-bold">GoodGive</span>
                        <p class="text-xs text-gray-400">Admin Panel</p>
                    </div>
                </div>
            </div>

            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition">
                    <span class="mr-3">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition">
                    <span class="mr-3">👥</span>
                    Users
                </a>
                <a href="{{ route('admin.ngos.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition">
                    <span class="mr-3">🏢</span>
                    NGO Verification
                </a>
                <a href="{{ route('admin.requests.index') }}" class="flex items-center px-6 py-3 bg-gray-800 text-white">
                    <span class="mr-3">📋</span>
                    Requests
                </a>
            </nav>

            <div class="absolute bottom-0 w-64 p-6">
                <div class="border-t border-gray-700 pt-4">
                    <p class="text-sm text-gray-400">Logged in as</p>
                    <p class="font-medium">{{ Auth::user()->name }}</p>
                    <form method="POST" action="{{ route('admin.logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300 text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Assistance Requests</h1>
                <p class="text-gray-600 mt-1">View all assistance requests from recipients</p>
            </div>

            <!-- Placeholder Content -->
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <div class="text-center py-12">
                    <span class="text-6xl mb-4 block">📋</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Assistance Requests</h3>
                    <p class="text-gray-500">Request management functionality will be implemented here.</p>
                    <p class="text-sm text-gray-400 mt-2">Features: View requests, filter by status/category, assign to NGOs</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
