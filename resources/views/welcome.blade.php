<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RentalHub') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-teal-600 to-blue-700 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-white font-bold text-xl flex items-center gap-2">
                    🏠 {{ config('app.name', 'RentalHub') }}
                </a>
                <div class="flex items-center gap-4">
                    @if (Route::has('login')) 
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white hover:text-blue-100 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-blue-100 transition">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-white text-teal-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-gradient-to-r from-teal-500 to-blue-600 py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Find Your Perfect Rental Home</h1>
            <p class="text-blue-100 text-lg mb-8">Discover available rental houses in your town. Connect with verified landlords and find your next home with ease.</p>
            
            <!-- Search Bar -->
            <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 max-w-3xl mx-auto flex flex-col md:flex-row gap-3">
                <input type="text" placeholder="Enter location or address..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option>Any Status</option>
                    <option>Vacant</option>
                    <option>Occupied</option>
                </select>
                <a href="{{ route('properties.index') }}" class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-teal-600 hover:to-blue-700 transition inline-flex items-center justify-center">Search</a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-4xl mb-4">⚡</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Fast & Easy</h3>
                <p class="text-gray-600">Find your next home in minutes with our intuitive search and filtering.</p>
            </div>
            <div class="text-center">
                <div class="text-4xl mb-4">🔒</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Secure & Verified</h3>
                <p class="text-gray-600">All landlords and properties are verified for your peace of mind.</p>
            </div>
            <div class="text-center">
                <div class="text-4xl mb-4">🗺️</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Location Focused</h3>
                <p class="text-gray-600">Real photos, maps, and accurate vacancy status for each property.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-auto bg-gray-900 text-white text-center py-6 mt-12">
        <small>&copy; {{ date('Y') }} {{ config('app.name', 'RentalHub') }}. All rights reserved.</small>
    </footer>
</body>
</html>
