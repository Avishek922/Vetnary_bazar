<x-auth-layout>
    <div class="w-full max-w-lg mx-auto" x-data="{ showPassword: false }">
        
        <!-- Header -->
        <div class="space-y-2 mb-8">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-primary-50 text-primary-700 border border-primary-100">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-600"></span>
                Secure Account Access
            </span>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                Welcome back
            </h1>
            <p class="text-sm text-slate-500">
                Enter your registered credentials to access your dashboard and orders.
            </p>
        </div>

        <!-- Global Session / Error Alert -->
        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm font-medium text-emerald-800 flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-sm font-medium text-rose-800 flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Email Input -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Email Address
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                        </svg>
                    </div>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           autocomplete="email" 
                           required 
                           value="{{ old('email') }}"
                           placeholder="doctor@vetclinic.com"
                           class="block w-full pl-11 pr-4 py-3 bg-slate-50/50 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder-slate-400 text-sm rounded-xl border @error('email') border-rose-400 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:border-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-500/15 transition-all duration-200">
                </div>
                @error('email')
                    <p class="flex items-center gap-1.5 text-xs font-medium text-rose-600 mt-1.5">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Password
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition">
                        Forgot password?
                    </a>
                </div>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" 
                           name="password" 
                           :type="showPassword ? 'text' : 'password'" 
                           autocomplete="current-password" 
                           required 
                           placeholder="••••••••••••"
                           class="block w-full pl-11 pr-11 py-3 bg-slate-50/50 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder-slate-400 text-sm rounded-xl border @error('password') border-rose-400 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:border-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-500/15 transition-all duration-200">
                    
                    <!-- Show/Hide Password Button -->
                    <button type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition"
                            tabindex="-1"
                            title="Toggle password visibility">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="flex items-center gap-1.5 text-xs font-medium text-rose-600 mt-1.5">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                    <input id="remember_me" 
                           name="remember" 
                           type="checkbox" 
                           class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 focus:ring-offset-0 transition cursor-pointer">
                    <span class="text-xs font-medium text-slate-600">Keep me signed in</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                        class="group relative w-full flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 shadow-lg shadow-primary-600/25 hover:shadow-primary-600/35 active:scale-[0.99] transition-all duration-200">
                    <span>Sign In to Account</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>

        <!-- Divider & Register Switch -->
        <div class="mt-8 pt-6 border-t border-slate-100 text-center space-y-4">
            <p class="text-xs text-slate-500">
                Don't have an account yet?
            </p>
            <a href="{{ route('register') }}" 
               class="inline-flex w-full items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 border border-slate-200/80 transition-all duration-200">
                <span>Create a New Account</span>
                <span class="text-xs text-secondary-600 font-bold bg-secondary-50 px-2 py-0.5 rounded-full border border-secondary-100">Free</span>
            </a>
        </div>

    </div>
</x-auth-layout>
