<x-admin-layout>
    <x-slot name="header">Order Details #{{ $order->order_number }}</x-slot>

    <div class="space-y-6">
        <!-- Order Header & Status -->
        <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Order #{{ $order->order_number }}</h2>
                    <p class="mt-1 text-sm text-gray-500">Placed on {{ $order->created_at->format('F d, Y at h:i A') }}</p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                     <span class="inline-flex rounded-full px-4 py-2 text-sm font-semibold leading-5 
                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                           ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                           ($order->status === 'shipped' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                        Current Status: {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            
            <!-- Status Update Form -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                 <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex flex-col sm:flex-row items-end sm:items-center gap-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="w-full sm:w-auto">
                        <label for="status" class="block text-sm font-medium text-gray-700">Update Status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto">
                        Update Status
                    </button>
                    
                     <!-- Generate Invoice Button -->
                    <a href="{{ route('admin.orders.invoice', $order) }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto">
                        Print Invoice
                    </a>

                    @if($order->status === 'delivered' && in_array(Auth::user()->role, ['admin', 'super_admin']))
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this delivered order? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
                                Delete Order
                            </button>
                        </form>
                    @endif
                </form>
            </div>

            {{-- Order Assignment Section --}}
            @if(in_array(Auth::user()->role, ['admin', 'super_admin', 'inventory_manager']))
                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Delivery Agent Assignment</h4>
                    
                    @if($order->assignedAgent)
                        <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-md p-4">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm text-green-800">
                                    Assigned to: <strong>{{ $order->assignedAgent->name }}</strong> ({{ $order->assignedAgent->email }})
                                </span>
                            </div>
                            <form action="{{ route('admin.orders.unassign', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to unassign this order?');">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                    Unassign
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('admin.orders.assign', $order) }}" method="POST" class="flex flex-col sm:flex-row items-end sm:items-center gap-4">
                            @csrf
                            <div class="w-full sm:flex-1">
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700">Select Delivery Agent</label>
                                <select id="assigned_to" name="assigned_to" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                    <option value="">-- Select Agent --</option>
                                    @foreach(\App\Models\User::whereIn('role', ['delivery_agent', 'delivery'])->get() as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->email }})</option>
                                    @endforeach
                                </select>
                                @error('assigned_to') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto">
                                Assign Order
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Customer Info -->
            <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Customer Information</h3>
                <dl class="mt-5 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->user->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->user->email }}</dd>
                    </div>
                     <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->user->phone ?? 'N/A' }}</dd>
                    </div>
                     <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Shipping Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Payment Info -->
             <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Payment Information</h3>
                <dl class="mt-5 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($order->payment_method) }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($order->payment_status) }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                        <dd class="mt-1 text-sm font-bold text-gray-900">NRS. {{ number_format($order->total_amount, 2) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Order Items</h3>
            <div class="mt-4 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Product</th>
                                        <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Quantity</th>
                                        <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Price</th>
                                        <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                <div class="flex items-center">
                                                     <div class="h-10 w-10 flex-shrink-0">
                                                        @if(isset($item->product->images) && is_array($item->product->images) && count($item->product->images) > 0)
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset($item->product->images[0]) }}" alt="">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-gray-200"></div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                                        <div class="text-gray-500">{{ $item->product->category->name ?? 'General' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{ $item->quantity }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">NRS. {{ number_format($item->price, 2) }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 text-right font-medium">NRS. {{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="row" colspan="3" class="hidden pl-4 pr-3 pt-4 text-right text-sm font-semibold text-gray-900 sm:table-cell sm:pl-6">Subtotal</th>
                                        <th scope="row" class="pl-4 pr-3 pt-4 text-left text-sm font-semibold text-gray-900 sm:hidden">Subtotal</th>
                                        <td class="pl-3 pr-4 pt-4 text-right text-sm text-gray-500 sm:pr-6">NRS. {{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                    <!-- Tax/Shipping rows could be added here -->
                                     <tr>
                                        <th scope="row" colspan="3" class="hidden pl-4 pr-3 pt-4 text-right text-base font-semibold text-gray-900 sm:table-cell sm:pl-6">Total</th>
                                        <th scope="row" class="pl-4 pr-3 pt-4 text-left text-base font-semibold text-gray-900 sm:hidden">Total</th>
                                        <td class="pl-3 pr-4 pt-4 text-right text-base font-bold text-gray-900 sm:pr-6">NRS. {{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
