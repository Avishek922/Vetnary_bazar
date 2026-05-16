<x-app-layout>
    <div class="bg-gradient-to-br from-primary-50 via-white to-secondary-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900">My Profile</h1>
                <p class="mt-2 text-gray-600">Manage your account information and preferences</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <!-- Profile Header with Gradient -->
                        <div class="bg-gradient-to-r from-primary-600 to-primary-800 h-32"></div>
                        
                        <!-- Avatar Section -->
                        <div class="relative px-6 pb-6">
                            <div class="flex flex-col items-center -mt-16">
                                <div class="h-32 w-32 rounded-full bg-white p-2 shadow-xl">
                                    <div class="h-full w-full rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                        <span class="text-5xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                </div>
                                
                                <h2 class="mt-4 text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ ucfirst($user->role) }}</p>
                                
                                <a href="{{ route('profile.edit') }}" class="mt-6 w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="mt-6 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Order Statistics</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Total Orders</span>
                                </div>
                                <span class="text-xl font-bold text-blue-600">{{ $totalOrders }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Pending</span>
                                </div>
                                <span class="text-xl font-bold text-yellow-600">{{ $pendingOrders }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Completed</span>
                                </div>
                                <span class="text-xl font-bold text-green-600">{{ $completedOrders }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Profile Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Information Card -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Personal Information
                            </h3>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Full Name</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $user->name }}</dd>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Email Address</dt>
                                    <dd class="text-lg font-semibold text-gray-900 break-all">{{ $user->email }}</dd>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Phone Number</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $user->phone ?? 'Not provided' }}</dd>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Member Since</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Address Information Card -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-secondary-500 to-secondary-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Address Information
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($user->address)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-gray-900 leading-relaxed">{{ $user->address }}</p>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">No address provided</p>
                                    <a href="{{ route('profile.edit') }}" class="mt-2 inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-500">
                                        Add your address
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Quick Actions
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ route('orders.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition border border-blue-200">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">View Orders</p>
                                        <p class="text-xs text-gray-500">Track your purchases</p>
                                    </div>
                                </a>
                                
                                <a href="{{ route('products.index') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition border border-green-200">
                                    <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Continue Shopping</p>
                                        <p class="text-xs text-gray-500">Browse products</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
