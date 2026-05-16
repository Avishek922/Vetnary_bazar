<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order #{{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <div class="text-sm text-gray-500">Placed on {{ $order->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">Status: <span class="font-bold">{{ ucfirst($order->status) }}</span></div>
                    </div>
                    <div class="text-xl font-bold">
                        Total: NRS. {{ number_format($order->total_amount, 2) }}
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">Items</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="pb-2">Product</th>
                                <th class="pb-2">Price</th>
                                <th class="pb-2">Quantity</th>
                                <th class="pb-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr class="border-b last:border-0">
                                    <td class="py-2">{{ $item->product->name }}</td>
                                    <td class="py-2">NRS. {{ number_format($item->price, 2) }}</td>
                                    <td class="py-2">{{ $item->quantity }}</td>
                                    <td class="py-2 font-bold">NRS. {{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-bold text-lg mb-2">Shipping Address</h3>
                        <p class="whitespace-pre-line text-gray-700">{{ $order->delivery_address }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Payment Method</h3>
                        <p class="text-gray-700">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
