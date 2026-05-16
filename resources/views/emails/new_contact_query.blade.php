<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #374151; background-color: #f9fafb; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; }
        .header { background-color: #059669; color: #ffffff; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .footer { background-color: #f3f4f6; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; }
        .label { font-weight: 600; color: #111827; margin-bottom: 4px; display: block; }
        .value { background-color: #f9fafb; padding: 12px; border-radius: 6px; border: 1px solid #f3f4f6; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #059669; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">New Inquiry Received</h1>
        </div>
        <div class="content">
            <p>You have received a new message from the <strong>Contact Us</strong> page.</p>
            
            <span class="label">Sender Name:</span>
            <div class="value">{{ $query->name }}</div>

            <span class="label">Email Address:</span>
            <div class="value">{{ $query->email }}</div>

            <span class="label">Phone Number:</span>
            <div class="value">{{ $query->phone }}</div>

            <span class="label">Message:</span>
            <div class="value" style="white-space: pre-wrap;">{{ $query->message }}</div>

            <div style="text-align: center;">
                <a href="{{ url('/admin/queries/' . $query->id) }}" class="btn">View in Admin Panel</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Veterinary Bazzar. All rights reserved.
        </div>
    </div>
</body>
</html>
