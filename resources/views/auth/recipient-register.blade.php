<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Assistance - {{ config('app.name', 'GoodGive') }}</title>

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
                        Request<br>Assistance
                    </h1>
                    <div class="border-b-4 border-indigo-500 w-20 mb-6"></div>
                    <p class="text-lg text-gray-700">
                        Submit your request and we'll connect you with verified NGOs who can help.
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
                            <p class="font-semibold text-gray-900">Submit Your Request</p>
                            <p class="text-sm text-gray-600">Fill out the form with your details</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm">
                            2
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">NGO Review</p>
                            <p class="text-sm text-gray-600">Verified NGOs review your request</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm">
                            3
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Get Assistance</p>
                            <p class="text-sm text-gray-600">Receive help from caring donors</p>
                        </div>
                    </div>
                </div>

                <!-- Important Notice -->
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6">
                    <div class="flex items-start space-x-3">
                        <div class="text-3xl">⚠️</div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-2">Important Notice</h3>
                            <ul class="text-sm text-gray-700 space-y-1 list-disc list-inside">
                                <li>Requests are processed through registered NGOs</li>
                                <li>Verification may be required</li>
                                <li>Response time varies by availability</li>
                                <li>All information is kept confidential</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- SVG Placeholder -->
                <div class="hidden lg:block">
                    <img src="/assets/svg/recipient-register.svg" alt="Recipient Registration Design" class="w-full max-w-md">
                </div>
            </div>

            <!-- Right Side - Request Form -->
            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-3xl shadow-2xl p-8 lg:p-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Submit Request</h2>
                    <p class="text-gray-600">We're here to help</p>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
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
                            placeholder="Enter your full name"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition"
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
                            placeholder="+94"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition"
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
                            placeholder="City or area"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition"
                        >
                    </div>

                    <!-- Category of Need -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category of Need <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="category" 
                            name="category"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition"
                        >
                            <option value="">Select category</option>
                            <option value="education">Education</option>
                            <option value="healthcare">Healthcare</option>
                            <option value="shelter">Shelter</option>
                            <option value="food">Food Security</option>
                            <option value="clothing">Clothing</option>
                            <option value="emergency">Emergency Relief</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Description of Need -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description of Need <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            placeholder="Please describe your situation and what assistance you need..."
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition resize-none"
                        ></textarea>
                    </div>

                    <!-- Supporting Documents/Proof -->
                    <div>
                        <label for="documents" class="block text-sm font-semibold text-gray-700 mb-2">
                            Supporting Documents/Proof <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 mb-2">Upload proof documents (ID card, medical reports, bills, etc.)</p>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center bg-white hover:bg-gray-50 transition cursor-pointer">
                            <input 
                                type="file" 
                                id="documents" 
                                name="documents[]" 
                                accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                multiple
                                class="hidden"
                                onchange="updateFileList(this)"
                            >
                            <label for="documents" class="cursor-pointer">
                                <div class="text-4xl mb-2">📄</div>
                                <p class="font-semibold text-gray-700 mb-1">Upload Documents</p>
                                <p class="text-xs text-gray-500">PDF, JPG, PNG, DOC (Max 5MB each)</p>
                                <p class="text-xs text-gray-400 mt-1">You can upload multiple files</p>
                            </label>
                        </div>
                        <div id="file-list" class="mt-2 space-y-1"></div>
                    </div>

                    <!-- Consent Checkbox -->
                    <div class="flex items-start space-x-2">
                        <input 
                            type="checkbox" 
                            id="consent" 
                            name="consent"
                            class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                        >
                        <label for="consent" class="text-sm text-gray-600">
                            I confirm that all information provided is accurate and I consent to sharing this information with verified NGOs for assistance purposes.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg hover:shadow-xl"
                    >
                        Submit Request
                    </button>

                    <!-- Help Text -->
                    <p class="text-center text-xs text-gray-500 mt-4">
                        Your request will be reviewed by our partner NGOs. You may be contacted for verification.
                    </p>
                </form>
            </div>

        </div>
    </div>

    <script>
        function updateFileList(input) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';
            
            if (input.files.length > 0) {
                Array.from(input.files).forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center justify-between bg-indigo-50 rounded-lg px-3 py-2 text-sm';
                    fileItem.innerHTML = `
                        <span class="text-indigo-700 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                            </svg>
                            ${file.name}
                        </span>
                        <span class="text-gray-500">${(file.size / 1024).toFixed(1)} KB</span>
                    `;
                    fileList.appendChild(fileItem);
                });
            }
        }
    </script>

</body>
</html>
