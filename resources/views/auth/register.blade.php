<x-auth-layout>
    <div class="w-full max-w-xl mx-auto" x-data="{ showPass: false, showConfirm: false }">
        
        <!-- Header -->
        <div class="space-y-2 mb-6">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-secondary-50 text-secondary-700 border border-secondary-200/60">
                <span class="w-1.5 h-1.5 rounded-full bg-secondary-500"></span>
                Quick 1-Minute Registration
            </span>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                Create an account
            </h1>
            <p class="text-sm text-slate-500">
                Join certified veterinarians, pet owners, and farmers across Nepal.
            </p>
        </div>

        <!-- Global Validation Errors (if any non-field errors) -->
        @if ($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('phone') && !$errors->has('address') && !$errors->has('password'))
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

        <!-- Registration Form -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- 2-Column: Full Name & Phone -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <!-- Full Name -->
                <div class="space-y-1">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Full Name
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7 7z" />
                            </svg>
                        </div>
                        <input id="name" 
                               name="name" 
                               type="text" 
                               autocomplete="name" 
                               required 
                               value="{{ old('name') }}"
                               placeholder="Dr. Rajesh Sharma"
                               class="block w-full pl-10 pr-3 py-2.5 bg-slate-50/50 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder-slate-400 text-sm rounded-xl border @error('name') border-rose-400 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:border-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-500/15 transition-all duration-200">
                    </div>
                    @error('name')
                        <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="space-y-1">
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Phone Number
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input id="phone" 
                               name="phone" 
                               type="tel" 
                               autocomplete="tel" 
                               required 
                               value="{{ old('phone') }}"
                               placeholder="98XXXXXXXX"
                               class="block w-full pl-10 pr-3 py-2.5 bg-slate-50/50 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder-slate-400 text-sm rounded-xl border @error('phone') border-rose-400 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:border-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-500/15 transition-all duration-200">
                    </div>
                    @error('phone')
                        <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Email Address (Full Width) -->
            <div class="space-y-1">
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Email Address
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                        </svg>
                    </div>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           autocomplete="email" 
                           required 
                           value="{{ old('email') }}"
                           placeholder="youremail@example.com"
                           class="block w-full pl-10 pr-3 py-2.5 bg-slate-50/50 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder-slate-400 text-sm rounded-xl border @error('email') border-rose-400 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:border-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-500/15 transition-all duration-200">
                </div>
                @error('email')
                    <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Delivery Address (Full Width) -->
            <div class="space-y-1">
                <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Delivery Address / Clinic Location
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute top-3 left-3.5 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <textarea id="address" 
                              name="address" 
                              rows="2" 
                              required 
                              placeholder="e.g. Ward No. 4, Main Road, Birgunj, Parsa"
                              class="block w-full pl-10 pr-3 py-2.5 bg-slate-50/50 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder-slate-400 text-sm rounded-xl border @error('address') border-rose-400 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:border-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-500/15 transition-all duration-200 resize-none">{{ old('address') }}</textarea>
                </div>
                @error('address')
                    <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2-Column: Password & Confirm Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Password
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" 
                               name="password" 
                               :type="showPass ? 'text' : 'password'" 
                               autocomplete="new-password" 
                               required 
                               placeholder="Min. 8 characters"
                               class="block w-full pl-10 pr-9 py-2.5 bg-slate-50/50 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder-slate-400 text-sm rounded-xl border @error('password') border-rose-400 ring-2 ring-rose-100 @else border-slate-200 @enderror focus:border-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-500/15 transition-all duration-200">
                        
                        <button type="button" 
                                @click="showPass = !showPass"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition"
                                tabindex="-1">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs font-medium text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Confirm Password
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               :type="showConfirm ? 'text' : 'password'" 
                               autocomplete="new-password" 
                               required 
                               placeholder="Repeat password"
                               class="block w-full pl-10 pr-9 py-2.5 bg-slate-50/50 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder-slate-400 text-sm rounded-xl border border-slate-200 focus:border-primary-600 focus:outline-none focus:ring-4 focus:ring-primary-500/15 transition-all duration-200">
                        
                        <button type="button" 
                                @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition"
                                tabindex="-1">
                            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Terms notice -->
            <p class="text-xs text-slate-500 pt-1 leading-relaxed">
                By creating an account, you agree to our 
                <a href="{{ url('/p/terms-and-conditions') }}" class="font-medium text-primary-600 hover:underline">Terms of Service</a> 
                and 
                <a href="{{ url('/p/privacy-policy') }}" class="font-medium text-primary-600 hover:underline">Privacy Policy</a>.
            </p>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                        class="group relative w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 shadow-lg shadow-primary-600/25 hover:shadow-primary-600/35 active:scale-[0.99] transition-all duration-200">
                    <span>Create Your Free Account</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>

        <!-- Divider & Sign In Link -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500">
                Already registered with us?
                <a href="{{ route('login') }}" class="font-bold text-primary-600 hover:text-primary-700 ml-1 transition">
                    Sign in to your account &rarr;
                </a>
            </p>
        </div>

    </div>
</x-auth-layout>
