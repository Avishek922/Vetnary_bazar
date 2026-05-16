<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Veterinary Bazzar') }} - Premium Pet Care</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}" class="w-16 h-16 rounded-full">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Rotation & Overflow Fixes */
        html, body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }
        
        @media screen and (orientation: landscape) and (max-height: 500px) {
            .mobile-height-fix {
                min-height: 100vh;
                padding-bottom: 2rem;
            }
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-700 bg-gray-50 flex flex-col min-h-screen">
    
    <!-- Top Bar (Shipping/Contact) -->
    <div class="bg-primary-900 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <p class="font-medium">Free Shipping on Orders Over NRS. 5000!</p>
            <div class="hidden sm:flex space-x-4">
                <a href="{{ route('pages.show', 'contact-us') }}" class="hover:text-primary-200 transition">Contact Support</a>
                <a href="{{ route('orders.index') }}" class="hover:text-primary-200 transition">Track Order</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav x-data="{ mobileMenuOpen: false, userDropdownOpen: false }" class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo & Left Nav -->
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
<img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" class="w-10 h-10">
                            <span class="text-2xl font-bold font-sans tracking-tight text-gray-900">Vet<span class="text-primary-600">Bazzar</span></span>
                        </a>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                        <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
                        <x-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')">Shop</x-nav-link>
                        <x-nav-link href="{{ route('pages.show', 'about-us') }}" :active="request()->routeIs('pages.show') && request()->route('slug') == 'about-us'">About Us</x-nav-link>
                        <x-nav-link href="{{ route('pages.show', 'contact-us') }}" :active="request()->routeIs('pages.show') && request()->route('slug') == 'contact-us'">Contact Us</x-nav-link>
                        <!-- Only show Admin link if authorized -->
                        @auth
                            @if(in_array(Auth::user()->role, ['admin', 'super_admin', 'inventory_manager', 'delivery_agent', 'delivery']))
                                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.*')">Admin Panel</x-nav-link>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Right Nav (Search, Cart, User) -->
                <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
                    <!-- Search Bar -->
                    <div class="relative" x-data="{ open: false }">
                        <div class="flex items-center">
                            <button @click="open = !open; if(open) $nextTick(() => $refs.searchInput.focus())" class="text-gray-400 hover:text-primary-600 transition p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-x-4"
                                 x-transition:enter-end="opacity-100 translate-x-0"
                                 class="absolute right-full mr-2 bg-white rounded-md shadow-lg p-1 border border-gray-100 flex items-center min-w-[300px]" style="display: none;">
                                <form action="{{ route('home') }}" method="GET" class="w-full flex">
                                    <input type="text" name="search" x-ref="searchInput" value="{{ request('search') }}" placeholder="Search products..." class="w-full border-none focus:ring-0 text-sm py-2 px-3 text-gray-700">
                                    <button type="submit" class="bg-primary-600 text-white px-3 py-2 rounded-md hover:bg-primary-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="group -m-2 p-2 flex items-center relative">
                        <svg class="flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-primary-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-primary-600">Cart</span>
                        <!-- Cart Badge (Optional: Implementation dependent on sharing cart count) -->
                        {{-- <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">3</span> --}}
                    </a>

                    <!-- User Dropdown -->
                    @auth
                        <div class="ml-3 relative">
                            <div>
                                <button @click="userDropdownOpen = !userDropdownOpen" type="button" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" id="user-menu-button">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                </button>
                            </div>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="userDropdownOpen" 
                                 @click.away="userDropdownOpen = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" style="display: none;">
                                <div class="px-4 py-2 border-b">
                                    <p class="text-sm text-gray-500">Signed in as</p>
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Sign out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-primary-600 transition">Log in</a>
                            <a href="{{ route('register') }}" class="text-sm px-4 py-2 rounded-full bg-primary-600 text-white font-medium hover:bg-primary-700 transition shadow-sm hover:shadow-md">Sign up</a>
                        </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        <svg class="h-6 w-6" x-show="mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" class="sm:hidden border-b border-gray-200 bg-white" style="display: none;">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="bg-primary-50 border-primary-500 text-primary-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                <a href="{{ route('products.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Shop</a>
                <a href="{{ route('pages.show', 'about-us') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">About Us</a>
                <a href="{{ route('pages.show', 'contact-us') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Contact Us</a>
                @auth
                    <a href="{{ route('cart.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Cart</a>
                    <a href="{{ route('orders.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">My Orders</a>
                    <a href="{{ route('profile.show') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Profile Settings</a>
                @endauth
            </div>
            @auth
                <div class="pt-4 pb-4 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-lg">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:text-red-800 hover:bg-gray-100">Sign out</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="pt-4 pb-4 border-t border-gray-200 px-4 space-y-2">
                    <a href="{{ route('login') }}" class="block text-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-primary-600 bg-white hover:bg-gray-50">Log in</a>
                    <a href="{{ route('register') }}" class="block text-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700">Sign up</a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow">
        <!-- Flash Messages -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-4 right-4 z-50">
                <div class="bg-secondary-50 border border-secondary-200 text-secondary-800 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <svg class="w-5 h-5 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="ml-2 text-secondary-500 hover:text-secondary-800">&times;</button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-4 right-4 z-50">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                    <button @click="show = false" class="ml-2 text-red-500 hover:text-red-800">&times;</button>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" class="w-10 h-10">
                        <span class="text-xl font-bold text-white">Vet<span class="text-primary-500">Bazzar</span></span>
                    </div>
                    <p class="text-sm text-gray-400">Your trusted partner for all veterinary needs. Quality products for your beloved pets.</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-100 tracking-wider uppercase mb-4">Shop</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition">All Products</a></li>
                        <li><a href="#" class="hover:text-white transition">New Arrivals</a></li>
                        <li><a href="#" class="hover:text-white transition">Best Sellers</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-100 tracking-wider uppercase mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pages.show', 'contact-us') }}" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="{{ route('pages.show', 'about-us') }}" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Shipping Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-100 tracking-wider uppercase mb-4">Newsletter</h3>
                    <p class="text-sm text-gray-400 mb-4">Subscribe to get special offers and news.</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Enter your email" class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded text-sm focus:outline-none focus:border-primary-500">
                        <button type="submit" class="bg-primary-600 text-white px-3 py-2 rounded text-sm hover:bg-primary-700 transition">Go</button>
                    </form>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Veterinary Bazzar. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
