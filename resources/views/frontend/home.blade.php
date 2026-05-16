<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-primary-900 overflow-hidden min-h-[500px] flex items-center">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="{{ asset('images/banners/home-banner.jpg') }}" alt="Veterinary Care">
            <div class="absolute inset-0 bg-primary-900/40 mix-blend-multiply"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">We Care for Your Pets <br class="hidden sm:block">Like Family</h1>
            <p class="mt-6 text-xl text-primary-100 max-w-3xl">Premium veterinary products, specialized foods, and care items delivered right to your doorstep. Trust VetBazzar for quality and reliability.</p>
            
            <div class="mt-10 max-w-sm sm:flex sm:max-w-none">
                <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-2 sm:gap-5">
                    <a href="{{ route('products.index') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-primary-700 bg-white hover:bg-gray-50 sm:px-8">Shop Now</a>
                    <a href="{{ route('pages.show', 'about-us') }}" :active="request()->routeIs('pages.show') && request()->route('slug') == 'about-us'" class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 bg-opacity-60 hover:bg-opacity-70 sm:px-8">Learn More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-4 lg:gap-x-8">
                <div class="text-center group">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mx-auto group-hover:bg-primary-600 group-hover:text-white transition duration-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Quality Guaranteed</h3>
                    <p class="mt-2 text-base text-gray-500">100% authentic products sourced directly from trusted manufacturers.</p>
                </div>
                <div class="text-center group">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mx-auto group-hover:bg-primary-600 group-hover:text-white transition duration-300">
                         <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Fast Delivery</h3>
                    <p class="mt-2 text-base text-gray-500">Same-day dispatch for orders placed before 2 PM. Real-time tracking.</p>
                </div>
                <div class="text-center group">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mx-auto group-hover:bg-primary-600 group-hover:text-white transition duration-300">
                         <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">24/7 Support</h3>
                    <p class="mt-2 text-base text-gray-500">Expert veterinary advice and customer support whenever you need it.</p>
                </div>
                 <div class="text-center group">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mx-auto group-hover:bg-primary-600 group-hover:text-white transition duration-300">
                         <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Best Prices</h3>
                    <p class="mt-2 text-base text-gray-500">Competitive pricing on all premium brands. Save more with auto-ship.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Showcase -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-8 text-center">Shop by Category</h2>
             <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <div class="group relative bg-white rounded-lg shadow-sm hover:shadow-lg transition overflow-hidden">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 group-hover:opacity-75">
                             @php 
                                $img_urls = [
                                    'Dogs' => 'https://images.unsplash.com/photo-1543466835-00a7907e9de1', 
                                    'Cats' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba', 
                                    'Birds' => 'https://images.unsplash.com/photo-1444464666168-49d633b86797', 
                                    'Small Pets' => 'https://images.unsplash.com/photo-1425082661705-1834bfd09dca'
                                ];
                                $default_img = 'https://images.unsplash.com/photo-1596272875729-ed2c21ebbb77';
                                
                                if ($category->image) {
                                    $img = asset($category->image);
                                } else {
                                    $img = $img_urls[$category->name] ?? $default_img;
                                    $img .= "?auto=format&fit=crop&w=800&q=80";
                                }
                             @endphp
                             <img src="{{ $img }}" class="h-48 w-full object-cover object-center">
                        </div>
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <h3 class="text-lg font-bold text-white">{{ $category->name }}</h3>
                        </div>
                        <a href="{{ route('home', ['category' => $category->slug]) }}#products" class="absolute inset-0 focus:outline-none">
                            <span class="sr-only">View category {{ $category->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Limited Time Offers -->
    @if(isset($offerProducts) && $offerProducts->count() > 0)
    <div class="bg-red-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-extrabold tracking-tight text-red-900">🔥 Limited Time Offers</h2>
                <a href="{{ route('products.index', ['sort' => 'price_low']) }}" class="text-sm font-medium text-red-600 hover:text-red-500">View all offers <span aria-hidden="true"> &rarr;</span></a>
            </div>
            <div class="grid grid-cols-2 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                @foreach($offerProducts as $product)
                    <div class="group relative bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-80">
                             @if(isset($product->images) && count($product->images) > 0)
                                <img src="{{ asset($product->images[0]) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-400">No Image</div>
                            @endif
                            <div class="absolute top-0 right-0 p-2">
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                    {{ $product->discount_percentage }}% OFF
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $product->category->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-red-600">NRS. {{ number_format($product->sell_price, 2) }}</p>
                                <p class="text-xs text-gray-400 line-through">NRS. {{ number_format($product->first_price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Featured Products -->
    <div class="bg-white py-16" id="products">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                 <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">
                    @if(request('category'))
                        Products in Category: {{ $featuredProducts->first()->category->name ?? 'Selected Category' }}
                    @elseif(request('search'))
                        Search Results for "{{ request('search') }}"
                    @else
                        Featured Products
                    @endif
                 </h2>
                 <div class="flex gap-4">
                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 font-medium">Clear Filters</a>
                    @endif
                    <a href="{{ route('products.index') }}" class="text-primary-600 hover:text-primary-800 font-semibold">View All &rarr;</a>
                 </div>
            </div>
           
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden group flex flex-col h-full">
                        <div class="relative h-64 bg-gray-100 overflow-hidden">
                            @if(isset($product->images) && is_array($product->images) && count($product->images) > 0)
                                <img src="{{ asset($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                            @endif
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="text-sm font-bold text-gray-900 flex-1 hover:text-primary-600 transition">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <div class="mt-4 flex items-center justify-between">
                                @if($product->hasActiveOffer())
                                    <div class="flex flex-col">
                                        <span class="text-lg font-bold text-red-600">NRS. {{ number_format($product->sell_price, 2) }}</span>
                                        <span class="text-xs text-gray-400 line-through">NRS. {{ number_format($product->first_price, 2) }}</span>
                                    </div>
                                @else
                                    <span class="text-lg font-bold text-gray-900">NRS. {{ number_format($product->first_price, 2) }}</span>
                                @endif
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="p-2 rounded-full bg-primary-100 text-primary-600 hover:bg-primary-600 hover:text-white transition shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-gray-50 rounded-lg border border-gray-100">
                        <p class="text-gray-500 mb-4">Discover our range of premium products.</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-primary-600 text-white px-6 py-3 rounded-md hover:bg-primary-700 transition">Go to Shop</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Our Team -->
    @if($teamMembers->count() > 0)
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Meet Our Service Provider Team</h2>
                <p class="mt-4 text-lg text-gray-600">Dedicated professionals committed to your pet's health and happiness</p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($teamMembers as $member)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="aspect-w-3 aspect-h-4">
                            <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="w-full h-64 object-cover object-center">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ $member->name }}</h3>
                            <p class="text-sm text-primary-600 font-medium mt-1">{{ $member->designation }}</p>
                            <p class="mt-3 text-sm text-gray-600">{{ Str::limit($member->description, 100) }}</p>
                            
                           <!--  @if($member->facebook_url || $member->instagram_url || $member->twitter_url || $member->tiktok_url)
                                <div class="mt-4 flex space-x-3">
                                    @if($member->facebook_url)
                                        <a href="{{ $member->facebook_url }}" target="_blank" class="text-gray-400 hover:text-blue-600 transition">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        </a>
                                    @endif
                                    @if($member->instagram_url)
                                        <a href="{{ $member->instagram_url }}" target="_blank" class="text-gray-400 hover:text-pink-600 transition">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
                                        </a>
                                    @endif
                                    @if($member->twitter_url)
                                        <a href="{{ $member->twitter_url }}" target="_blank" class="text-gray-400 hover:text-blue-400 transition">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                        </a>
                                    @endif
                                    @if($member->tiktok_url)
                                        <a href="{{ $member->tiktok_url }}" target="_blank" class="text-gray-400 hover:text-black transition">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            @endif -->
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
