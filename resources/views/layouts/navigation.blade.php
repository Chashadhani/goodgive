<!-- Modern Navigation with Glassmorphism -->
<nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
     @scroll.window="scrolled = window.pageYOffset > 10"
     :class="scrolled ? 'bg-white/80 backdrop-blur-lg shadow-lg' : 'bg-white/90 backdrop-blur-sm'"
     class="sticky top-0 z-50 border-b border-gray-200/50 transition-all duration-300">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 sm:h-20">
            <!-- Logo & Nav Links -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" 
                       class="text-2xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent hover:scale-105 transition-transform duration-300">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:ml-10 sm:flex sm:items-center sm:space-x-2">
                    <a href="{{ route('dashboard') }}"
                       class="group relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                        <span class="relative z-10">Dashboard</span>
                        @if(request()->routeIs('dashboard'))
                            <span class="absolute inset-0 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg"></span>
                        @else
                            <span class="absolute inset-0 bg-gray-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        @endif
                    </a>
                    
                    <!-- Add more navigation items here -->
                </div>
            </div>

            <!-- Right Side: User Menu -->
            <div class="flex items-center">
                <!-- Desktop User Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="group flex items-center space-x-3 text-sm focus:outline-none transition-all duration-300 hover:scale-105">
                                    <!-- User Info -->
                                    <div class="hidden md:block text-right">
                                        <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                    </div>
                                    
                                    <!-- Avatar with ring -->
                                    <div class="relative">
                                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full opacity-75 group-hover:opacity-100 transition-opacity duration-300 blur"></div>
                                        <img class="relative h-10 w-10 rounded-full object-cover ring-2 ring-white" 
                                             src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                             alt="{{ Auth::user()->name }}" />
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('profile.edit') }}" class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>{{ __('Profile') }}</span>
                                    </div>
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('logout') }}"
                                                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                 class="hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-600 transition-all duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>{{ __('Log Out') }}</span>
                                    </div>
                                </x-dropdown-link>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            type="button"
                            class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-all duration-300"
                            aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Hamburger Icon -->
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Close Icon -->
                        <svg x-show="mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="sm:hidden bg-white/95 backdrop-blur-lg border-t border-gray-200/50"
         x-cloak>
        
        <!-- Mobile Nav Links -->
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" 
               class="block px-4 py-3 rounded-lg text-base font-medium transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                Dashboard
            </a>
        </div>

        <!-- Mobile User Info -->
        <div class="pt-4 pb-3 border-t border-gray-200/50">
            <div class="flex items-center px-4 mb-3">
                <div class="shrink-0">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full opacity-75 blur"></div>
                        <img class="relative h-12 w-12 rounded-full object-cover ring-2 ring-white" 
                             src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}" 
                             alt="{{ Auth::user()->name }}" />
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="px-4 space-y-1">
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center space-x-2 px-4 py-3 rounded-lg text-base font-medium text-gray-600 hover:text-indigo-600 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profile</span>
                </a>
                
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" 
                   class="flex items-center space-x-2 px-4 py-3 rounded-lg text-base font-medium text-gray-600 hover:text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Log Out</span>
                </a>
                
                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    [x-cloak] { display: none !important; }
</style>
