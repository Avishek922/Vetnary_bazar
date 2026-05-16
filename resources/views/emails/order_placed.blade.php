<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #15803d; color: white; padding: 10px 20px; border-radius: 10px 10px 0 0; text-align: center; }
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
            <h1>Order Recieved!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $order->user->name }},</p>
            <p>Thank you for your order! We have received your order <strong>#{{ $order->order_number }}</strong> and are currently processing it.</p>
            
            <h3>Order Summary:</h3>
            <table class="order-details">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
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
            <div class="total">
                Subtotal: NRS. {{ number_format($order->total_amount, 2) }}<br>
                <strong>Total: NRS. {{ number_format($order->total_amount, 2) }}</strong>
            </div>

            <p><strong>Shipping Address:</strong><br>{{ $order->delivery_address }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</p>

            <p>We will notify you once your order has been shipped!</p>
            <p>Best regards,<br>The Veterinary Bazzar Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Veterinary Bazzar. All rights reserved.
        </div>
    </div>
</body>
</html>
