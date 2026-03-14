<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon/favicon.jpeg') }}">
    <title>Edit Profile - {{ config('app.name', 'GoodGive') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-navbar />

    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Profile Header Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 px-8 py-8">
                    <div class="flex items-center space-x-5">
                        <!-- Avatar -->
                        <div class="w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40">
                            <span class="text-3xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                            <p class="text-orange-100">{{ $user->email }}</p>
                            <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm">
                                @if($user->user_type === 'donor') 🤝 Donor
                                @elseif($user->user_type === 'ngo') 🏢 NGO
                                @elseif($user->user_type === 'user') 🙋 Recipient
                                @elseif($user->user_type === 'admin') 🛡️ Admin
                                @elseif($user->user_type === 'staff') 👤 Staff
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                @if($user->user_type === 'donor' && $profile)
                    <div class="grid grid-cols-2 divide-x divide-gray-100">
                        <div class="px-8 py-4 text-center">
                            <p class="text-2xl font-bold text-orange-600">Rs. {{ number_format($profile->total_donated ?? 0, 2) }}</p>
                            <p class="text-sm text-gray-500">Total Donated</p>
                        </div>
                        <div class="px-8 py-4 text-center">
                            <p class="text-2xl font-bold text-orange-600">{{ $profile->donation_count ?? 0 }}</p>
                            <p class="text-sm text-gray-500">Donations Made</p>
                        </div>
                    </div>
                @elseif($user->user_type === 'ngo' && $profile)
                    <div class="grid grid-cols-2 divide-x divide-gray-100">
                        <div class="px-8 py-4 text-center">
                            <p class="text-sm font-medium text-gray-500">Registration No.</p>
                            <p class="text-lg font-bold text-gray-800">{{ $profile->registration_number ?? 'N/A' }}</p>
                        </div>
                        <div class="px-8 py-4 text-center">
                            <p class="text-sm font-medium text-gray-500">Verification</p>
                            <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold
                                @if($profile->verification_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($profile->verification_status === 'verified') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($profile->verification_status) }}
                            </span>
                        </div>
                    </div>
                @elseif($user->user_type === 'user' && $profile)
                    <div class="grid grid-cols-2 divide-x divide-gray-100">
                        <div class="px-8 py-4 text-center">
                            <p class="text-sm font-medium text-gray-500">Account Status</p>
                            <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold
                                @if($profile->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($profile->status === 'approved') bg-green-100 text-green-800
                                @elseif($profile->status === 'assisted') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($profile->status) }}
                            </span>
                        </div>
                        <div class="px-8 py-4 text-center">
                            <p class="text-sm font-medium text-gray-500">Need Category</p>
                            <p class="text-lg font-bold text-gray-800">{{ ucfirst($profile->need_category ?? 'Not set') }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Flash Messages -->
            @if(session('status') === 'profile-updated')
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center space-x-3">
                        <span class="text-xl">✅</span>
                        <p class="text-green-800 font-medium">Profile updated successfully!</p>
                    </div>
                </div>
            @endif

            <!-- Tabbed Navigation -->
            <div x-data="{ activeTab: 'profile' }" class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex border-b border-gray-100">
                        <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'border-orange-500 text-orange-600 bg-orange-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50'" class="flex-1 px-6 py-4 text-sm font-medium border-b-2 transition-all duration-200 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Profile</span>
                        </button>
                        <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'border-orange-500 text-orange-600 bg-orange-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50'" class="flex-1 px-6 py-4 text-sm font-medium border-b-2 transition-all duration-200 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>Security</span>
                        </button>
                        <button @click="activeTab = 'danger'" :class="activeTab === 'danger' ? 'border-red-500 text-red-600 bg-red-50/50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50'" class="flex-1 px-6 py-4 text-sm font-medium border-b-2 transition-all duration-200 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            <span>Danger Zone</span>
                        </button>
                    </div>

                    <!-- Profile Tab -->
                    <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-6 sm:p-8">
                        @include('profile.partials.update-profile-information-form')

                        @if($profile)
                            <hr class="my-8 border-gray-200">
                            @if($user->user_type === 'donor')
                                @include('profile.partials.update-donor-profile-form')
                            @elseif($user->user_type === 'ngo')
                                @include('profile.partials.update-ngo-profile-form')
                            @elseif($user->user_type === 'user')
                                @include('profile.partials.update-recipient-profile-form')
                            @endif
                        @endif
                    </div>

                    <!-- Security Tab -->
                    <div x-show="activeTab === 'security'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-6 sm:p-8">
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Danger Zone Tab -->
                    <div x-show="activeTab === 'danger'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-6 sm:p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            <!-- Account Info Footer -->
            <div class="mt-8 text-center text-sm text-gray-400">
                Member since {{ $user->created_at->format('F j, Y') }}
            </div>
        </div>
    </div>
</body>
</html>
