<x-app-layout>
    <div class="bg-gray-50" x-data="{ mobileFiltersOpen: false }">
        <!-- Mobile Filter Dialog -->
        <div x-show="mobileFiltersOpen" class="relative z-40 lg:hidden" role="dialog" aria-modal="true" style="display: none;">
            <div x-show="mobileFiltersOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-25" @click="mobileFiltersOpen = false"></div>

            <div x-show="mobileFiltersOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed inset-0 z-40 flex">
                <div class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                    <div class="flex items-center justify-between px-4">
                        <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                        <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400" @click="mobileFiltersOpen = false">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <!-- Mobile Filters Form -->
                    <form action="{{ route('products.index') }}" method="GET" class="mt-4 border-t border-gray-200">
                        <div class="px-4 py-6">
                            <h3 class="text-sm font-medium text-gray-900">Search</h3>
                            <div class="mt-2">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full rounded-md border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                        <div class="px-4 py-6">
                            <h3 class="text-sm font-medium text-gray-900">Categories</h3>
                            <ul role="list" class="mt-2 space-y-2">
                                <li>
                                    <a href="{{ route('products.index') }}" class="{{ !request('category_id') ? 'text-primary-600 font-bold' : 'text-gray-600' }} block text-sm hover:text-primary-500 transition">All Products</a>
                                </li>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('products.index', ['category_id' => $category->hash_id]) }}" class="{{ request('category_id') == $category->hash_id ? 'text-primary-600 font-bold' : 'text-gray-600' }} block text-sm hover:text-primary-500 transition">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="px-4 py-6">
                            <button type="submit" class="w-full bg-primary-600 text-white rounded-md py-2 text-sm font-medium hover:bg-primary-700">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-10">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">All Products</h1>

                <div class="flex items-center">
                    <div class="relative" x-data="{ sortOpen: false }">
                        <button type="button" @click="sortOpen = !sortOpen" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" id="menu-button" aria-expanded="false" aria-haspopup="true">
                            Sort
                            <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="sortOpen" @click.away="sortOpen = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" class="{{ request('sort', 'newest') == 'newest' ? 'font-medium text-gray-900' : 'text-gray-500' }} block px-4 py-2 text-sm hover:bg-gray-50">Newest</a>
                                <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}" class="{{ request('sort') == 'price_low' ? 'font-medium text-gray-900' : 'text-gray-500' }} block px-4 py-2 text-sm hover:bg-gray-50">Price: Low to High</a>
                                <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}" class="{{ request('sort') == 'price_high' ? 'font-medium text-gray-900' : 'text-gray-500' }} block px-4 py-2 text-sm hover:bg-gray-50">Price: High to Low</a>
                                <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'name_asc'])) }}" class="{{ request('sort') == 'name_asc' ? 'font-medium text-gray-900' : 'text-gray-500' }} block px-4 py-2 text-sm hover:bg-gray-50">Name: A-Z</a>
                                <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'name_desc'])) }}" class="{{ request('sort') == 'name_desc' ? 'font-medium text-gray-900' : 'text-gray-500' }} block px-4 py-2 text-sm hover:bg-gray-50">Name: Z-A</a>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden" @click="mobileFiltersOpen = true">
                        <span class="sr-only">Filters</span>
                        <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <section aria-labelledby="products-heading" class="pb-24 pt-6">
                <!-- Mobile Search Bar -->
                <div class="lg:hidden mb-6">
                    <form action="{{ route('products.index') }}" method="GET" class="bg-white p-4 rounded-lg shadow-sm">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full rounded-md border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500 pr-10">
                            <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                    <!-- Filters (Desktop) -->
                    <form action="{{ route('products.index') }}" method="GET" class="hidden lg:block space-y-8">
                        <!-- Preserve sort parameter -->
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 border-b border-gray-200 pb-3">Search</h3>
                            <div class="mt-4">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="What are you looking for?" class="w-full rounded-md border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500 pr-10">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                         <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 border-b border-gray-200 pb-3">Categories</h3>
                            <ul role="list" class="mt-4 space-y-2">
                                <li>
                                    <a href="{{ route('products.index') }}" class="{{ !request('category_id') ? 'text-primary-600 font-bold' : 'text-gray-600' }} block text-sm hover:text-primary-500 transition">All Products</a>
                                </li>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('products.index', ['category_id' => $category->hash_id]) }}" class="{{ request('category_id') == $category->hash_id ? 'text-primary-600 font-bold' : 'text-gray-600' }} block text-sm hover:text-primary-500 transition">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="pt-4">
                             <button type="submit" class="w-full bg-primary-600 text-white rounded-md py-2.5 text-sm font-semibold hover:bg-primary-700 shadow-sm transition">
                                Apply Filters
                             </button>
                             @if(request()->hasAny(['search', 'category_id', 'category']))
                                <a href="{{ route('products.index') }}" class="mt-3 block w-full text-center text-sm text-gray-500 hover:text-gray-700">Clear all filters</a>
                             @endif
                        </div>
                    </form>

                    <!-- Product Grid -->
                    <div class="lg:col-span-3">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden group flex flex-col h-full">
                                    <div class="relative h-64 bg-gray-100 overflow-hidden">
                                        @if(isset($product->images) && is_array($product->images) && count($product->images) > 0)
                                            <img src="{{ asset($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="flex items-center justify-center h-full text-gray-400">
                                                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                        <!-- Quick Badge -->
                                        @if($product->stock < 5 && $product->stock > 0)
                                            <span class="absolute top-2 right-2 bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">Low Stock</span>
                                        @endif
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <div class="text-xs text-gray-500 mb-1">{{ $product->category->name ?? 'General' }}</div>
                                        <h3 class="text-sm font-bold text-gray-900 flex-1 hover:text-primary-600 transition">
                                            <a href="{{ route('products.show', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <div class="mt-4 flex items-center justify-between">
                                            @if($product->hasActiveOffer())
                                                <div>
                                                    <p class="text-lg font-bold text-red-600">NRS. {{ number_format($product->sell_price, 2) }}</p>
                                                    <p class="text-xs text-gray-400 line-through">NRS. {{ number_format($product->first_price, 2) }}</p>
                                                </div>
                                            @else
                                                <p class="text-lg font-bold text-gray-900">NRS. {{ number_format($product->first_price, 2) }}</p>
                                            @endif
                                            @if($product->stock > 0)
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="p-2 bg-primary-50 text-primary-600 rounded-full hover:bg-primary-600 hover:text-white transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                </button>
                                            </form>
                                            @else
                                                <span class="text-sm text-red-500 font-medium">Out of Stock</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination (Mock for now, assume standard Laravel pagination) -->
                        <div class="mt-10">
                            {{-- {{ $products->links() }} --}}
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</x-app-layout>
