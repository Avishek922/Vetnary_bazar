<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #1e293b; color: white; padding: 10px 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { padding: 20px; }
        .order-details { margin: 20px 0; border-collapse: collapse; width: 100%; }
        .order-details th, .order-details td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .order-details th { background-color: #f2f2f2; }
        .total { font-weight: bold; text-align: right; margin-top: 10px; }
        .footer { text-align: center; font-size: 0.8em; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Order Alert!</h1>
        </div>
        <div class="content">
            <p>Hello Admin,</p>
            <p>A new order has been placed on <strong>Veterinary Bazzar</strong>.</p>
            
            <h3>Order Information:</h3>
            <ul>
                <li><strong>Order Number:</strong> #{{ $order->order_number }}</li>
                <li><strong>Customer:</strong> {{ $order->user->name }} ({{ $order->user->email }})</li>
                <li><strong>Total Amount:</strong> NRS. {{ number_format($order->total_amount, 2) }}</li>
                <li><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</li>
            </ul>

            <h3>Items:</h3>
            <table class="order-details">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>NRS. {{ number_format($item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p><strong>Shipping Address:</strong><br>{{ $order->delivery_address }}</p>

            <div style="margin-top: 30px; text-align: center;">
                <a href="{{ url('/admin/orders/' . $order->id) }}" style="background: #15803d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">View Order in Admin Panel</a>
            </div>
        </div>
        <div class="footer">
            Admin Notification System - Veterinary Bazzar
        </div>
    </div>
</body>
</html>
