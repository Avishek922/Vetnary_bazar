<x-auth-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Verify OTP
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    We've sent a 6-digit code to <strong>{{ session('email') }}</strong>
                </p>
            </div>

            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </h3>
                        </div>
                    </div>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('password.verify-otp') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">
                
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">Enter OTP Code</label>
                    <input id="otp" name="otp" type="text" maxlength="6" required 
                           class="appearance-none rounded-lg relative block w-full px-3 py-4 border border-gray-300 placeholder-gray-500 text-gray-900 text-center text-2xl font-bold tracking-widest focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-3xl" 
                           placeholder="000000" 
                           pattern="[0-9]{6}"
                           autocomplete="off">
                    <p class="mt-2 text-xs text-gray-500 text-center">OTP expires in 10 minutes</p>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition">
                        Verify OTP
                    </button>
                </div>

                <div class="text-center space-y-2">
                    <a href="{{ route('password.request') }}" class="font-medium text-primary-600 hover:text-primary-500 block">
                        Request new OTP
                    </a>
                    <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-gray-500 block">
                        Back to login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-auth-layout>
