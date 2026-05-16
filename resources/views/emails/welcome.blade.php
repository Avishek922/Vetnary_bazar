<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #15803d; color: white; padding: 10px 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 0.8em; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Veterinary Bazzar!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            <p>Thank you for joining Veterinary Bazzar, your one-stop shop for all veterinary supplies in Nepal!</p>
            <p>We are excited to have you with us. You can now browse our extensive catalog of products and manage your orders easily.</p>
            <p>If you have any questions, feel free to reply to this email.</p>
            <p>Happy shopping!</p>
            <p>Best regards,<br>The Veterinary Bazzar Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Veterinary Bazzar. All rights reserved.
        </div>
    </div>
</body>
</html>
