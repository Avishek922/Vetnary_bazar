<x-admin-layout>
    <x-slot name="header">Create Product</x-slot>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto space-y-8 bg-white p-8 rounded-lg shadow">
        @csrf
        
        <div class="space-y-8">
            <div>
                <div>
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Product Information</h3>
                    <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful what you share.</p>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <!-- Product Name -->
                    <div class="sm:col-span-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    </div>

                    <!-- Category -->
                    <div class="sm:col-span-3">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category_id" name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('description') }}</textarea>
                    </div>

                    <!-- Product Variants (Replaces Price/Stock/Sizes) -->
                    <div class="sm:col-span-6 border-t border-gray-200 pt-6 mt-6" x-data="{
                        variants: [{ size: 'Standard', price: '', buying_price: '', stock: '' }],
                        addVariant() {
                            this.variants.push({ size: '', price: '', buying_price: '', stock: '' });
                        },
                        removeVariant(index) {
                            if(this.variants.length > 1) {
                                this.variants.splice(index, 1);
                            } else {
                                alert('At least one variant is required.');
                            }
                        }
                    }">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Product Variants (Sizes & Pricing)</h3>
                                <p class="text-sm text-gray-500">Add sizes with specific pricing and stock levels. At least one variant is required.</p>
                            </div>
                            <button type="button" @click="addVariant()" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-secondary-600 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Add Variant
                            </button>
                        </div>

                        <!-- Variants Table -->
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg mb-4">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Size/Weight (e.g. 1kg)</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Selling Price</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Buying Price</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Stock</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <template x-for="(variant, index) in variants" :key="index">
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                <input type="text" :name="`variants[${index}][size]`" x-model="variant.size" required placeholder="e.g. 1kg or Standard" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <input type="number" step="0.01" :name="`variants[${index}][price]`" x-model="variant.price" required placeholder="0.00" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <input type="number" step="0.01" :name="`variants[${index}][buying_price]`" x-model="variant.buying_price" placeholder="0.00" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <input type="number" :name="`variants[${index}][stock]`" x-model="variant.stock" required placeholder="0" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <button type="button" @click="removeVariant(index)" class="text-red-600 hover:text-red-900">Remove</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                         <p class="text-xs text-gray-500">Note: Selling, Buying Price, and Stock are set per variant. Total stock is sum of all variants. Lowest selling price is shown as base price.</p>
                    </div>

                    <!-- Offer Section -->
                    <div class="sm:col-span-6 border-t border-gray-200 pt-6 mt-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Limited Time Offer (applies to all sizes)</h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                            <div>
                                <label for="offer_discount_percentage" class="block text-sm font-medium text-gray-700">Discount (%)</label>
                                <input type="number" step="1" min="0" max="100" name="offer_discount_percentage" id="offer_discount_percentage" value="{{ old('offer_discount_percentage') }}" placeholder="e.g., 20 for 20% off" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                <p class="mt-1 text-xs text-gray-500">Applies to all size prices</p>
                            </div>
                            <div>
                                <label for="offer_start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="datetime-local" name="offer_start_date" id="offer_start_date" value="{{ old('offer_start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="offer_end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="datetime-local" name="offer_end_date" id="offer_end_date" value="{{ old('offer_end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200">
                <div>
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Media & Visibility</h3>
                    <p class="mt-1 text-sm text-gray-500">Upload images and set product visibility.</p>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                     <div class="sm:col-span-6">
                        <label for="images" class="block text-sm font-medium leading-6 text-gray-900">Product Images</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-primary-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-primary-600 focus-within:ring-offset-2 hover:text-primary-500">
                                        <span>Upload files</span>
                                        <input id="file-upload" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative flex items-start sm:col-span-6">
                        <div class="flex h-6 items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input id="is_active" name="is_active" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600" checked>
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="is_active" class="font-medium text-gray-900">Active</label>
                            <p class="text-gray-500">Makes the product visible to customers immediately.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="flex justify-center gap-x-3">
                <a href="{{ route('admin.products.index') }}" class="rounded-md bg-white py-2 px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Save</button>
            </div>
        </div>
    </form>
</x-admin-layout>
