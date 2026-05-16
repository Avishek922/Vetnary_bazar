<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

            @if($cartItems->isNotEmpty())
                <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
                    <section class="lg:col-span-7">
                        <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
                            @php $total = 0; @endphp
                            @foreach($cartItems as $item)
                                @php 
                                    $price = $item->price; 
                                    $subtotal = $item->subtotal; 
                                    $total += $subtotal; 
                                    $originalPrice = $item->size ? $item->product->getPriceForSize($item->size) : $item->product->price;
                                @endphp
                                <li class="flex py-6 sm:py-10">
                                    <div class="flex-shrink-0">
                                        @if(isset($item->product->images) && count($item->product->images) > 0)
                                            <img src="{{ asset($item->product->images[0]) }}" alt="{{ $item->product->name }}" class="h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-32">
                                        @else
                                            <div class="h-24 w-24 rounded-md bg-gray-200 flex items-center justify-center text-gray-500 text-xs text-center p-1 sm:h-32 sm:w-32">No Image</div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                                        <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                            <div>
                                                <div class="flex justify-between">
                                                    <h3 class="text-sm">
                                                        <a href="{{ route('products.show', $item->product->slug) }}" class="font-medium text-gray-700 hover:text-gray-800">{{ $item->product->name }}</a>
                                                    </h3>
                                                </div>
                                                <div class="mt-1 flex text-sm flex-col">
                                                    <p class="text-gray-500">{{ $item->product->category->name ?? 'General' }}</p>
                                                    @if($item->size)
                                                        <p class="text-gray-700 font-medium">Size: {{ $item->size }}</p>
                                                    @endif
                                                </div>
                                                <div class="mt-1">
                                                    @if($item->product->hasActiveOffer())
                                                        <p class="text-sm font-medium text-red-600">NRS. {{ number_format($price, 2) }} <span class="text-xs text-gray-400 line-through ml-1">NRS. {{ number_format($originalPrice, 2) }}</span></p>
                                                    @else
                                                        <p class="text-sm font-medium text-gray-900">NRS. {{ number_format($price, 2) }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-4 sm:mt-0 sm:pr-9">
                                                <label for="quantity-{{ $item->product->id }}" class="sr-only">Quantity, {{ $item->product->name }}</label>
                                                <form action="{{ route('cart.add', ['product_id' => $item->product_id]) }}" method="POST" class="flex items-center"> <!-- Reusing add for simplicity, often simpler to have update endpoint -->
                                                    <!-- Ideally, we should implement a dedicated update endpoint in Controller. Assuming for now CartService handles update if exists. -->
                                                     <!-- Check CartController@add implementation: it calls CartService@addToCart which manages qty +=. 
                                                          We need a SET quantity method. 
                                                          Current CartController@update handles this. Route: cart.update. 
                                                          Wait, Route::put('cart/{id}', [CartController::class, 'update'])->name('cart.update');
                                                      -->
                                                </form>
                                                
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="inline-block relative">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="quantity" onchange="this.form.submit()" class="max-w-full rounded-md border border-gray-300 py-1.5 text-base leading-5 font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                                        @for($i = 1; $i <= min(10, $item->product->stock); $i++)
                                                            <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </form>

                                                <div class="absolute top-0 right-0">
                                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500">
                                                            <span class="sr-only">Remove</span>
                                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" /></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="mt-4 flex text-sm text-gray-700 space-x-2">
                                            @if($item->product->stock > 0)
                                                <svg class="flex-shrink-0 h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                                                <span>In stock</span>
                                            @else
                                                <span class="text-red-500">Out of Stock</span>
                                            @endif
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>

                    <!-- Order Summary -->
                    <section aria-labelledby="summary-heading" class="mt-16 bg-white rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5 shadow-sm sticky top-24">
                        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">NRS. {{ number_format($total, 2) }}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex items-center text-sm text-gray-600">
                                    <span>Shipping estimate</span>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">NRS. 5.00</dd> <!-- Mock Shipping -->
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Order total</dt>
                                <dd class="text-base font-medium text-gray-900">NRS. {{ number_format($total + 5, 2) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <a href="{{ route('checkout.index') }}" class="w-full bg-primary-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-primary-500 flex justify-center">Checkout</a>
                        </div>
                        
                         <div class="mt-6 text-center text-sm">
                            <p>or <a href="{{ route('products.index') }}" class="font-medium text-primary-600 hover:text-primary-500">Continue Shopping<span aria-hidden="true"> &rarr;</span></a></p>
                        </div>
                    </section>
                </div>
            @else
                <div class="text-center py-24 bg-white rounded-lg shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Cart is empty</h3>
                    <p class="mt-1 text-sm text-gray-500">Start adding some items to your cart.</p>
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Go Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
