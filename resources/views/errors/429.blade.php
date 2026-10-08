<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>429 - Too Many Requests | {{ config('app.name', 'VetBazzar') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center font-sans antialiased text-gray-800 p-6">
    <div class="max-w-md w-full text-center bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-100">
        <!-- Icon -->
        <div class="w-16 h-16 mx-auto mb-6 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider text-amber-700 bg-amber-50 rounded-full mb-3">
            Error 429
        </span>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight mb-2">Too Many Requests</h1>
        <p class="text-gray-600 text-sm leading-relaxed mb-6">
            {{ $exception->getMessage() ?: "Aapne bohot kam samay me zyada requests bheji hain. Kripya kuch samay (1 minute) intezar karein aur dobara koshish karein." }}
        </p>

        <div class="space-y-3">
            <button onclick="window.location.reload()" class="w-full py-2.5 px-4 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg shadow-sm transition">
                Refresh Page
            </button>
            <a href="{{ url('/') }}" class="inline-block w-full py-2.5 px-4 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition">
                Return to Home
            </a>
        </div>
    </div>
</body>
</html>
