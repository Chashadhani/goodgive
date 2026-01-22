<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NGO Registration - {{ config('app.name', 'GoodGive') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-green-50 min-h-screen">
    
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
                        Partner<br>With Us
                    </h1>
                    <div class="border-b-4 border-green-500 w-20 mb-6"></div>
                    <p class="text-lg text-gray-700">
                        Register your NGO and connect with donors who care about your mission.
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
                        <p class="text-gray-700">Verified organization badge</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-gray-700">Direct access to generous donors</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-gray-700">Real-time donation tracking</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-pink-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-gray-700">Transparent communication platform</p>
                    </div>
                </div>

                <!-- Verification Notice -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-blue-900 mb-1">Verification Process</h3>
                            <p class="text-sm text-blue-800">All NGOs undergo thorough verification</p>
                        </div>
                    </div>
                </div>

                <!-- SVG Placeholder -->
                <div class="hidden lg:block">
                    <img src="/assets/svg/ngo-register.svg" alt="NGO Registration Design" class="w-full max-w-md">
                </div>
            </div>

            <!-- Right Side - Registration Form -->
            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-3xl shadow-2xl p-8 lg:p-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">NGO Registration</h2>
                    <p class="text-gray-600">Join our network of verified organizations</p>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Organization Name -->
                    <div>
                        <label for="org_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Organization Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="org_name" 
                            name="org_name" 
                            placeholder="Official registered name"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Registration Number -->
                    <div>
                        <label for="reg_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            Registration Number <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="reg_number" 
                            name="reg_number" 
                            placeholder="NGO registration number"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Official Address -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Official Address <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="address" 
                            name="address" 
                            placeholder="Complete registered address"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Contact Person Name -->
                    <div>
                        <label for="contact_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Contact Person Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="contact_name" 
                            name="contact_name" 
                            placeholder="Primary contact person"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Official Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Official Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="organization@example.org"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Contact Number <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            placeholder="+94"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Registration Documents -->
                    <div>
                        <label for="documents" class="block text-sm font-semibold text-gray-700 mb-2">
                            Registration Documents <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center bg-white hover:bg-gray-50 transition cursor-pointer">
                            <div class="text-4xl mb-2">📄</div>
                            <p class="font-semibold text-gray-700 mb-1">Upload Documents</p>
                            <p class="text-xs text-gray-500">Click to upload or drag and drop</p>
                            <input type="file" id="documents" name="documents" class="hidden" multiple>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="••••••••"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition pr-12"
                            >
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                👁️
                            </button>
                        </div>
                    </div>

                    <!-- Terms Agreement -->
                    <div class="flex items-start space-x-2">
                        <input 
                            type="checkbox" 
                            id="terms" 
                            name="terms"
                            class="mt-1 w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                        >
                        <label for="terms" class="text-sm text-gray-600">
                            I certify that all information is accurate and agree to 
                            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Terms</a>
                        </label>
                    </div>

                    <!-- Security Notice -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs text-blue-800">
                            🔒 <span class="font-semibold">Security Notice</span><br>
                            This account requires admin approval before activation
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg hover:shadow-xl"
                    >
                        Submit for Verification
                    </button>

                    <!-- Login Link -->
                    <p class="text-center text-sm text-gray-600 mt-4">
                        Already registered? 
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">Login</a>
                    </p>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
