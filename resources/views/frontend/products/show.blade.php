<x-app-layout>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <!-- Image Gallery -->
                <div class="flex flex-col-reverse" x-data="{ activeImage: 0 }">
                    <!-- Thumbnail Images -->
                    @if(isset($product->images) && is_array($product->images) && count($product->images) > 1)
                        <div class="mx-auto mt-6 w-full max-w-2xl sm:block lg:max-w-none">
                            <div class="grid grid-cols-4 gap-3">
                                @foreach($product->images as $index => $image)
                                    <button 
                                        type="button"
                                        @click.prevent="activeImage = {{ $index }}"
                                        :class="activeImage === {{ $index }} ? 'ring-2 ring-primary-500' : 'ring-1 ring-gray-200'"
                                        class="relative flex h-20 cursor-pointer items-center justify-center rounded-md bg-white text-sm font-medium uppercase text-gray-900 hover:bg-gray-50 focus:outline-none overflow-hidden transition">
                                        <img src="{{ asset($image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Main Image Display -->
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-100 sm:aspect-h-3 sm:aspect-w-2">
                        @if(isset($product->images) && is_array($product->images) && count($product->images) > 0)
                            @foreach($product->images as $index => $image)
                                <img 
                                    x-show="activeImage === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    src="{{ asset($image) }}" 
                                    alt="{{ $product->name }}" 
                                    class="h-full w-full object-cover object-center sm:rounded-lg">
                            @endforeach
                        @else
                            <div class="flex items-center justify-center h-96 text-gray-400">
                                No Image Available
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0" x-data="{ 
                    selectedSize: '{{ (is_array($product->sizes) && count($product->sizes) > 0) ? ($product->sizes[0]['size'] ?? $product->sizes[0]) : '' }}',
                    allSizes: {{ json_encode($product->sizes ?? []) }},
                    basePrice: {{ $product->price ?? 0 }},
                    baseStock: {{ $product->stock ?? 0 }},
                    discount: {{ $product->offer_discount_percentage ?? 0 }},
                    fixedOfferPrice: {{ $product->offer_price ?? 0 }},
                    hasOffer: {{ $product->hasActiveOffer() ? 'true' : 'false' }},
                    
                    getPrice() {
                        if (this.allSizes.length > 0 && typeof this.allSizes[0] === 'object') {
                            let sizeData = this.allSizes.find(s => s.size === this.selectedSize);
                            return sizeData ? Number(sizeData.price) : Number(this.basePrice);
                        }
                        return Number(this.basePrice);
                    },
                    getStock() {
                        if (this.allSizes.length > 0 && typeof this.allSizes[0] === 'object') {
                            let sizeData = this.allSizes.find(s => s.size === this.selectedSize);
                            return sizeData ? (sizeData.stock !== undefined ? Number(sizeData.stock) : Number(this.baseStock)) : Number(this.baseStock);
                        }
                        return Number(this.baseStock);
                    },
                    getOfferPrice() {
                        let price = this.getPrice();
                        if (this.hasOffer) {
                            if (this.discount > 0) {
                                return price * (1 - this.discount / 100);
                            }
                            if (this.fixedOfferPrice > 0 && this.basePrice > 0) {
                                let impliedDiscount = (this.basePrice - this.fixedOfferPrice) / this.basePrice;
                                return price * (1 - impliedDiscount);
                            }
                        }
                        return price;
                    }
                }">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $product->name }}</h1>

                    <div class="mt-4">
                        <h2 class="sr-only">Product information</h2>
                        <div class="flex flex-col sm:flex-row sm:items-baseline gap-4">
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl tracking-tight text-primary-600 font-bold">
                                    NRS. <span x-text="new Number(getOfferPrice()).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                                </p>
                                <template x-if="hasOffer">
                                    <p class="text-lg text-gray-400 line-through">
                                        NRS. <span x-text="new Number(getPrice()).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                                    </p>
                                </template>
                            </div>
                            <template x-if="hasOffer">
                                <span class="self-start inline-flex items-center rounded-md bg-red-600 px-3 py-1 text-sm font-bold text-white shadow-sm">
                                    Save <span x-text="discount"></span>%
                                </span>
                            </template>
                        </div>
                        @if($product->offer_end_date)
                            <p class="mt-2 text-sm font-medium text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Offer ends in: {{ $product->offer_end_date->diffForHumans() }}
                            </p>
                        @endif
                    </div>

                    <!-- Reviews Summary -->
                    <div class="mt-3">
                         <div class="flex items-center">
                            <div class="flex items-center text-yellow-400">
                                @php $avgRating = $product->reviews->avg('rating') ?? 0; @endphp
                                @for($i=1; $i<=5; $i++)
                                    <svg class="h-5 w-5 flex-shrink-0 {{ $i <= $avgRating ? 'text-yellow-400' : 'text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" /></svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-500">{{ number_format($avgRating, 1) }} ({{ $product->reviews->count() }} reviews)</span>
                         </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="sr-only">Description</h3>
                        <div class="space-y-6 text-base text-gray-700">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <!-- Size Options (Radio Cards) -->
                            @if(isset($product->sizes) && is_array($product->sizes) && count($product->sizes) > 0)
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Size/Weight</label>
                                    <div class="grid grid-cols-3 gap-3">
                                        @foreach($product->sizes as $sizeData)
                                            @php 
                                                $sizeName = is_array($sizeData) ? $sizeData['size'] : $sizeData;
                                            @endphp
                                            <label class="relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 cursor-pointer transition"
                                                   :class="selectedSize === '{{ $sizeName }}' ? 'bg-primary-600 border-transparent text-white hover:bg-primary-700 shadow-md ring-2 ring-primary-500 ring-offset-2' : 'bg-white border-gray-200 text-gray-900 hover:border-gray-300'">
                                                <input type="radio" name="size" value="{{ $sizeName }}" class="sr-only" @click="selectedSize = '{{ $sizeName }}'" {{ $loop->first ? 'checked' : '' }}>
                                                <span>{{ $sizeName }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <template x-if="getStock() > 0">
                                 <div>
                                     <div class="p-4 bg-green-50 rounded-md mb-6 border border-green-100">
                                        <p class="text-green-800 font-medium text-sm flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            In Stock and Ready to Ship
                                        </p>
                                     </div>

                                    <div class="flex items-center gap-4 mb-6">
                                        <label for="quantity" class="sr-only">Quantity</label>
                                        <div class="flex items-center border border-gray-300 rounded-md shadow-sm" x-data="{ qty: 1 }">
                                            <button type="button" @click="qty > 1 ? qty-- : null" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition rounded-l-md">-</button>
                                            <input type="number" name="quantity" id="quantity" x-model="qty" min="1" :max="getStock()" class="w-16 text-center border-0 focus:ring-0 p-0 text-gray-900 font-medium" readonly>
                                            <button type="button" @click="qty < getStock() ? qty++ : null" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition rounded-r-md">+</button>
                                        </div>
                                        <span class="text-sm text-gray-500"><span x-text="getStock()"></span> items available</span>
                                    </div>

                                    <button type="submit" class="flex w-full items-center justify-center rounded-md border border-transparent bg-primary-600 px-8 py-3 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition shadow-md hover:shadow-lg">Add to Cart</button>
                                 </div>
                            </template>

                            <template x-if="getStock() <= 0">
                                <div class="p-4 bg-red-50 rounded-md border border-red-100">
                                    <p class="text-red-800 font-medium flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Currently Out of Stock
                                    </p>
                                </div>
                            </template>
                        </form>
                    </div>

                    <!-- Specifications (Mock) -->
                    <section class="mt-12 border-t pt-12">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Specifications</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                             @if(isset($product->category))
                            <div class="border-t border-gray-200 pt-4">
                                <dt class="font-medium text-gray-900">Category</dt>
                                <dd class="mt-2 text-sm text-gray-500">{{ $product->category->name }}</dd>
                            </div>
                            @endif
                            <div class="border-t border-gray-200 pt-4">
                                <dt class="font-medium text-gray-900">SKU</dt>
                                <dd class="mt-2 text-sm text-gray-500">VET-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</dd>
                            </div>
                        </dl>
                    </section>

                    <!-- Reviews Section -->
                    <section class="mt-12 border-t pt-12">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Customer Reviews</h2>
                        
                        <div class="bg-gray-50 p-6 rounded-lg mb-8">
                            <h3 class="text-md font-medium text-gray-900">Write a Review</h3>
                            @auth
                                <form action="{{ route('reviews.store', $product) }}" method="POST" class="mt-4 space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Rating</label>
                                        <div class="flex items-center mt-1 gap-2">
                                            @for($i=1; $i<=5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer">
                                                    <svg class="w-6 h-6 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                </label>
                                            @endfor
                                        </div>
                                        @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="comment" class="block text-sm font-medium text-gray-700">Review</label>
                                        <textarea id="comment" name="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="Share your thoughts..."></textarea>
                                        @error('comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none">Submit Review</button>
                                </form>
                            @else
                                <p class="mt-4 text-sm text-gray-600">Please <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-500 font-medium">log in</a> to write a review.</p>
                            @endauth
                        </div>

                        <div class="space-y-6">
                            @forelse($product->reviews()->where('is_approved', true)->latest()->get() as $review)
                                <div class="flex space-x-4 text-sm text-gray-500">
                                    <div class="flex-none py-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-500">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 py-10">
                                        <h3 class="font-medium text-gray-900">{{ $review->user->name }}</h3>
                                        <p><time datetime="{{ $review->created_at }}">{{ $review->created_at->format('M d, Y') }}</time></p>
                                        <div class="flex items-center mt-1">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                        <div class="prose prose-sm mt-2 max-w-none text-gray-500">
                                            <p>{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">No reviews yet.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
