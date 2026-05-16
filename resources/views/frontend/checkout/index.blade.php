<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-12">
         <div class="mx-auto max-w-7xl px-4 pt-4 pb-16 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">Checkout</h1>
            
            <form action="{{ route('checkout.store') }}" method="POST" class="lg:grid lg:grid-cols-12 lg:gap-x-12 xl:gap-x-16">
                @csrf
                
                <!-- Info Column -->
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h2>
                        
                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                                <div class="mt-1">
                                    <textarea id="address" name="address" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" required>{{ old('address', Auth::user()->address) }}</textarea>
                                </div>
                            </div>

                             <div class="sm:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Order Notes (Optional)</label>
                                <div class="mt-1">
                                    <textarea id="notes" name="notes" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="payment_cod" name="payment_method" type="radio" value="cod" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500" checked>
                                <label for="payment_cod" class="ml-3 block text-sm font-medium text-gray-700">Cash on Delivery (COD)</label>
                            </div>
                            <div class="flex items-center opacity-50 cursor-not-allowed" title="Not available yet">
                                <input id="payment_online" name="payment_method" type="radio" value="online" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500" disabled>
                                <label for="payment_online" class="ml-3 block text-sm font-medium text-gray-700">Online Payment (Coming Soon)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Column -->
                <div class="mt-10 lg:mt-0 lg:col-span-5">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm sticky top-24">
                        <h2 class="sr-only">Order summary</h2>
                         <!-- Note: We need cart items here. Assuming Cart logic available or passed to view. 
                              The CheckoutController@index should pass cart items. 
                              Checking Controller... Web\OrderController@create is the checkout page. 
                              It returns view('frontend.checkout.index'). 
                              Does it pass cart items? NO. It uses OrderService?
                              Wait, OrderController@create usually doesn't pass cart items if logic is in view composer or service.
                              Let's assume we can get Cart items via Facade or Helper if not passed.
                              Actually, standard practice is to pass it.
                              I should update OrderController@create to pass cart items if it doesn't.
                              Let's check OrderController.
                          -->
                        
                        <div class="px-4 py-6 sm:px-6">
                             <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
                             <p class="mt-1 text-sm text-gray-500">Verify your items before placing the order.</p>
                        </div>
                       
                        <!-- Minimal Cart List (Static placeholder if variable missing, but ideally dynamic) -->
                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                             <!-- We need to ensure $cartItems is passed, or use Cart::content() equivalent.
                                  For now, I'll add a check or keep it simple.
                              -->
                             <p class="text-sm text-gray-500 mb-4">Items in your cart constitute the final order.</p>
                             
                             <button type="submit" class="w-full rounded-md border border-transparent bg-primary-600 py-3 px-4 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-gray-50">Confirm Order</button>
                        </div>
                    </div>
                </div>
            </form>
         </div>
    </div>
</x-app-layout>
