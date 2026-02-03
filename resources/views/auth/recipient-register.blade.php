<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - {{ config('app.name', 'GoodGive') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-purple-50 min-h-screen">
    
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <!-- Left Side - Info Section -->
            <div class="space-y-8">
                <div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Need Help?<br>Create Account
                    </h1>
                    <div class="border-b-4 border-indigo-500 w-20 mb-6"></div>
                    <p class="text-lg text-gray-700">
                        Create your account to get started. Once approved, you can submit help requests.
                    </p>
                </div>

                <!-- How It Works -->
                <div class="bg-white rounded-2xl shadow-lg p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 text-lg mb-4">How It Works</h3>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm">
                            1
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Create Your Account</p>
                            <p class="text-sm text-gray-600">Fill out the form with your basic details</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm">
                            2
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Account Approval</p>
                            <p class="text-sm text-gray-600">Admin verifies your account</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm">
                            3
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Submit Help Requests</p>
                            <p class="text-sm text-gray-600">Once approved, create requests from your dashboard</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm">
                            4
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Get Assistance</p>
                            <p class="text-sm text-gray-600">Receive help from caring donors through NGOs</p>
                        </div>
                    </div>
                </div>

                <!-- Important Notice -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6">
                    <div class="flex items-start space-x-3">
                        <div class="text-3xl">ℹ️</div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-2">Why Account Approval?</h3>
                            <p class="text-sm text-gray-700">
                                We verify accounts to ensure genuine requests and protect both donors and those seeking help. 
                                This helps maintain trust in our platform.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Registration Form -->
            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-3xl shadow-2xl p-8 lg:p-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
                    <p class="text-gray-600">Quick and easy registration</p>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('recipient.register') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="full_name" 
                            name="full_name" 
                            value="{{ old('full_name') }}"
                            placeholder="Enter your full name"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition @error('full_name') border-red-500 @enderror"
                        >
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="your.email@example.com"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition @error('email') border-red-500 @enderror"
                        >
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="mobile" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mobile Number <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            id="mobile" 
                            name="mobile" 
                            value="{{ old('mobile') }}"
                            placeholder="+94 XX XXX XXXX"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition @error('mobile') border-red-500 @enderror"
                        >
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">
                            Location <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            value="{{ old('location') }}"
                            placeholder="City or area"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition @error('location') border-red-500 @enderror"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="••••••••"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition @error('password') border-red-500 @enderror"
                        >
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="••••••••"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Consent Checkbox -->
                    <div class="flex items-start space-x-2">
                        <input 
                            type="checkbox" 
                            id="consent" 
                            name="consent"
                            required
                            class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                        >
                        <label for="consent" class="text-sm text-gray-600">
                            I agree to the <a href="#" class="text-indigo-600 hover:underline">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:underline">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg hover:shadow-xl"
                    >
                        Create Account
                    </button>

                    <!-- Already have account -->
                    <p class="text-center text-sm text-gray-600 mt-4">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">Log In</a>
                    </p>
                </form>
            </div>

        </div>
    </div>
</body>
</html>
