<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'GoodGive') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">G</span>
                </div>
                <span class="ml-3 text-2xl font-bold text-gray-900">GoodGive</span>
            </a>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-700 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Side - Info -->
            <div>
                <h1 class="text-5xl font-bold text-gray-900 mb-4">
                    Welcome Back
                </h1>
                <div class="border-b-4 border-orange-500 w-32 mb-6"></div>
                
                <p class="text-gray-600 text-lg mb-8">
                    Sign in to continue making a difference and track your impact.
                </p>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        <span class="text-gray-700 font-medium">Track your donations in real-time</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                        <span class="text-gray-700 font-medium">Support verified NGOs directly</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="w-3 h-3 bg-indigo-500 rounded-full"></span>
                        <span class="text-gray-700 font-medium">Get instant donation receipts</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="w-3 h-3 bg-pink-500 rounded-full"></span>
                        <span class="text-gray-700 font-medium">Join a community of changemakers</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl shadow-2xl p-10">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
                    <p class="text-gray-600">Continue your journey of giving</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            placeholder="your.email@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 rounded-full transition shadow-lg hover:shadow-xl">
                        Sign In
                    </button>

                    <!-- Register Link -->
                    <div class="text-center mt-6">
                        <p class="text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                                Create Account
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
