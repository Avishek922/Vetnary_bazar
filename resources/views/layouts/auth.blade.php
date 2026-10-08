<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VetBazzar') }} - Authentication</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased font-sans text-slate-800 bg-slate-50 selection:bg-primary-500 selection:text-white">
    <div class="min-h-screen flex">

        <!-- Left Side: Interactive Form Container -->
        <div class="w-full lg:w-[52%] xl:w-[48%] flex flex-col justify-between min-h-screen px-6 py-6 sm:px-12 md:px-16 lg:px-12 xl:px-16 bg-white relative z-10 shadow-2xl shadow-slate-900/5">
            
            <div class="w-full max-w-xl mx-auto flex flex-col justify-between flex-1">
                
                <!-- Top Bar: Logo & Back Button -->
                <header class="flex items-center justify-between pt-2 pb-8 w-full border-b border-slate-100/80">
                    <!-- Brand Logo -->
                    <a href="/" class="group flex items-center gap-3 transition">
                        <div class="relative">
                            <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" class="w-10 h-10 transition-transform group-hover:scale-105 duration-200">
                            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-secondary-500 border-2 border-white rounded-full"></span>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-slate-900">
                            Vet<span class="text-primary-600">Bazzar</span>
                        </span>
                    </a>

                    <!-- Adjusted Back to Store Button -->
                    <a href="/" 
                       class="group inline-flex items-center gap-2.5 px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:text-primary-600 bg-white hover:bg-slate-50 border border-slate-200/90 hover:border-primary-300 rounded-xl shadow-xs hover:shadow transition-all duration-200 shrink-0">
                        <div class="w-5 h-5 rounded-lg bg-slate-100 group-hover:bg-primary-100 flex items-center justify-center text-slate-500 group-hover:text-primary-600 transition-colors">
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </div>
                        <span>Back to Store</span>
                    </a>
                </header>

                <!-- Main Form Slot -->
                <main class="my-auto py-6 w-full">
                    {{ $slot }}
                </main>

                <!-- Bottom Footer: Security & Legal -->
                <footer class="pt-6 pb-2 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2 w-full">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'VetBazzar') }}. All rights reserved.</p>
                    <div class="flex items-center gap-1.5 text-slate-500 font-medium">
                        <svg class="w-3.5 h-3.5 text-secondary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>SSL 256-bit Secure Encryption</span>
                    </div>
                </footer>

            </div>
        </div>

        <!-- Right Side: Visual Showcase with Glassmorphism (Desktop only) -->
        <div class="hidden lg:flex lg:w-[48%] xl:w-[52%] relative overflow-hidden bg-slate-950 items-center justify-center p-12 xl:p-16">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?auto=format&fit=crop&w=1600&q=80" 
                 alt="Veterinary Healthcare" 
                 class="absolute inset-0 w-full h-full object-cover object-center opacity-45 mix-blend-luminosity scale-105 transition-transform duration-1000 ease-out hover:scale-100">

            <!-- Gradient Overlays for Cinematic Feel -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/75 to-primary-950/60"></div>
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Content Card Container -->
            <div class="relative z-10 max-w-lg space-y-8 text-white">
                
                <!-- Trust Badge -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-lg shadow-black/10">
                    <span class="flex h-2 w-2 rounded-full bg-secondary-400 animate-pulse"></span>
                    <span class="text-xs font-semibold tracking-wide uppercase text-slate-100">Nepal's #1 Veterinary Store</span>
                </div>

                <!-- Main Punchline -->
                <div class="space-y-4">
                    <h2 class="text-3xl xl:text-4xl font-extrabold tracking-tight leading-tight text-white drop-shadow-sm">
                        Everything your animals need, <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-300 to-secondary-300">delivered with care.</span>
                    </h2>
                    <p class="text-sm xl:text-base text-slate-300 leading-relaxed font-normal">
                        Certified medicines, premium feeds, and surgical supplies with 100% verified authenticity and reliable doorstep delivery.
                    </p>
                </div>

                <!-- Glassmorphism Highlight Cards Grid -->
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-2 hover:bg-white/15 transition">
                        <div class="w-9 h-9 rounded-xl bg-primary-500/20 border border-primary-400/30 flex items-center justify-center text-primary-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-white">100% Genuine</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">Direct from licensed pharmaceutical distributors.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-2 hover:bg-white/15 transition">
                        <div class="w-9 h-9 rounded-xl bg-secondary-500/20 border border-secondary-400/30 flex items-center justify-center text-secondary-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-white">Fast Delivery</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">Swift delivery across Birgunj and all districts.</p>
                    </div>
                </div>

                <!-- Customer Trust Proof -->
                <div class="pt-4 flex items-center gap-4">
                    <div class="flex -space-x-2 overflow-hidden">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-slate-900 object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80" alt="Customer">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-slate-900 object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80" alt="Customer">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-slate-900 object-cover" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=120&q=80" alt="Customer">
                        <div class="flex items-center justify-center h-9 w-9 rounded-full bg-primary-600 text-white font-bold text-xs ring-2 ring-slate-900">
                            +2k
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center text-amber-400 text-xs gap-0.5">
                            ★★★★★
                        </div>
                        <p class="text-xs text-slate-300 font-medium mt-0.5">Rated 4.9/5 by veterinarians & pet parents</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</body>
</html>
