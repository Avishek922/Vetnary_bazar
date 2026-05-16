<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #374151; background-color: #f9fafb; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; }
        .header { background-color: #059669; color: #ffffff; padding: 30px; text-align: center; }
        .content { padding: 40px 30px; text-align: center; }
        .otp-box { background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff; font-size: 36px; font-weight: bold; letter-spacing: 8px; padding: 20px; border-radius: 8px; margin: 30px 0; display: inline-block; }
        .footer { background-color: #f3f4f6; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; }
        .warning { background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px; margin: 20px 0; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">Password Reset Request</h1>
        </div>
        <div class="content">
            <p style="font-size: 16px; color: #111827;">Hello,</p>
            <p style="color: #6b7280;">We received a request to reset your password. Use the OTP code below to proceed:</p>
            
            <div class="otp-box">{{ $otp }}</div>

            <div class="warning">
                <strong>⏱️ This OTP will expire in 10 minutes</strong><br>
                If you didn't request this password reset, please ignore this email.
            </div>

            <p style="color: #6b7280; font-size: 14px; margin-top: 30px;">
                For security reasons, never share this OTP with anyone.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Veterinary Bazzar. All rights reserved.
        </div>
    </div>
</body>
</html>
