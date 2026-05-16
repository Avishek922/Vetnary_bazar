<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Veterinary Bazzar') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full scroll-smooth antialiased font-sans text-gray-900">
    <div class="flex min-h-full flex-1 relative">
        <!-- Mobile Background Image (Visible only on small screens) -->
        <div class="absolute inset-0 z-0 lg:hidden">
            <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80" alt="Happy Dog in Veterinary Clinic">
            <div class="absolute inset-0 bg-primary-900/40 mix-blend-multiply"></div>
        </div>

        <!-- Login Section -->
        <!-- Mobile: Centered over background with glass effect -->
        <!-- Desktop: Left side, solid white background -->
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 z-10 w-full lg:w-1/2 items-center lg:items-stretch lg:bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96 bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-xl lg:bg-transparent lg:shadow-none lg:p-0 lg:rounded-none">
                <div>
                    <a href="/" class="flex items-center gap-2">
                        <!-- Professional Logo: Blue Shield/Cross with Paw -->
<img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" class="w-12 h-12">
                        <span class="text-3xl font-bold font-sans tracking-tight text-gray-900">Vet<span class="text-primary-600">Bazzar</span></span>
                    </a>
                </div>

                <div class="mt-10">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Desktop Image Section (Hidden on mobile, Split view on desktop) -->
        <div class="hidden relative w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80" alt="Happy Dog in Veterinary Clinic">
            <div class="absolute inset-0 bg-primary-900/40 mix-blend-multiply"></div>
        </div>
    </div>
</body>
</html>
