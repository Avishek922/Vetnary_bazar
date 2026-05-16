<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; font-size: 16px; line-height: 24px; }
        .invoice-title { font-size: 28px; font-weight: bold; margin-bottom: 20px; color: #059669; }
        .company-info, .customer-info { margin-bottom: 40px; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table th { background: #f3f4f6; padding: 10px; border-bottom: 1px solid #ddd; }
        table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total-row td { border-top: 2px solid #ddd; font-weight: bold; }
        .text-right { text-align: right; }
        .footer { margin-top: 50px; font-size: 12px; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="invoice-title">VetBazzar Invoice</div>
        
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="company-info">
                                <strong>VetBazzar Veterinary Shop</strong><br>
                                Birgunj,Parsa,Nepal<br>
                                Phone: +977-9814295445<br>
                                Email: support@vetbazzar.com
                            </td>
                            <td class="text-right">
                                <strong>Invoice #:</strong> {{ $order->order_number }}<br>
                                <strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}<br>
                                <strong>Status:</strong> {{ ucfirst($order->status) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="customer-info">
                                <strong>Bill To:</strong><br>
                                {{ $order->user->name }}<br>
                                {{ $order->user->email }}<br>
                                {{ $order->delivery_address ?? $order->shipping_address }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">NRS. {{ number_format($item->price, 2) }}</td>
                        <td class="text-right">NRS. {{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right">Total</td>
                    <td class="text-right">NRS. {{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            Thank you for shopping with VetBazzar!<br>
            This is a computer generated invoice.
        </div>
    </div>
</body>
</html>
