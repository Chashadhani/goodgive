<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-6">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-full mb-4">
                <span class="text-white font-bold text-3xl">G</span>
            </div>
            <h1 class="text-2xl font-bold text-white">GoodGive Admin</h1>
            <p class="text-gray-400 mt-1">Secure administrator access</p>
        </div>

        <!-- Login Card -->
        <div class="bg-gray-800 rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold text-white mb-6 text-center">Admin Login</h2>

            <!-- Session Status -->
            @if(session('status'))
                <div class="bg-green-900/50 border border-green-500 rounded-lg p-3 mb-4">
                    <p class="text-green-400 text-sm">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="bg-red-900/50 border border-red-500 rounded-lg p-3 mb-4">
                    <p class="text-red-400 text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        placeholder="admin@example.com"
                    >
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        type="checkbox" 
                        name="remember"
                        class="w-4 h-4 text-indigo-600 bg-gray-700 border-gray-600 rounded focus:ring-indigo-500"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-400">Remember me</label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition"
                >
                    Sign In to Admin Panel
                </button>
            </form>
        </div>

        <!-- Back to Website -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm transition">
                ← Back to Website
            </a>
        </div>

        <!-- Security Notice -->
        <div class="text-center mt-8">
            <p class="text-xs text-gray-500">
                🔒 This is a secure area. Unauthorized access attempts are logged.
            </p>
        </div>
    </div>
</body>
</html>
