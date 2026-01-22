<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donor Registration - {{ config('app.name', 'GoodGive') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-xl">G</span>
                </div>
                <span class="text-2xl font-bold text-gray-900">GoodGive</span>
            </div>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                ← Back to Home
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Side - Info Section -->
            <div class="space-y-8">
                <div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Join Our<br>Community
                    </h1>
                    <div class="border-b-4 border-orange-500 w-20 mb-6"></div>
                    <p class="text-lg text-gray-700">
                        Create your donor account and start making a difference today.
                    </p>
                </div>

                <!-- Benefits List -->
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-gray-700">Track your donations in real-time</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-gray-700">Support verified NGOs directly</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-gray-700">Get instant donation receipts</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-pink-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-gray-700">Join a community of changemakers</p>
                    </div>
                </div>

                <!-- SVG Placeholder -->
                <div class="hidden lg:block">
                    <img src="/assets/svg/donor-register.svg" alt="Donor Registration Design" class="w-full max-w-md">
                </div>
            </div>

            <!-- Right Side - Registration Form -->
            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-3xl shadow-2xl p-8 lg:p-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
                    <p class="text-gray-600">Start your journey of giving</p>
                </div>

                <form action="#" method="POST" class="space-y-5">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            id="full_name" 
                            name="full_name" 
                            placeholder="Enter your full name"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="your.email@example.com"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="mobile" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mobile Number
                        </label>
                        <input 
                            type="tel" 
                            id="mobile" 
                            name="mobile" 
                            placeholder="+94"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Address
                        </label>
                        <input 
                            type="text" 
                            id="address" 
                            name="address" 
                            placeholder="Your residential address"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="••••••••"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white transition pr-12"
                            >
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                👁️
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="••••••••"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white transition pr-12"
                            >
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                👁️
                            </button>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start space-x-2">
                        <input 
                            type="checkbox" 
                            id="terms" 
                            name="terms"
                            class="mt-1 w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500"
                        >
                        <label for="terms" class="text-sm text-gray-600">
                            I agree to the 
                            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Terms & Conditions</a> 
                            and 
                            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg hover:shadow-xl"
                    >
                        Create Account
                    </button>

                    <!-- Login Link -->
                    <p class="text-center text-sm text-gray-600 mt-4">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">Sign In</a>
                    </p>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
