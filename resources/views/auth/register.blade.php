<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Choose Account Type - {{ config('app.name', 'GoodGive') }}</title>

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
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                ← Back to Login
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Choose Your Account Type
            </h1>
            <div class="border-b-4 border-orange-500 w-32 mx-auto mb-6"></div>
            <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                Select the type of account that best describes you to get started with GoodGive
            </p>
        </div>

        <!-- Account Type Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            
            <!-- Donor Card -->
            <a href="{{ route('donor.register') }}" class="group">
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100 hover:border-orange-500 hover:-translate-y-2 h-full">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-br from-orange-400 to-yellow-500 p-8 text-center">
                        <div class="text-6xl mb-4">🤲</div>
                        <h2 class="text-2xl font-bold text-white">Donor</h2>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="p-8">
                        <p class="text-gray-600 text-center mb-6">
                            Make a difference by donating to verified NGOs and track your impact in real-time
                        </p>
                        
                        <!-- Features List -->
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Track donations</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Get receipts</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Support verified NGOs</span>
                            </li>
                        </ul>
                        
                        <!-- CTA Button -->
                        <div class="text-center">
                            <span class="inline-flex items-center text-orange-600 font-semibold group-hover:text-orange-700">
                                Register as Donor
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- NGO Card -->
            <a href="{{ route('ngo.register') }}" class="group">
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100 hover:border-green-500 hover:-translate-y-2 h-full">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-8 text-center">
                        <div class="text-6xl mb-4">🏢</div>
                        <h2 class="text-2xl font-bold text-white">NGO</h2>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="p-8">
                        <p class="text-gray-600 text-center mb-6">
                            Register your organization to receive donations and connect with generous donors
                        </p>
                        
                        <!-- Features List -->
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Verified badge</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Post your needs</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Manage donations</span>
                            </li>
                        </ul>
                        
                        <!-- CTA Button -->
                        <div class="text-center">
                            <span class="inline-flex items-center text-green-600 font-semibold group-hover:text-green-700">
                                Register as NGO
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Recipient Card -->
            <a href="{{ route('recipient.register') }}" class="group">
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100 hover:border-indigo-500 hover:-translate-y-2 h-full">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 p-8 text-center">
                        <div class="text-6xl mb-4">🙏</div>
                        <h2 class="text-2xl font-bold text-white">Need Help</h2>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="p-8">
                        <p class="text-gray-600 text-center mb-6">
                            Submit a request for assistance through our network of verified NGOs
                        </p>
                        
                        <!-- Features List -->
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Quick assistance</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">NGO verified</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <svg class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-gray-600">Confidential process</span>
                            </li>
                        </ul>
                        
                        <!-- CTA Button -->
                        <div class="text-center">
                            <span class="inline-flex items-center text-indigo-600 font-semibold group-hover:text-indigo-700">
                                Request Assistance
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

        </div>

        <!-- Additional Info -->
        <div class="mt-16 text-center">
            <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Not sure which account type to choose?</h3>
                <p class="text-gray-600 mb-6">
                    Choose <strong>Donor</strong> if you want to give, <strong>NGO</strong> if you're an organization receiving donations, 
                    or <strong>Need Help</strong> if you're seeking assistance through our NGO partners.
                </p>
                <a href="{{ route('how-it-works') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                    Learn more about how it works →
                </a>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-between items-center">
                <div class="text-sm">© 2025 GoodGive. All rights reserved.</div>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="hover:text-white transition">Privacy</a>
                    <a href="#" class="hover:text-white transition">Terms</a>
                    <a href="#" class="hover:text-white transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
