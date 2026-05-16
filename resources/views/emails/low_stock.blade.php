<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #fee2e2; border-radius: 10px; }
        .header { background: #b91c1c; color: white; padding: 10px 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { padding: 20px; }
        .product-info { background: #f9fafb; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .footer { text-align: center; font-size: 0.8em; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Low Stock Alert</h1>
        </div>
        <div class="content">
            <p>Hello Admin/Inventory Manager,</p>
            <p>The following product has reached a low stock level and may need restocking soon:</p>
            
            <div class="product-info">
                <strong>Product:</strong> {{ $product->name }}<br>
                <strong>Current Stock:</strong> {{ $product->stock }}<br>
                <strong>Category:</strong> {{ $product->category->name }}
            </div>

            <p>Please log in to the admin panel to manage your inventory.</p>
            <p>Best regards,<br>The Inventory System</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Veterinary Bazzar. All rights reserved.
        </div>
    </div>
</body>
</html>
