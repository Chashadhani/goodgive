<nav class="bg-white shadow-sm border-b border-gray-200" x-data>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Site Name -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">G</span>
                    </div>
                    <span class="ml-2 text-xl font-semibold text-gray-900">GoodGive</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('how-it-works') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                    How It Works
                </a>
                <a href="{{ route('ngos-posts') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                    NGO Posts
                </a>
                <a href="{{ route('our-work') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                    Our Work
                </a>
                <a href="{{ route('about-us') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                    About Us
                </a>
                
                @auth
                    {{-- Dashboard Link only for Donor, NGO, and Recipient (not admin/staff) --}}
                    @if(in_array(Auth::user()->user_type, ['donor', 'ngo', 'user']))
                        <a href="{{ route(Auth::user()->getDashboardRoute()) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold transition flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('join-staff') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                        Join Our Staff
                    </a>
                @endauth
            </div>

            <!-- Auth Section -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full font-medium transition flex items-center space-x-2">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs text-gray-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->user_type_label }}</p>
                            </div>
                            @if(in_array(Auth::user()->user_type, ['donor', 'ngo', 'user']))
                                <a href="{{ route(Auth::user()->getDashboardRoute()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Dashboard
                                </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full font-medium transition">
                        Log In
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col space-y-3">
                <a href="{{ route('how-it-works') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                    How It Works
                </a>
                <a href="{{ route('ngos-posts') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                    NGO Posts
                </a>
                <a href="{{ route('our-work') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                    Our Work
                </a>
                <a href="{{ route('about-us') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                    About Us
                </a>
                
                @auth
                    @if(in_array(Auth::user()->user_type, ['donor', 'ngo', 'user']))
                        <a href="{{ route(Auth::user()->getDashboardRoute()) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold transition">
                            Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('join-staff') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                        Join Our Staff
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>
